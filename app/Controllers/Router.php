<?php

if (strpos($request, '/api') === 0) {
	require API . '/ApiRouter.php';
} else {
	require CONTROLLERS . '/WebRouter.php';
}
