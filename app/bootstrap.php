<?php
// Constants
const ROOT = __DIR__ . '/../';

// Public
const PUBLIC_DIR = ROOT . '/public';
const ASSETS = PUBLIC_DIR . '/assets';

// App
const APP = ROOT . '/app';
const UTILS = APP . '/Utils';
const CONTROLLERS = APP . '/Controllers';
const MODELS = APP . '/Models';
const VIEWS = APP . '/Views';
const COMPONENTS = VIEWS . '/components';

const API = CONTROLLERS . '/Api';
const USER_MANAGEMENT = API . '/UserManagement';

// Logger
const LOG_FILE_DIR = ROOT;
const LOG_FILE_NAME = 'forumPhp.log';
const LOG_FILE_PATH = LOG_FILE_DIR . '/' . LOG_FILE_NAME;

const GENDERS = ['male', 'female'];

// Load the composer
require ROOT . '/vendor/autoload.php';

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();
