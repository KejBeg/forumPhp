<?php
$title = $_SERVER['APP_NAME'];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>

<?php require COMPONENTS . '/error.php' ?>

<form id="login-form">
	<label for='name'>Name</label>
	<input type='text' name='name' id='name'>
	<label for='pass'>Password</label>
	<input type='password' name='pass' id='pass'>
	<input type='submit' value='Login' name='login'>
</form>
<script>

	document.querySelector('#login-form').addEventListener('submit', async (e) => {
		e.preventDefault();

		const form = e.target;
		let  loginHandler = new ApiHandler(
			'/api/login', {
				name: form.name.value,
				pass: form.pass.value,
			},
			'POST'
		);

		await loginHandler.send();

		if (loginHandler.resData.success) {
			document.cookie = `access_token=${loginHandler.resData.data.access_token}; path=/; max-age=900; secure; samesite=strict`;
			window.location.href = '/';
		}
	});
</script>

<?php require COMPONENTS . '/foot.php' ?>
