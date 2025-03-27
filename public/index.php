<?php
require_once __DIR__ . '/../app/bootstrap.php';

// Get the current request URI
$request = $_SERVER['REQUEST_URI'];

if ($request == '/') {
	require VIEWS . '/index.php';
} else if ($request = '/login') {
	require VIEWS . '/login.php';
} else if ($request = '/register') {
	require VIEWS . '/register.php';
} else {
	echo '404';
}
