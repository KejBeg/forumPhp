<?php
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo json_encode(ERROR_REQUEST_METHOD_POST);
	return;
}


if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['pass']) || empty($_POST['gender'])) {
	echo json_encode(ERROR_INSUFICIENT_INPUTS);
	return;
}


$name = $_POST['name'];
$pass = $_POST['pass'];
$gender = $_POST['gender'];
$email = $_POST['email'];

if (!in_array($gender, GENDERS)) {
	$gender = GENDERS[0];
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo json_encode(ERROR_MAIL_FORMAT);
}

if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $name)) {
	// Should say wrong username 
	echo json_encode(ERROR_USERNAME_FORMAT);
}

if (!preg_match('/^[a-zA-Z0-9_!@#$%^&*()\-]{8,}$/', $pass)) {
	echo json_encode(ERROR_PASSWORD_FORMAT);
}
require MODELS . '/UserModel.php';

$user = new User($conn);
try {
	$user->createUser($name, $pass, $email, $gender);
} catch (Exception $e) {
	echo json_encode(ERROR_DATABASE);
	return;
}

echo json_encode(SUCCESS);
