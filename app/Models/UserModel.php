<?php
class User
{
	private ?Database $db = null;
	private ?PDO $dbConn = null;
	public ?string $error = null;
	public ?string $errno = null;
	public ?int $userId = null;
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

	public function hashPassword(string $password)
	{
		return password_hash($password, PASSWORD_BCRYPT);
	}

	public function getUser(int $id): array|bool
	{
		$stmt = $this->dbConn->prepare(
			"SELECT * FROM users WHERE  id = :id"
		);
		$stmt->bindParam(':id', $id);
		try {
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
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

	public function getAllUsers(): array|bool
	{
		$stmt = $this->dbConn->prepare(
			"
SELECT 
    u.id,
    u.username,
    u.gender,
    COUNT(m.id) AS message_count
FROM 
    users u
LEFT JOIN 
    messages m ON u.id = m.author_id
GROUP BY 
    u.id, u.username, u.gender
ORDER BY 
    u.username;
			"
		);

		try {
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

	public function getUserByUsername(string $username): array|bool
	{
		$stmt = $this->dbConn->prepare(
			"SELECT * FROM users WHERE username = :username"
		);
		$stmt->bindParam(':username', $username);
		try {
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
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

	public function createUser(string $username, string $password, string $email, string $gender)
	{

		$passwordHash = $this->hashPassword($password);

		$stmt = $this->dbConn->prepare(
			"INSERT INTO users(username, password_hash, email, gender) VALUES(:username, :passwordHash, :email, :gender)"
		);

		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':passwordHash', $passwordHash);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':gender', $gender);

		try {
			$stmt->execute();
			$this->userId = $this->dbConn->lastInsertId();
			return true;
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			$this->errno = $e->getCode();
			$this->logger->error($this->error);
			return false;
		}
	}
}
