<?php
$title = $_SERVER['APP_NAME'];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>


<form action=<?= CONTROLLERS . '/RegisterController.php'  ?> method='post'>
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