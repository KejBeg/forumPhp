<?php

/**
 * Defines basic constants for the app
 */

// Directory contants
/** Root directory */
const ROOT = __DIR__ . '/../';
/** Public directory */
const PUBLIC_DIR = ROOT . '/public';
/** Assets directory */
const ASSETS = PUBLIC_DIR . '/assets';
/** App directory */
const APP = ROOT . '/app';
/** Utilities directory */
const UTILS = APP . '/Utils';
/** Controllers directory */
const CONTROLLERS = APP . '/Controllers';
/** Models directory */
const MODELS = APP . '/Models';
/** Views directory */
const VIEWS = APP . '/Views';
/** Components directory */
const COMPONENTS = VIEWS . '/components';
/** Api directory */
const API = CONTROLLERS . '/Api';
/** User Management of API directory */
const USER_MANAGEMENT = API . '/UserManagement';
/** Post Management of API directory */
const MESSAGE_MANAGEMENT = API . '/MessageManagement';

// Logger constants
/** Directory of log file*/
const LOG_FILE_DIR = ROOT;
/** Name of log file*/
const LOG_FILE_NAME = 'forumPhp.log';
/** Complete path of log file*/
const LOG_FILE_PATH = LOG_FILE_DIR . '/' . LOG_FILE_NAME;

/** Recognized genders */
const GENDERS = ['male', 'female'];

/** Standard JWT header */
const JWT_HEADER = [
		'alg' => 'HS256',
		'typ' => 'JWT'
];

