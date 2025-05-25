<?php

// Basic Autoloader for our project classes
spl_autoload_register(function ($class) {
    // Convert namespace to directory path
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    // Remove the base namespace 'App'
    $class = str_replace('App' . DIRECTORY_SEPARATOR, '', $class);
    // Construct the file path
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load configuration (we'll add this later)
// require 'config/app.php';
// require 'config/database.php';

use App\Core\Router;

// Create a new Router instance
$router = new Router();

// Define your application routes here
// GET routes for displaying pages
$router->get('/', 'index.php'); // Your landing page
$router->get('/login', 'auth/login.php'); // Login page
$router->get('/register', 'auth/register.php'); // Register page

// POST routes for form submissions (we'll add controllers later)
// $router->post('/register', 'AuthController@register');
// $router->post('/login', 'AuthController@login');

// You can define other routes here as needed
// $router->get('/dashboard', 'user/dashboard.php');
// $router->get('/admin', 'admin/dashboard.php');

// Simple 404 error page (create this file: app/views/errors/404.php)
$router->get('/404', 'errors/404.php');

// Function to handle global view rendering (optional, but good practice)
function view($name, $data = []) {
    extract($data); // Extract data array into variables for the view
    require __DIR__ . '/views/' . $name;
}