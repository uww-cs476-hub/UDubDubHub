<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $status = $_POST['status'];
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $enrollmentType = $_POST['enrollmentType'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (firstName, lastName, status, major, minor, enrollmentType, username, password)
            VALUES ('$firstName', '$lastName', '$status', '$major', '$minor', '$enrollmentType', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
