<?php
session_start();

if (isset($_SESSION["netID"])) {
    header("Location: welcome.php");
}

$title = "Login";
include "header.php";
?>
<div class="styled-container">
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width:25%">
    <h2>Welcome to the UDubDubHub</h2>
</div>
<?php
if (isset($_SESSION['login_error'])) {
    echo '<div style="color: red;"><p>' . $_SESSION['login_error'] . '</p></div>';
    unset($_SESSION['login_error']);
}
?>
<form action="index.php?mode=login" method="post">
    <table>
        <tr>
            <td>
                <h2>Login here:</h2>
            </td>
        </tr>
        <tr>
            <td>
                <label for="netID">NetID:</label>
                <input type="text" name="netID" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Login" style="margin: 0%;">
            </td>
        </tr>
        <tr>
            <td>
                <p>Don't have an account? <a class="a-CreateOneLogin" href="initialsurvey.php">Create one</a>.</p>
            </td>
        </tr>
    </table>
</form>
<?php
include "footer.html";
?>