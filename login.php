<?php
session_start();
include "header.html";

if (isset($_SESSION['login_error'])) {
    echo '<div style="color: red;">' . $_SESSION['login_error'] . '</div>';
    unset($_SESSION['login_error']);
}
?>
<h2>Login</h2>
<form action="index.php?mode=login" method="post">
    <label for="netID">NetID:</label>
    <input type="text" name="netID" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Login">
</form>
    <p>Don't have an account? <a href="initialsurvey.php">Create one</a>.</p>
<?php
include "footer.html";
?>