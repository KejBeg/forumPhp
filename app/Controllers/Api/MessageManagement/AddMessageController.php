<?php
require_once MESSAGE_MANAGEMENT . '/MessageController.php';
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/MessageModel.php';
class AddMessageController extends MessageController
{
    public function __construct(array $requestJson, string|null $accessToken)
    {
        parent::__construct($requestJson);
        $this->requiredInputs = ['content',];
        $this->requiredMethod = HttpMethod::POST;
        $this->requestJson =  $requestJson;
        $this->accessToken = $accessToken;
    }

    public function addMessage(): void
    {
        $this->verifyMethod();
        $this->checkRequiredInputs();

        $message = new Message();
        $userController = new UserManagementController();
        $userController->accessToken = $this->accessToken;
        if (!$userController->checkAccessToken()) {
            $this->responseHandler->accessTokenInvalid();
            exit;
        }


        $success = $message->addMessage(authorId: (int) $userController->jwtArray['payload']['sub'], content: (string) $this->requestJson['content']);
        if ($success) {
            $this->responseHandler->messageCreated();
        } else {
            $this->responseHandler->databaseError();
        }
    }
}
