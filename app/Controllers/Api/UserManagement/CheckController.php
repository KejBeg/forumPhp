<?php
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/UserModel.php';
class CheckController extends UserManagementController
{
    public function __construct(string $accessToken)
    {
        parent::__construct();
        $this->requiredMethod = HttpMethod::POST;
        $this->accessToken = $accessToken;
    }

    public function Check()
    {
        $this->verifyMethod();

        if (!$this->checkAccessToken()) {
            $this->responseHandler->accessTokenInvalid();
            exit;
        }
        $userModel = new User();
        $user = $userModel->getUser($this->jwtArray['payload']['sub']);
        $this->responseHandler->accessTokenValid(
            $user['username'],
            $user['email'],
            $user['role']
        );
    }
}
