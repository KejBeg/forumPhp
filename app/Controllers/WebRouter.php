<?php




if ($request == '/') {
	require VIEWS . '/index.php';
} else if ($request == '/login') {
	require VIEWS . '/login.php';
} else if ($request == '/register') {
	require VIEWS . '/register.php';
}
