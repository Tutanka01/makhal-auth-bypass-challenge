<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "<h1>Welcome to the MFF Internal Dashboard</h1>";
    echo "<p>Access granted! Here is your flag: <strong>" . htmlspecialchars(file_get_contents("lkhqsdmlfkkh/flag.txt")) . "</strong></p>";
    echo "<hr><p>Challenge made by Makhal !</p>";
} else {
    echo "<h1>MFF Internal Dashboard</h1>";
    echo "<p>Please login with your administrator account.</p>";
    echo '<!-- Hint: check the page source for additional fields -->';
    echo '<form method="POST" action="login.php">';
    echo 'Username: <input name="user"><br>';
    echo 'Password: <input name="pass" type="password"><br>';
    echo '<!-- AuthToken: letmein -->';
    echo '<input type="hidden" name="auth_token" value="letmein">';
    echo '<input type="submit" value="Login">';
    echo '</form>';
}
?>