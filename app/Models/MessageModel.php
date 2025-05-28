<?php

class Message
{
    private ?Database $db = null;
    private ?PDO $dbConn = null;
    public ?string $error = null;
    public ?string $errno = null;
    /**
     * @var LogHandler $logger
     * A logger instance used for handling logging operations within the ResponseHandler utility.
     */
    private LogHandler $logger;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->dbConn = $this->db->getConn();
        $this->logger = LogHandler::getInstance();
    }

    public function addMessage(string $content, int $authorId): bool
    {
        try {
            $stmt = $this->dbConn->prepare("INSERT INTO messages (content, author_id) VALUES (:content, :author_id)");
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author_id', $authorId);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->errno = $e->getCode();
            $this->logger->error($this->error);
            return false;
        }
    }

    public function isAuthor(int $messageId, int $authorId): bool
    {
        try {
            $stmt = $this->dbConn->prepare("SELECT author_id FROM messages WHERE id = :messageId");
            $stmt->bindParam(':messageId', $messageId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['author_id'] == $authorId) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->errno = $e->getCode();
            $this->logger->error($this->error);
            return false;
        }
    }

	public function deleteMessage(int $messageId): bool
		{
				try {
						$stmt = $this->dbConn->prepare("DELETE FROM messages WHERE id = :messageId");
						$stmt->bindParam(':messageId', $messageId);
						$result = $stmt->execute();

						if ($result) {
								return true;
						} else {
								return false;
						}
				} catch (PDOException $e) {
						$this->error = $e->getMessage();
						$this->errno = $e->getCode();
						$this->logger->error($this->error);
						return false;
				}
		}

	public function editMessage(int $messageId, string $content): bool
		{
				try {
						$stmt = $this->dbConn->prepare("UPDATE messages SET content = :content, updated_at = NOW() WHERE id = :messageId");
						$stmt->bindParam(':content', $content);
						$stmt->bindParam(':messageId', $messageId);
						$result = $stmt->execute();

						if ($result) {
								return true;
						} else {
								return false;
						}
				} catch (PDOException $e) {
						$this->error = $e->getMessage();
						$this->errno = $e->getCode();
						$this->logger->error($this->error);
						return false;
				}
		}

    public function getMessages(): array|bool
    {
        try {
            $stmt = $this->dbConn->prepare(
                "
			SELECT
				m.content,
				u.username,
				m.author_id,
				m.updated_at,
				m.created_at,
				m.id
			FROM messages m
			JOIN users u ON m.author_id = u.id
			ORDER BY m.created_at ASC;
				"
            );
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                   return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->errno = $e->getCode();
            $this->logger->error($this->error);
            return false;
        }
    }
}
