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

	document.querySelector('#register-form').addEventListener('submit', async (e) => {
		e.preventDefault();

		const form = e.target;
		let registerHandler = new ApiHandler(
			'/api/register', {
				email: form.email.value,
				name: form.name.value,
				pass: form.pass.value,
				gender: form.gender.value,
			},
			'POST'
		);

		await registerHandler.send();

		if (registerHandler.resData.success) {
			document.cookie = `access_token=${registerHandler.resData.data.access_token}; path=/; max-age=900; secure; samesite=strict`;
			window.location.href = '/';
		}
	});
</script>

<?php require COMPONENTS . '/foot.php' ?>
