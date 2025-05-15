<?php

$publicRequest = substr($request, 1);


// Checks whether public resource matches the public path
if (strpos(realpath($publicRequest), realpath(PUBLIC_DIR)) !== 0) {
	$logger->info("Requested public resource not found");

	header("HTTP/1.1 404 Not Found");
	exit;
}

$logger->info("Serving public resource");

// Gets the variables for future content type matching
$extension = pathinfo($request, PATHINFO_EXTENSION);
$mimeTypes = [
	'js' => 'application/javascript',
	'css' => 'text/css',
	'html' => 'text/html',
	'json' => 'application/json',
	'png' => 'image/png',
	'jpg' => 'image/jpeg',
	'gif' => 'image/gif',
];

// Matches the correct content type
if (isset($mimeTypes[$extension])) {
	header("Content-Type: " . $mimeTypes[$extension]);
} else {
	header("Content-Type: application/octet-stream");
}

// Checks whether file exists
if (file_exists(ROOT . $request)) {
	readfile(ROOT . $request);
} else {
	header("HTTP/1.1 404 Not Found");
}