<?php

/**
 * RegisterController
 *
 * This controller handles the user registration process for the API.
 * It is part of the UserManagement module within the forumPhp application.
 *
 *
 * Responsibilities:
 * - Handles incoming registration requests.
 * - Validates user input data.
 * - Creates new user accounts in the system.
 * - Returns appropriate API responses.
 *
 * Usage:
 * This controller is accessed via API routes for user registration.
 */


// 
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$responseHandler->incorrectMethod(HttpMethod::POST);
	exit;
}


if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['pass']) || empty($_POST['gender'])) {
	$responseHandler->insufficientInput();
	exit;
}


$name = $_POST['name'];
$pass = $_POST['pass'];
$gender = $_POST['gender'];
$email = $_POST['email'];

if (!in_array($gender, GENDERS)) {
	$gender = GENDERS[0];
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$responseHandler->incorrectMailFormat();
	exit;
}

if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $name)) {
	$responseHandler->incorrectUsernameFormat();
	exit;
}

if (!preg_match('/^[a-zA-Z0-9_!@#$%^&*()\-]{8,}$/', $pass)) {
	$responseHandler->incorrectPasswordFormat();
	exit;
}
require MODELS . '/UserModel.php';

$user = new User($conn, logger: $logger);
try {
	$user->createUser($name, $pass, $email, $gender);
} catch (Exception $e) {
	$responseHandler->databaseError();
	exit;
}

$responseHandler->userCreated();
exit;
