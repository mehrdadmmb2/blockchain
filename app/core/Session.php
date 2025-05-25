<?php

namespace App\Core;

class Session
{
    /**
     * Starts the session if it hasn't been started already.
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Sets a session variable.
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a session variable.
     * @param string $key
     * @param mixed $default Default value if key not found.
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Checks if a session variable exists.
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Deletes a session variable.
     * @param string $key
     */
    public static function delete($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Sets a flash message (only available for the next request).
     * @param string $key
     * @param mixed $value
     */
    public static function setFlash($key, $value)
    {
        self::start();
        $_SESSION['flash_' . $key] = $value;
    }

    /**
     * Gets and deletes a flash message.
     * @param string $key
     * @param mixed $default Default value if key not found.
     * @return mixed
     */
    public static function getFlash($key, $default = null)
    {
        self::start();
        $flashKey = 'flash_' . $key;
        if (isset($_SESSION[$flashKey])) {
            $value = $_SESSION[$flashKey];
            unset($_SESSION[$flashKey]);
            return $value;
        }
        return $default;
    }

    /**
     * Destroys the entire session.
     */
    public static function destroy()
    {
        self::start();
        session_unset();
        session_destroy();
        // Clear session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }
}