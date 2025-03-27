<?php
include_once '../config.php';

$title = $_SERVER['APP_NAME'];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>


<form action='.' method='post'>
	<label for='email'>Email</label>
	<input type='email' name='email' id='email'>
	<label for='name'>Name</label>
	<input type='text' name='name' id='name'>
	<label for='pass'>Password</label>
	<input type='password' name='pass' id='pass'>
	<select name='gender' id='gender'>
		<option value='male'>Male</option>
		<option value='female'>Female</option>
	</select>
	<input type='submit' value='Register' name='register'>
</form>

<?php require COMPONENTS . '/foot.php' ?>


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

?>