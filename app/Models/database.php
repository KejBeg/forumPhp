<?php
class Database
{
	private static ?Database $instance = null;
	private ?PDO $conn = null;

	private function __construct()
	{
		try {
			$dsn = "mysql:host={$_SERVER['DB_HOST']};port={$_SERVER['DB_PORT']};dbname={$_SERVER['DB_DATABASE']};charset=utf8mb4";

			$this->conn = new PDO(
				$dsn,
				username: $_SERVER['DB_USER'],
				password: $_SERVER['DB_PASS']

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
