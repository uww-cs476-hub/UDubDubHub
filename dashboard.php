<?php
    session_start();
    
    include "header.php";

    $modules = [
        'module1' => true,
    ];
    $userRole = isset($_GET['role']) ? $_GET['role'] : 'guest';
    // Include dashboard content based on the user's role
    switch( $userRole ) {
    case 'admin':
        include 'admin_dashboard.php';
        break;
    case 'nf':
        include 'newStudentFreshman.php';
        break;
    case 'soj':
        include 'sophomoreJunior.php';
        break;
    case's+':
        include 'senior.php';
        break;
    default:
        header("Location: welcome.php");
        break;
    }

    include 'footer.php';
?>