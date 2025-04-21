<?php
require_once 'bootstrap.php';

require MODELS . "/database.php";

require UTILS . '/LogHandler.php';

$logger = new LogHandler(LOG_FILE_PATH);
$logger->info("Starting Setup");

$db = new Database();

$conn = $db->getConn();

$categories = '
CREATE TABLE IF NOT EXISTS categories 
(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,		
	description VARCHAR(255),
	slug VARCHAR(255) UNIQUE
);
';

$messages = '
CREATE TABLE IF NOT EXISTS messages 
(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	content TEXT NOT NULL,
	author_id INT UNSIGNED NOT NULL,
	post_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP NULL DEFAULT NULL,
	FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
)
';

$posts = '
CREATE TABLE IF NOT EXISTS posts
(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	author_id INT UNSIGNED NOT NULL,
	category_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP NULL DEFAULT NULL,
	FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
';

$users = '
CREATE TABLE IF NOT EXISTS users 
(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL UNIQUE,
	password_hash VARCHAR(512) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	gender ENUM ("male", "female") NOT NULL,
	description TEXT,
	role ENUM("admin", "moderator", "user") NOT NULL DEFAULT "user",
	last_login TIMESTAMP NULL DEFAULT NULL DEFAULT CURRENT_TIMESTAMP,
	is_active BOOLEAN DEFAULT TRUE,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
';

$conn->query($users);
$conn->query($categories);
$conn->query($posts);
$conn->query($messages);

$logger->info("Database tables created");


$logger->info("Setup finished");

$conn->close();
