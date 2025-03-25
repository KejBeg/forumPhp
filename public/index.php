<?php
// Simple router logic

// Get the current request URI
$request = $_SERVER['REQUEST_URI'];

// Define routes
if ($request == '/') {
    // Show homepage
	echo 'home';
} elseif ($request == '/about') {
    // Show about page
	echo 'about';
} elseif ($request == '/contact') {
    // Show contact page
	echo 'contact';
} else {
    // 404 Not Found
	echo '404';
}
?>
