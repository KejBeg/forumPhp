<?php
include_once USER_MANAGEMENT . '/UserManagementController.php';

class RegisterController extends UserManagementController
{
	public function __construct(mixed $requestJson)
	{
		parent::__construct();
		$this->requiredInputs = ['name', 'pass', 'gender', 'email'];
		$this->requestJson = (array) $requestJson;
	}

	public function register()
	{
		$this->checkRequiredInputs();
		$this->checkGender();
		$this->checkMail();
		$this->checkUsername();
		$this->checkPassword();
		$this->createUser();
	}


	public function createUser()
	{
		include_once MODELS . '/UserModel.php';

		$user = new User();
		$success = $user->createUser($this->requestJson['name'], $this->requestJson['pass'], $this->requestJson['email'], $this->requestJson['gender']);
		if ($success) {
			$this->responseHandler->userCreated();
		} else if ($user->errno == 23000 && str_contains($user->error, 'Duplicate entry')) {
			$matches = [];
			preg_match("/for key '(?:[^.]*\.)?([^']+)'/", $user->error, $matches);
			$key = $matches[1] ?? 'unknown';
			if ($key == 'username') {
				$this->responseHandler->userExists('username');
			} else if ($key == 'email') {
				$this->responseHandler->userExists('email');
			} else {
				$this->responseHandler->databaseError();
			}
		} else {
			$this->responseHandler->databaseError();
		}
	}
}
