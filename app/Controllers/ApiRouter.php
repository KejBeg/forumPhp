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
	$jsonString = file_get_contents('php://input');
	$jsonArray = json_decode($jsonString, false);
} else {
	$responseHandler->serverError();
	exit;
}

switch ($request) {
	case '/api/login':
		break;
	case '/api/register':
		require_once USER_MANAGEMENT . '/RegisterController.php';
		$controller = new RegisterController($jsonArray);
		$controller->register();
		break;
	default:
		$responseHandler->serverError();
		break;
}
