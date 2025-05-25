<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    /**
     * Define a GET route.
     * @param string $uri The URI to match (e.g., '/', '/login')
     * @param string $view The path to the view file (e.g., 'auth/login.php')
     */
    public function get($uri, $view)
    {
        $this->routes['GET'][$uri] = $view;
    }

    /**
     * Define a POST route.
     * @param string $uri The URI to match (e.g., '/register')
     * @param string $action A string indicating the controller action (e.g., 'AuthController@register')
     */
    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    /**
     * Direct the request to the appropriate view or controller action.
     * @param string $uri The requested URI
     * @param string $method The HTTP request method (GET, POST)
     */
    public function direct($uri, $method)
    {
        // Remove trailing slash for consistent routing, except for the root '/'
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        if (array_key_exists($uri, $this->routes[$method])) {
            $target = $this->routes[$method][$uri];

            if ($method === 'GET') {
                // For GET requests, load the view directly
                return $this->loadView($target);
            } elseif ($method === 'POST') {
                // For POST requests, call the controller action
                return $this->callAction($target);
            }
        }

        // If no route matches, show a 404 error
        $this->loadView('errors/404.php');
    }

    /**
     * Loads a view file.
     * @param string $view The path to the view file (e.g., 'auth/login.php')
     */
    protected function loadView($view)
    {
        // This makes variables from the controller available in the view
        extract(func_get_arg(1) ?? []); // Accepts optional data array for the view

        if (file_exists(__DIR__ . '/../views/' . $view)) {
            require __DIR__ . '/../views/' . $view;
        } else {
            // Fallback for missing view files
            require __DIR__ . '/../views/errors/404.php';
        }
    }

    /**
     * Calls a controller method.
     * @param string $action The controller action string (e.g., 'AuthController@register')
     */
    protected function callAction($action)
    {
        list($controller, $method) = explode('@', $action);

        $controller = "App\\Controllers\\{$controller}";

        if (!class_exists($controller)) {
            die("Controller {$controller} not found.");
        }

        $controllerInstance = new $controller;

        if (!method_exists($controllerInstance, $method)) {
            die("Method {$method} not found in controller {$controller}.");
        }

        return $controllerInstance->$method();
    }
}