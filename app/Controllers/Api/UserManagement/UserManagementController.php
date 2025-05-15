<?php
include_once API . '/BaseController.php';

class UserManagementController extends BaseController
{

	public function checkGender()
	{
		if (!in_array($this->requestJson['gender'], GENDERS)) {
			$gender = GENDERS[0];
		}
	}

	public function checkMail()
	{
		if (!filter_var($this->requestJson['email'], FILTER_VALIDATE_EMAIL)) {
			$this->responseHandler->incorrectMailFormat();
			exit;
		}
	}

	public function checkUsername()
	{
		if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $this->requestJson['name'])) {
			$this->responseHandler->incorrectUsernameFormat();
			exit;
		}
	}

	public function checkPassword()
	{
		if (!preg_match('/^[a-zA-Z0-9_!@#$%^&*()\-]{8,}$/', $this->requestJson['pass'])) {
			$this->responseHandler->incorrectPasswordFormat();
			exit;
		}
	}


}
