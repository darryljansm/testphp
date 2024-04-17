<?php 

<?php

class FileUploader {
    
    // Directory where uploaded files will be stored
    private $uploadDir;

    // Allowed file types/extensions
    private $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    // Maximum file size (in bytes)
    private $maxFileSize = 1048576; // 1MB

    public function __construct($uploadDir) {
        $this->uploadDir = $uploadDir;
    }

    /**
     * Handle file upload.
     *
     * @param array $file The file information from $_FILES array.
     * @return string|bool The filename if upload is successful, otherwise false.
     */
    public function upload($file) {
        // Check if file upload is successful
        if ($file['error'] !== UPLOAD_ERR_OK) {
            // File upload failed, return false
            return false;
        }

        // Check file type
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileType, $this->allowedTypes)) {
            // Invalid file type, return false
            return false;
        }

        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            // File size exceeds limit, return false
            return false;
        }

        // Generate unique filename to prevent filename collisions
        $filename = uniqid() . '_' . basename($file['name']);

        // Move uploaded file to destination directory
        $destination = $this->uploadDir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // File upload successful, return filename
            return $filename;
        } else {
            // File upload failed, return false
            return false;
        }
    }
}

?>



?>