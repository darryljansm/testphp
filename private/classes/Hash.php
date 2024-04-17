<?php

class Hash {
    // Pepper - Choose a strong, random value and keep it secret
    private static $pepper = 'TEST';

    public static function make($password)
    {
        $options = [
            'cost' => 12, // Adjust the cost factor as needed (higher values increase computational cost)
            // 'salt' => self::generateSalt(), // Generate a random salt // No need for password_hash(), PASSWORD_BCRYPT already generate salt
        ];

        // Hash the password with bcrypt
        return password_hash(self::$pepper . $password, PASSWORD_BCRYPT, $options);
    }

    private static function generateSalt()
    {
        // Generate a cryptographically secure random salt
        return random_bytes(16);
    }

    public static function verify($password, $hashedPassword)
    {
        // Verify the password against the hashed password
        return password_verify(self::$pepper . $password, $hashedPassword);
    }
}


?>