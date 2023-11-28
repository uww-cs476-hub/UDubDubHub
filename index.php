<?php
    session_start();
    include "db_conn.php";

    if (!$db) {
        echo "Could not connect to database!";
        exit();
    }

    $mode = "";
    $parameterValues = null;
    $pageTitle = "";
    $columns = array();

    if (isset($_GET['mode'])) {
        $mode = $_GET['mode'];
    }

    switch ($mode) {
        case "register":
            include "initialSurvey.html";
            break;
        case "addNewUser":
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $standing = $_POST['standing'];
            $major = $_POST['major'];
            $minor = $_POST['minor'];
            $enrollmentType = $_POST['enrollmentType'];
            $netID = $_POST['netID'];
            $password = $_POST['password'];
            $email = $netID."@uww.edu";
            
            $parameters = [
                ":netID" => $netID,
                ":firstName" => $firstName,
                ":lastName" => $lastName,
                ":password" => hash('sha256', $password),
                ":standing" => $standing,
                ":enrollmentType" => $enrollmentType,
                ":email" => $email
            ];

            $sql = "INSERT INTO user (netID, firstName, lastName, password, standing, enrollmentType, email)
                    VALUES (:netID, :firstName, :lastName, :password, :standing, :enrollmentType, :email);";
            $stm = $db->prepare($sql);
            $stm->execute($parameters);

            $_SESSION["validNetID"] = $netID;

            break;
    }
            
?>