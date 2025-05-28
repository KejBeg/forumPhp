<?php
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/UserModel.php';

class RegisterController extends UserManagementController
{
    public function __construct(array $requestJson)
    {
        parent::__construct();
        $this->requiredInputs = ['name', 'pass', 'gender', 'email'];
        $this->requiredMethod = HttpMethod::POST;
        $this->requestJson =  $requestJson;
    }

    /**
     * Tries to register a new user.
     *
     * This function checks:
     * - Method
     * - If all required inputs are present
     * - Gender
     * - Email
     * - Username
     * - Password
     * And finally creates the user.
     */
    public function register(): void
    {
        $this->verifyMethod();
        $this->checkRequiredInputs();
        $this->requestJson['name'] = strtolower(trim($this->requestJson['name']));
        $this->requestJson['email'] = strtolower(trim($this->requestJson['email']));
        $this->checkGender();
        $this->checkMail();
        $this->checkUsername();
        $this->checkPassword();
        $this->createUser();
    }


    public function createUser(): void
    {

        $user = new User();
        $success = $user->createUser($this->requestJson['name'], $this->requestJson['pass'], $this->requestJson['email'], $this->requestJson['gender']);
        if ($success) {
            $jwt = $this->generateJwt($user->userId);
            $this->responseHandler->userCreated($jwt);
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
