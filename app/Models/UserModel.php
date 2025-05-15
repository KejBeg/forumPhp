<?php
class User
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

	public function hashPassword(string $password)
	{
		return password_hash($password, PASSWORD_BCRYPT);
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
			return true;
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			$this->errno = $e->getCode();
			$this->logger->error($this->error);
			return false;
		}
	}
}
