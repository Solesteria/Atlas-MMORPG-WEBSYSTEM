<?php
// Password Validation function
function isValidPassword($password) {
    // Trim any leading or trailing spaces
    $password = trim($password);

    // Regular Expression for password validation
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    // Print to see if the password matches
    if (preg_match($pattern, $password)) {
        echo "Password is valid!";
        return true;
    } else {
        echo "Password is invalid!";
        return false;
    }
}
?>
