<?php

class Input {
    /**
     * Check if input data exists.
     *
     * @param string $type The type of input data to check (e.g., 'POST', 'GET').
     * @return bool True if input data exists, otherwise false.
     */
    public static function exists($type = 'POST') {
        $inputData = strtoupper($type) === 'POST' ? $_POST : $_GET;
        return !empty($inputData);
    }

    /**
     * Get input data by key.
     *
     * @param string $item The key of the input data to retrieve.
     * @return mixed The value of the input data if exists, otherwise an empty string.
     */
    public static function get($item) {
        // Check if the input data exists in both POST and GET arrays
        if (isset($_POST[$item])) {
            return $_POST[$item];
        } elseif (isset($_GET[$item])) {
            return $_GET[$item];
        }
        // Return an empty string if input data does not exist
        return '';
    }
}


?>