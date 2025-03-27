<?php
// Constants
define('ROOT', __DIR__ . '/../');

// Public
define('PUBLIC_DIR', ROOT . '/public');
define('ASSETS', PUBLIC_DIR . '/assets');

// App
define('APP', ROOT . '/app');
define('CONTROLLER', APP . '/Controller');
define('MODELS', APP . '/Models');
define('VIEWS', APP . '/Views');
define('COMPONENTS', VIEWS . '/components');

define('GENDERS', ['male', 'female']);

// Load  the composer
require ROOT . '/vendor/autoload.php';

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();
