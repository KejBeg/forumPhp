<?php
class User
{
	private mysqli $dbCon;

	function __construct(mysqli $dbCon)
	{
		$this->dbCon = $dbCon;
	}

	function createUser($data)
	{
		$stmt = self::$dbCon->prepare("INSERT INTO USERS");
	}
}
