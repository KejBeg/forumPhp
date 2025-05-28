<?php

switch ($request) {
	case '/':
		require VIEWS . '/index.php';
		break;
	case '/login':
		require VIEWS . '/login.php';
		break;
	case '/register':
		require VIEWS . '/register.php';
		break;
	case '/logout':
		require VIEWS . '/logout.php';
		break;
	case '/users':
		require VIEWS . '/users.php';
		break;
	default:
		http_response_code(404);
		require VIEWS . '/404.php';
		break;
}
