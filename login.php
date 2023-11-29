<?php
session_start();
include "header.html";
?>
<h2>Login</h2>
<?php
if (isset($_SESSION['login_error'])) {
    echo '<div style="color: red;"><p>' . $_SESSION['login_error'] . '</p></div>';
    unset($_SESSION['login_error']);
}
?>
<form action="index.php?mode=login" method="post">
    <label for="netID">NetID:</label>
    <input type="text" name="netID" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Login" style="margin: 0%;">
</form>
    <p>Don't have an account? <a href="initialsurvey.php">Create one</a>.</p>
<?php
include "footer.html";
?>