<?php

$title = APP_NAME;
$cssFiles = [
	'navbar.css',
	'error.css',
	'messageList.css',
	'addMessage.css',
];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>

<?php require COMPONENTS . '/error.php' ?>

<main>
	<?php require COMPONENTS . '/messageList.php' ?>
	<?php require COMPONENTS . '/addMessage.php' ?>
</main>

<?php require COMPONENTS . '/foot.php' ?>
