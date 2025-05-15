<?php

/**
 * Enum HttpMethod
 *
 * Represents the HTTP methods as string values.
 * This can be used to standardize and validate HTTP method usage
 * throughout the application.
 *
 */
enum HttpMethod: string
{
	case GET = 'GET';
	case POST = 'POST';
	case PUT = 'PUT';
	case DELETE = 'DELETE';
}
 ?>
