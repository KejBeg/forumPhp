<?php
class User
{
	private mysqli $dbCon;
	/**
	 * @var LogHandler $logger
	 * A logger instance used for handling logging operations within the ResponseHandler utility.
	 */
	private LogHandler $logger;

	public function __construct(mysqli $dbCon, LogHandler $logger)
	{
		$this->dbCon = $dbCon;
		$this->logger = $logger;
	}

	public function hashPassword(string $password)
	{
		return password_hash($password, PASSWORD_BCRYPT);
	}

	public function createUser(string $username, string $password, string $email, string $gender)
	{

		$passwordHash = $this->hashPassword($password);

		$stmt = $this->dbCon->prepare(
			"INSERT INTO users(username, password_hash, email, gender) VALUES(?, ?, ?, ?)"
		);

		$stmt->bind_param('ssss', $username, $passwordHash, $email, $gender);


		if ($stmt->execute()) {
			$stmt->close();
		} else {
			$error = $stmt->error;
			$stmt->close();
			throw new Exception("Failed to create user: " . $error);
		}
	}
}
