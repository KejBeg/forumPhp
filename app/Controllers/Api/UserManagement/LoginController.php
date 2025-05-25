<?php
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/UserModel.php';

class LoginController extends UserManagementController
{
    public function __construct(array $requestJson)
    {
        parent::__construct();
        $this->requiredInputs = ['name', 'pass'];
        $this->requiredMethod = HttpMethod::POST;
        $this->requestJson =  $requestJson;
    }

    public function login()
    {
        $this->verifyMethod();
        $this->checkRequiredInputs();
        $user = new User();
        $userObject = $user->getUserByUsername($this->requestJson['name']);

        if (!$userObject) {
            $this->responseHandler->userNotFound();
            exit;
        }

        $this->passwordMatch($userObject);
        $jwt = $this->generateJwt($userObject['id']);
        $this->responseHandler->userLoggedIn($jwt);
    }

    public function passwordMatch(array $userObject): void
    {

        if (!password_verify($this->requestJson['pass'], $userObject['password_hash'])) {
            $this->responseHandler->invalidCredentials();
            exit;
        }
    }
}
