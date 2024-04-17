<?php 

class Token {
    /**
     * Generate a unique token.
     *
     * @param int $length The length of the token (default is 32).
     * @return string The generated token.
     */
    public static function generate($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Verify if a token is valid.
     *
     * @param string $token The token to verify.
     * @param string|null $expected The expected token value.
     * @return bool True if the token is valid, false otherwise.
     */
    public static function verify($token, $expected = null) {
        // Verify if the token matches the expected value (if provided)
        return hash_equals($token, $expected);
    }
}


?>