<?php
// Constants
define("ROOT_PATH", __DIR__);

// Load  the composer
require ROOT_PATH . '/vendor/autoload.php';

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


?>
