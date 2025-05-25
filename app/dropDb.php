<?php
require_once 'bootstrap.php';

require MODELS . "/database.php";

$db = Database::getInstance();

$conn = $db->getConn();

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 0;");

// Drop tables
$conn->query("DROP TABLE IF EXISTS categories;");
$conn->query("DROP TABLE IF EXISTS messages;");
$conn->query("DROP TABLE IF EXISTS posts;");
$conn->query("DROP TABLE IF EXISTS users;");

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1;");

