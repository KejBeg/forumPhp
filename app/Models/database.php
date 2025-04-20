<?php
class Database
{
	private ?mysqli $conn = null;

	function __construct()
	{
		try {

			$this->conn = new mysqli($_SERVER["DB_HOST"], $_SERVER["DB_USER"], $_SERVER["DB_PASS"], $_SERVER["DB_DATABASE"], $_SERVER["DB_PORT"]);
		} catch (mysqli_sql_exception $error) {
			die("Database connection could not be created \n Error: $error");
		}
	}

	public function getConn()
	{
		if ($this->conn == null) {
			new Database();
		}

		return $this->conn;
	}
}
