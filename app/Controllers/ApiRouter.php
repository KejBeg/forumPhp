<?php

/**
 * Decides which API route should be used
 */

require UTILS . '/ResponseHandler.php';

/**
 * @var AllResponseHandler
 * Used for standardized response handling
 */
$responseHandler = new AllResponseHandler();

if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
	$jsonArray = (array) json_decode(file_get_contents('php://input'), false);
} else {
	$responseHandler->serverError();
	exit;
}

$accessToken = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
if ($accessToken) {
	$accessToken = str_replace('Bearer ', '', $accessToken);
}


$logger->info('API called, request: ' . $_SERVER['REQUEST_URI'] . ', method: ' . $_SERVER['REQUEST_METHOD']);

switch ($request) {
	case '/api/register':
		require_once USER_MANAGEMENT . '/RegisterController.php';
		$controller = new RegisterController(requestJson: $jsonArray);
		$controller->register();
		break;
	case '/api/login':
		require_once USER_MANAGEMENT . '/LoginController.php';
		$controller = new LoginController(requestJson: $jsonArray);
		$controller->login();
		break;
	case '/api/check':
		require_once USER_MANAGEMENT . '/CheckController.php';
		$controller = new CheckController(accessToken: $accessToken);
		$controller->Check();
		break;
	case '/api/getMessages':
		require_once  MESSAGE_MANAGEMENT . '/GetMessagesController.php';
		$controller = new GetMessagesController();
		$controller->getMessages();
		break;
	case '/api/addMessage':
		require_once MESSAGE_MANAGEMENT . '/AddMessageController.php';
		$controller = new AddMessageController(requestJson: $jsonArray, accessToken: $accessToken);
		$controller->addMessage();
		break;
	case '/api/editMessage':
		require_once MESSAGE_MANAGEMENT . '/EditMessageController.php';
		$controller = new EditMessageController(requestJson: $jsonArray, accessToken: $accessToken);
		$controller->editMessage();
		break;
	case '/api/deleteMessage':
		require_once MESSAGE_MANAGEMENT . '/DeleteMessageController.php';
		$controller = new DeleteMessageController(requestJson: $jsonArray, accessToken: $accessToken);
		$controller->deleteMessage();
		break;

	case '/api/getAllUsers':
		require_once USER_MANAGEMENT . '/GetAllUsersController.php';
		$controller = new GetAllUsersController(requestJson: $jsonArray);
		$controller->getAllUsers();
		break;
	default:
		$responseHandler->serverError();
		break;
}
