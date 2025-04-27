<?php

/**
 * Decides which Router should be accessed
 */

// Decides which Router should be chosen next
if (strpos($request, '/api') === 0) {
	// Router for API requests
	require CONTROLLERS . '/ApiRouter.php';
} else if (strpos($request, '/public') === 0) {
	// Router for accessing public resources
	require CONTROLLERS . '/PublicRouter.php';
} else {
	// Router for View requests
	require CONTROLLERS . '/WebRouter.php';
}
