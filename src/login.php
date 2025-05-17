<?php
session_start();
$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
$token = $_POST['auth_token'] ?? '';

// Auth bypass: if correct token, grant access regardless of password
if ($token === 'letmein') {
    $_SESSION['logged_in'] = true;
    header("Location: index.php");
    exit;
// Check user and password if token is not 'letmein'
} elseif ($user === 'admin' && $pass === 'compmlexp@$$word123') { // Replace 'complexpassword123' with a strong password
    $_SESSION['logged_in'] = true;
    header("Location: index.php");
    exit;
} else {
    echo "<h1>Login failed</h1>";
    echo "<p>Invalid credentials. Hint: check the page source for hidden fields.</p>";
}
?>