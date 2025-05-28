
<?php
require_once MESSAGE_MANAGEMENT . '/MessageController.php';
require_once MODELS . '/MessageModel.php';
class GetMessagesController extends MessageController
{
    public function __construct()
    {
        parent::__construct();
        $this->requiredMethod = HttpMethod::POST;
    }

    public function getMessages(): void
    {
        $this->verifyMethod();
        $messageModel = new Message();
        $messages = $messageModel->getMessages();
        if ($messages) {
            $this->responseHandler->messagesRetrieved($messages);
        } else {
            $this->responseHandler->databaseError();
        }
    }
}
