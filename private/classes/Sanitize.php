<?php 

class Sanitize {
    public static function clean($string) { // USED FOR INPUT
        // Trim whitespace from the beginning and end of the string
        $string = trim($string);

        // Perform basic HTML entity encoding
        $cleanedString = htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // If needed, additional context-specific sanitization can be performed here

        return $cleanedString;
    }

    public static function escapeOutput($string) {
        // Check if the string contains HTML entities
        if (htmlspecialchars_decode($string, ENT_QUOTES | ENT_HTML5) !== $string) {
            // If already escaped, return as is
            return $string;
        } else {
            // Otherwise, escape HTML special characters
            return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
    }
    
}


?>