<?php

// Define the root path of the project (one level up from public)
define('ROOT_PATH', dirname(__DIR__));

// Include the bootstrap file which handles autoloading and routing setup
require ROOT_PATH . '/app/bootstrap.php';

// Get the requested URI (e.g., /login, /register, /)
$uri = $_SERVER['REQUEST_URI'];

// IMPORTANT: Change '/blockchain/public' to your actual project's subfolder path
// This must exactly match your RewriteBase in .htaccess and the URL you use in the browser.
// Example: If your project is named 'my_app' and is in htdocs, it would be '/my_app/public'.
// If you are using a Virtual Host that points directly to the 'public' folder (e.g., http://mywallet.test/), use '' (empty string).
$public_path_prefix = '/blockchain-master/public'; // <---  YOU MUST SET THIS CORRECTLY!

// Remove the public_path_prefix from the URI to get the clean route.
if (strpos($uri, $public_path_prefix) === 0) {
    $uri = substr($uri, strlen($public_path_prefix));
}
// If the URI is empty after removing the prefix (meaning it was just the public_path_prefix),
// set it to '/' to represent the root of your application.
if (empty($uri)) {
    $uri = '/';
}

// Remove the /index.php part if present (for direct links or when .htaccess isn't fully configured)
// This handles cases where user might type /public/index.php/login
if (strpos($uri, '/index.php') === 0) {
    $uri = substr($uri, strlen('/index.php'));
}
if (empty($uri)) { // If it becomes empty after removing /index.php, it's the root
    $uri = '/';
}


// Get the HTTP method (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Direct the request using the router
$router->direct($uri, $method);

?>