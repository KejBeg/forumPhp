<?php
require_once MESSAGE_MANAGEMENT . '/MessageController.php';
require_once USER_MANAGEMENT . '/UserManagementController.php';
require_once MODELS . '/MessageModel.php';
class DeleteMessageController extends MessageController
{
    public function __construct(array $requestJson, string|null $accessToken)
    {
        parent::__construct($requestJson);
        $this->requiredInputs = ['messageId'];
        $this->requiredMethod = HttpMethod::POST;
        $this->requestJson =  $requestJson;
        $this->accessToken = $accessToken;
    }

    public function DeleteMessage(): void
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

		$this->logger->info('Delete message request received, messageId: ' . $this->requestJson['messageId'] . ', userId: ' . $userController->jwtArray['payload']['sub']);
		if (!$message->isAuthor((int) $this->requestJson['messageId'], (int) $userController->jwtArray['payload']['sub'])) {
						$this->responseHandler->forbiddenDelete();
						exit;
				}





        $success = $message->deleteMessage(messageId: $this->requestJson['messageId']);
        if ($success) {
            $this->responseHandler->messageDeleted();
        } else {
            $this->responseHandler->databaseError();
        }
    }
}

