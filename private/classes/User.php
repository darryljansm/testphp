<?php

require_once('Db.php');

class User {
    private $_db;

    /**
     * Constructor to initialize the User class with a database connection.
     */
    public function __construct() {
        $this->_db = Db::getInstance();
    }

    /**
     * Find if a user exists with the given username.
     *
     * @param string $user The username to search for.
     * @return bool True if the user exists, otherwise false.
     */
    public function findUser($user = null) {
        // Check if the user exists in the database
        $check = $this->_db->selectData('*', 'users', 'USERNAME = ?', array($user));
        return $check ? true : false;
    }

    /**
     * Authenticate a user with the provided username and password.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @return bool True if the authentication is successful, otherwise false.
     */
    public function login($username = null, $password = null) {
        // Check if the provided username and password match a user in the database
        $checkuser = $this->_db->selectData('*', 'users', 'USERNAME = ? AND DEL_STATUS = 0', array($username));

        if ($checkuser === false) {
            // Handle database connection or query execution error
            // For example: Log or display an error message
            return false;
        } elseif ($checkuser === null) {
            // No user found with the provided username
            // Log or display a message indicating that no user was found
            return false;
        }

        // Fetch the first row from the result set
        $row = $checkuser->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            // No rows fetched from the result set
            // Log or display an error message
            return false;
        }

        if (Hash::verify($password . $row['SALT'], $row['PASSWORD'])) {
            // Store user ID and type in session
            Session::put('user_id', Encoding::encode($row['IDNo']));
            Session::put('user_type', Encoding::encode($row['USER_CLASS']));
            // Regenerate session ID to enhance security
            Session::regenerate();
            return true;
        }

        // Password verification failed
        return false;
    }


    /**
     * Check if a user is currently logged in.
     *
     * @return bool True if the user is logged in, otherwise false.
     */
    public function checkLogin() {
        // Check if user ID exists in session
        return Session::exists('user_id');
    }

    /**
     * Retrieve user data based on user ID.
     *
     * @param string $field The field(s) to retrieve from the database.
     * @param int|null $userID The user ID (defaults to the logged-in user's ID).
     * @return mixed|null The user data if found, otherwise null.
     */
    public function userData($field = "*", $userID = null) {
        // Default to the logged-in user's ID if $userID is not provided
        if ($userID === null) {
            // Retrieve user ID from session
            $userID = Encoding::decode(Session::get('user_id'));
        }

        // Select user data from the database based on the provided field(s) and user ID
        $q = $this->_db->selectData($field, 'users', 'IDNo = ?', array($userID));

        // Check if the query returned a valid result
        if ($q && isset($q['message'][0])) {
            // Return the specified field data of the first row
            return $q['message'][0][$field];
        }

        // Return null if no user data is found
        return null;
    }


    /**
     * Check if a user is currently logged in.
     *
     * @return bool True if the user is logged in, otherwise false.
     */
    public function userLogged() {
        // Check if the user is logged in by checking the session
        return Session::exists('user_id');
    }

    /**
     * Log out the current user by clearing session data.
     */
    public function logout() {
        // Delete user-related session data and regenerate session ID
        Session::delete('user_id');
        Session::delete('user_type');
        Session::regenerate();
    }
}

?>
