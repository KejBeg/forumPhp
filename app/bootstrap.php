<?php
// Constants
define('ROOT', __DIR__ . '/../');

// Public
define('PUBLIC_DIR', ROOT . '/public');
define('ASSETS', PUBLIC_DIR . '/assets');

// App
define('APP', ROOT . '/app');
define('UTILS', APP . '/Utils');
define('CONTROLLERS', APP . '/Controllers');
define('MODELS', APP . '/Models');
define('VIEWS', APP . '/Views');
define('COMPONENTS', VIEWS . '/components');

define("API", CONTROLLERS . '/Api');
define("USER_MANAGEMENT",  API . '/UserManagement');

define('GENDERS', ['male', 'female']);

// Load  the composer
require ROOT . '/vendor/autoload.php';

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();
