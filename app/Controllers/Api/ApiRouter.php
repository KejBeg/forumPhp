<?php
require UTILS . '/JsonResponse.php';

if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
	$json = file_get_contents('php://input');
	$_POST = json_decode($json, true);
}

if ($request == '/api/login') {
} else if ($request == '/api/register') {
	require USER_MANAGEMENT . '/RegisterController.php';
}
