<?php
require_once __DIR__ . '/../app/bootstrap.php';

require MODELS . "/database.php";


// Get the current request URI
$request = $_SERVER['REQUEST_URI'];
$publicRequestPath = PUBLIC_DIR . $request;

if (file_exists($publicRequestPath) && is_file($publicRequestPath)) {
	// Serve the file with the correct MIME type
	$extension = pathinfo($publicRequestPath, PATHINFO_EXTENSION);
	$mimeTypes = [
		'js' => 'application/javascript',
		'css' => 'text/css',
		'html' => 'text/html',
		'json' => 'application/json',
		'png' => 'image/png',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
	];

	if (isset($mimeTypes[$extension])) {
		header("Content-Type: " . $mimeTypes[$extension]);
	}

	readfile($publicRequestPath);
	exit;
}

$db = new Database();
$conn = $db->getConn();


require CONTROLLERS . '/Router.php';

$conn->close();
