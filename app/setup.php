<?php
require_once 'bootstrap.php';
require_once 'env.php';

require MODELS . "/database.php";

require UTILS . '/LogHandler.php';

$logger = LogHandler::getInstance();
$logger->info("Starting Setup");

$db = Database::getInstance();

$conn = $db->getConn();

$messages = '
CREATE TABLE IF NOT EXISTS messages 
(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	content TEXT NOT NULL,
	author_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (author_id) REFERENCES users(id) 
)
';

$users = '
CREATE TABLE IF NOT EXISTS users 
(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL UNIQUE,
	password_hash VARCHAR(512) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	gender ENUM ("male", "female") NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
';

$conn->query($users);
$conn->query($messages);

$logger->info("Database tables created");


$logger->info("Setup finished");

