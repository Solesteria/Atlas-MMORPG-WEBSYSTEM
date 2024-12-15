<?php
    // Password Validation function
    function isValidPassword($password) {
        // Minimum 8 characters, at least one uppercase, one lowercase, one number, one special character
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($pattern, $password);
    }

?>