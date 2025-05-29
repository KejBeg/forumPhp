<?php
class Database
{
	private static ?Database $instance = null;
	private ?PDO $conn = null;

	private function __construct()
	{
		try {
			$dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE . ';charset=utf8mb4';

			$this->conn = new PDO(
				$dsn,
				username: DB_USER,
				password: DB_PASS

			);

			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $error) {
			die("Database connection could not be created \n Error: $error");
		}
	}

	public static function getInstance(): Database
	{
		if (self::$instance === null) {
			self::$instance = new Database();
		}
		return self::$instance;
	}

	public function getConn(): PDO
	{
		return $this->conn;
	}
}
