
<?php
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/UserModel.php';
class GetAllUsersController extends UserManagementController
{
	public function __construct()
	{
		parent::__construct();
		$this->requiredMethod = HttpMethod::POST;
	}

	public function getAllUsers()
	{
		$this->verifyMethod();
		$userModel = new User();
		$users = $userModel->getAllUsers();
		if ($users) {
			$this->responseHandler->allUsersRetrieved($users,);
		} else {
			$this->responseHandler->databaseError();
		}
	}
}
