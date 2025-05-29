<!DOCTYPE html>
<html lang='en'>

<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title><?php echo APP_NAME ?></title>
	<script src='/public/js/ApiHandler.js'></script>
	<script src='/public/js/utils.js'></script>
	<link rel='stylesheet' href='/public/css/global.css'>
	<link rel='icon' href='/public/favicon.ico'>

	<?php
	foreach ($cssFiles as $cssFile) {
		echo "<link rel='stylesheet' href='/public/css/{$cssFile}'>\n";
	}
	?>
</head>

<body>
