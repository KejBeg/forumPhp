<?php
$title = APP_NAME;
$cssFiles = [
    'navbar.css',
	'error.css',
    'login.css',
];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>

<?php require COMPONENTS . '/error.php' ?>

<main>
    <div id="login-form-container">

        <form id="login-form">
            <label for='name'>Name</label>
            <input type='text' name='name' id='name' required>
            <label for='pass'>Password</label>
            <input type='password' name='pass' id='pass' required>
            <input type='submit' value='Login' name='login'>
        </form>
    </div>
    <script>
        document.querySelector('#login-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            let loginHandler = new ApiHandler(
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
</main>

<?php require COMPONENTS . '/foot.php' ?>
