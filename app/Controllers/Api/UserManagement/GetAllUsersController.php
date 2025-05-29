
<?php
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/UserModel.php';

class GetAllUsersController extends UserManagementController
{
	public function __construct(array $requestJson)
	{
		parent::__construct();
		$this->requiredMethod = HttpMethod::POST;
		$this->requiredInputs = ['filter'];
		$this->requestJson = $requestJson;
	}

	public function getAllUsers()
	{
		$this->verifyMethod();
		$userModel = new User();
		$users = $userModel->getAllUsersByGender((int)$this->requestJson['filter']);
		if ($users) {
			$this->responseHandler->allUsersRetrieved($users);
		} else {
			$this->responseHandler->allUsersRetrieved([]);
		}
	}
}
