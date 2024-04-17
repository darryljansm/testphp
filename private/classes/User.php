<?php

require_once('Db.php');

class User {

    private $_db;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    /**
     * Find if a user exists with the given username.
     *
     * @param string $user The username to search for.
     * @return bool True if the user exists, otherwise false.
     */
    public function findUser($user = null) {
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
        $checkuser = $this->_db->selectData('*', 'users', 'USERNAME = ? AND DEL_STATUS = 0', array($username));
        if ($checkuser) {
            $row = $checkuser->fetch(PDO::FETCH_ASSOC);
            if (Hash::verify($password . $row['SALT'], $row['PASSWORD'])) {
                // Store user ID and type in session
                Session::put('user_id', Encoding::encode($row['IDNo']));
                Session::put('user_type', Encoding::encode($row['USER_CLASS']));
                // Regenerate session ID to enhance security
                Session::regenerate();
                return true;
            }
        }
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
        if ($userID == null) {
            // Retrieve user ID from session
            $userID = Encoding::decode(Session::get('user_id'));
        }
        $q = $this->_db->selectData($field, 'users', 'IDNo = ?', array($userID));
        return $q ? $q->fetchColumn() : null;
    }

    /**
     * Check if a user is currently logged in.
     *
     * @return bool True if the user is logged in, otherwise false.
     */
    public function userLogged() {
        return Session::exists('user_id');
    }

    /**
     * Log out the current user by clearing session data.
     */
    public function logout() {
        Session::delete('user_id');
        Session::delete('user_type');
        // Regenerate session ID after logout
        Session::regenerate();
    }
}


?>