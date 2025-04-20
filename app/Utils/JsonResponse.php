<?php
const ERROR_MAIL_FORMAT = [
	'success' => false,
	'message' => 'Mail does not match correct format'
];

const ERROR_USERNAME_FORMAT = [
	'success' => false,
	'message' => 'Username does not match correct format'
];

const ERROR_PASSWORD_FORMAT = [
	'success' => false,
	'message' => 'Password does not match correct format'
];

const ERROR_INSUFICIENT_INPUTS = [

	'success' => false,
	'message' => 'Some needed data was not present'
];

const ERROR_REQUEST_METHOD =  [
	'success' => false,
	'message' => 'Incorrect request method was used'
];

const ERROR_REQUEST_METHOD_POST = [
	'success' => false,
	'message' => ERROR_REQUEST_METHOD['message'] . ', POST is required'
];

const ERROR_REQUEST_METHOD_GET = [
	'success' => false,
	'message' => ERROR_REQUEST_METHOD['message'] . ', GET is required'
];

const ERROR_API_PATH = [
	'success' => false,
	'message' => 'Incorrect API path'
];

const ERROR_DATABASE = [
	'success' => false,
	'message' => 'A database error occured'
];

const SUCCESS = [
	'success' => true,
];
