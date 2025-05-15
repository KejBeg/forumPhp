<?php

/**
 * Entry point for the server-side application.
 * This script initializes the application, handles routing
 */

// Includes basic constants
require_once __DIR__ . '/../app/bootstrap.php';

// Includes LogHandler Class
require_once UTILS . '/LogHandler.php';

// Sets log system
/**
 * LogHandler object
 * @var LogHandler
 */
$logger = LogHandler::getInstance();
$logger->info("Server Started");

// Include database model
require MODELS . "/database.php";

/**
 * @var string
 * Request URI
 */
$request = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Create a new database connection
/**
 * Database object
 * @var Database
 */
$db = Database::getInstance();
/**
 * Database connection
 * @var mysqli
 */
$conn = $db->getConn();

// Redirects all future duties to the Router
require CONTROLLERS . '/Router.php';

