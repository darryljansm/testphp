<?php

class Session {
    // Check if a session variable exists
    public static function exists($name) {
        return isset($_SESSION[$name]);
    }

    // Store a value in the session
    public static function put($name, $value) {
        // Check if the session is active before modifying session data
        if (self::isActive()) {
            $_SESSION[$name] = $value;
            return true; // Return true if the operation is successful
        }
        return false; // Return false if the session is not active
    }

    // Retrieve a value from the session
    public static function get($name) {
        // Check if the session is active and if the session variable exists
        if (self::isActive() && self::exists($name)) {
            return $_SESSION[$name]; // Return the value if it exists
        }
        return null; // Return null if the session is not active or the variable doesn't exist
    }

    // Delete a session variable
    public static function delete($name) {
        // Check if the session is active and if the session variable exists
        if (self::isActive() && self::exists($name)) {
            unset($_SESSION[$name]); // Unset the session variable
        }
    }

    // Check if a session is active
    public static function isActive() {
        return session_status() === PHP_SESSION_ACTIVE; // Return true if the session is active, otherwise false
    }

    // Regenerate the session ID
    public static function regenerate() {
        if (self::isActive()) {
            session_regenerate_id(true); // Regenerate the session ID with a new one
        }
    }
}



?>
