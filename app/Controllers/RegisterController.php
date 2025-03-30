<?php

if ($_SERVER('Request Method') != 'POST') {
	return;
}

if (empty($_POST['register'])) {
	return;
}

if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['pass']) || empty($_POST['gender'])) {
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
	// Should say wrong email
}

if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username)) {
	// Should say wrong username 
}

if (!preg_match('/^[a-zA-Z0-9_!@#$%^&*()\-]{8,}$/', $pass)) {
	// Should say wrong password
}
