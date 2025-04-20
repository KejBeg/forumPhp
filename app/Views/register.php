<?php
$title = $_SERVER['APP_NAME'];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>

<?php require COMPONENTS . '/error.php' ?>

<form id="register-form">
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
<script type="module">
	import ApiHandler from '/js/ApiHandler.js';

	document.querySelector('#register-form').addEventListener('submit', (e) => {
		e.preventDefault();

		const form = e.target;
		let apiHandler = new ApiHandler(
			'/api/register', {
				email: form.email.value,
				name: form.name.value,
				pass: form.pass.value,
				gender: form.gender.value,
			},
			'POST'
		);

		apiHandler.send();
	});
</script>

<?php require COMPONENTS . '/foot.php' ?>