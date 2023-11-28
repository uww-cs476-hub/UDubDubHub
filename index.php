<?php
    session_start();
    include "header.html";
    include "db_conn.php";

    if (!$db) {
        echo "Could not connect to database!";
        exit();
    }

    $mode = isset($_GET['mode'])? $_GET['mode'] : "";
    $parameterValues = null;
    $columns = array();

    if (!isset($_SESSION['netID']) && !isset($_POST['netID'])) {
        header("Location: initialSurvey.php");

        exit();
    }

    switch ($mode) {
        case "login":
            $netID = (isset($_POST["netID"])) ? $_POST["netID"] : "-1";
            $password = (isset($_POST["password"])) ? $_POST["password"] : "-1";
            
            $sql = "SELECT `netID` FROM `user` WHERE `netID` = :netID AND `password` = :password;";
            $parameters = [
                ":netID" => $netID,
                ":password" => hash('sha256', $password)
            ];

            $stm = $db->prepare($sql);
            $stm->execute($parameters);
            $result = $stm->fetch();

            if (isset($result['netID'])) {
                $_SESSION['netID'] = $netID;

                header("Location: index.php?mode=home");
            }
            else {
                header("Location: login.php");
            }

            break;
        
        case "home":
            include "welcome.php";

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

            $sql = "SELECT `netID` FROM `user` WHERE `netID` = :netID";
            $parameters = [
                ":netID" => $netID
            ];
            $stm = $db->prepare($sql);
            $stm->execute($parameters);
            $resultSet = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultSet) > 0) {
                echo "Username unavailable";
            }
            else {
                $sql = "INSERT INTO user (netID, firstName, lastName, password, standing, enrollmentType, email)
                        VALUES (:netID, :firstName, :lastName, :password, :standing, :enrollmentType, :email);";
                $parameters = [
                    ":netID" => $netID,
                    ":firstName" => $firstName,
                    ":lastName" => $lastName,
                    ":password" => hash('sha256', $password),
                    ":standing" => $standing,
                    ":enrollmentType" => $enrollmentType,
                    ":email" => $email
                ];
                $stm = $db->prepare($sql);
                $stm->execute($parameters);

                $sql = "INSERT INTO majors_in (netID, majorName)
                        VALUES (:netID, :majorName);";
                $parameters = [
                    ":netID" => $netID,
                    ":majorName" => $major
                ];
                $stm = $db->prepare($sql);
                $stm->execute($parameters);
                
                if ($minor != "None") {
                    $sql = "INSERT INTO minors_in (netID, minorName)
                            VALUES (:netID, :minorName);";
                    $parameters = [
                        ":netID" => $netID,
                        ":minorName" => $minor
                    ];
                    $stm = $db->prepare($sql);
                    $stm->execute($parameters);
                }

                $_SESSION["netID"] = $netID;

                header("Location: index.php?mode=home");
            }

            break;

        case "logout":
            session_unset();
            setcookie(session_name(), '', time()-1000, '/');
            $_SESSION = array();

            header("Location: login.php");

            break;

        default:
            include "initialSurvey.php";

            break;
    }

    include "footer.html";
            
?>