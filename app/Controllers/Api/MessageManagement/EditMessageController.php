<?php
require_once MESSAGE_MANAGEMENT . '/MessageController.php';
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/MessageModel.php';
class EditMessageController extends MessageController
{
    public function __construct(array $requestJson, string|null $accessToken)
    {
        parent::__construct($requestJson);
        $this->requiredInputs = ['content', 'messageId'];
        $this->requiredMethod = HttpMethod::POST;
        $this->requestJson =  $requestJson;
        $this->accessToken = $accessToken;
    }

    public function editMessage(): void
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

        if (!$message->isAuthor((int) $this->requestJson['messageId'], (int) $userController->jwtArray['payload']['sub'])) {
            $this->responseHandler->forbiddenEdit();
            exit;
        }





        $success = $message->editMessage(messageId: $this->requestJson['messageId'], content: $this->requestJson['content']);
        if ($success) {
            $this->responseHandler->messageEditted();
        } else {
            $this->responseHandler->databaseError();
        }
    }
}
