<?php
include('db_conn.php');

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION["username"] = $username;
        header("Location: welcome.php");
    } else {
        // Login failed
        echo "Invalid username or password";
    }
}

$conn->close();
?>