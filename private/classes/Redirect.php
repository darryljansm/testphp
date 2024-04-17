<?php 

class Redirect {
    // Redirect to a specified location with optional status code
    public static function to($location = null, $statusCode = 302) {
        if ($location) {
            // Send redirect header with the specified location and status code
            header('Location: ' . $location, true, $statusCode);
            // Exit to prevent further code execution
            exit();
        }
    }

    // Redirect to the referring page (if available), or fallback to a default location
    public static function referer() {
        self::to(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/');
    }

    // Go back to the previous page in the browser history, or provide a fallback action
    public static function goBack($fallbackLocation = '/') {
        // Use JavaScript to navigate back in the browser history or redirect to a fallback location
        echo "<script>";
        echo "if (history.length > 1) {";
        echo "    history.back(-1);";
        echo "} else {";
        echo "    window.location.href = '{$fallbackLocation}';";
        echo "}";
        echo "</script>";
        // Exit to prevent further code execution
        exit();
    }
}



?>