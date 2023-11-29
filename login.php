<?php
include "header.html";
?>
<h2>Login</h2>
<form action="index.php?mode=login" method="post">
    <label for="netID">NetID:</label>
    <input type="text" name="netID" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Login">
</form>
<?php
include "footer.html";
?>