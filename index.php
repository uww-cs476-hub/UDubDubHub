<?php
    session_start();

    $title = "Home";
    include "header.php";
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

        case "submitEvent":
            $eventName = $_POST["eventName"];
            $startTime = $_POST["startTime"];
            $endTime = $_POST["endTime"];
            $eventLocation = $_POST["eventLocation"];
            $description = $_POST["description"];

            $sql = "INSERT INTO `event` (`name`, `startTime`, `endTime`, `location`, `description`, `netID`)
                    VALUES (:eventName, :startTime, :endTime, :location, :description, :netID);";
            $parameters = [
                ":eventName" => $eventName,
                ":startTime" => $startTime,
                ":endTime" => $endTime,
                ":location" => $eventLocation,
                ":description" => $description,
                ":netID" => $_SESSION["netID"]
            ];

            $stm = $db->prepare($sql);
            $stm->execute($parameters);

            header("Location: modules.php");

            break;
        
        case "login":
            $netID = (isset($_POST["netID"])) ? $_POST["netID"] : "-1";
            $password = (isset($_POST["password"])) ? $_POST["password"] : "-1";
            
            $sql = "SELECT `netID`, `firstName`, `isAdmin` FROM `user` WHERE `netID` = :netID AND `password` = :password;";
            $parameters = [
                ":netID" => $netID,
                ":password" => hash('sha256', $password)
            ];

            $stm = $db->prepare($sql);
            $stm->execute($parameters);
            $result = $stm->fetch();

            if (isset($result['netID'])) {
                $_SESSION['netID'] = $netID;
                $_SESSION['firstName'] = $result['firstName'];
                $_SESSION['isAdmin'] = $result['isAdmin'];
                header("Location: modules.php");
            } else {
                $_SESSION['login_error'] = "Incorrect username or password!";
                header("Location: login.php");
            }

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
                $_SESSION['username_error'] = "Username unavailable!";
                header("Location: initialsurvey.php");
            }
            else {
                $sql = "INSERT INTO user (netID, firstName, lastName, password, standing, enrollmentType, email, isAdmin)
                        VALUES (:netID, :firstName, :lastName, :password, :standing, :enrollmentType, :email, :isAdmin);";
                $parameters = [
                    ":netID" => $netID,
                    ":firstName" => $firstName,
                    ":lastName" => $lastName,
                    ":password" => hash('sha256', $password),
                    ":standing" => $standing,
                    ":enrollmentType" => $enrollmentType,
                    ":email" => $email,
                    ":isAdmin" => false
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

                $modules = [];
                switch($standing) {
                    case "Transfer Student":
                    case "Freshman":
                        $modules = [
                            'Get to Know Your Way Around Campus',
                            'Helpful Academic Resources',
                            'Campus Life Resources',
                            'Other Resources',
                            'Student Directory',
                            'Get Involved',
                            'Need Technical Help?'
                        ];

                        break;
                    
                    case "Sophomore":
                    case "Junior":
                        $modules = [
                            'Campus Life Resources',
                            'Student Directory',
                            'Get Involved',
                            'Need Technical Help?'
                        ];

                        break;

                    case "Senior":
                        $modules = [
                            'Student Directory',
                            'Get Involved',
                            'Need Technical Help?',
                            'Graduation Resources',
                            'Career Resources'
                        ];

                        break;
                    
                    default:
                        $modules = [
                            'Get to Know Your Way Around Campus',
                            'Helpful Academic Resources',
                            'Campus Life Resources',
                            'Student Directory',
                            'Get Involved',
                            'Need Technical Help?',
                            'Graduation Resources',
                            'Career Resources'
                        ];

                        break;
                }

                foreach ($modules as $module) {
                    $sql = "INSERT INTO `save` (moduleName, netID) VALUES (:moduleName, :netID);";
                    $parameters = [
                        ":moduleName" => $module,
                        ":netID" => $netID
                    ];
                    $stm = $db->prepare($sql);
                    $stm->execute($parameters);
                }

                $_SESSION["netID"] = $netID;
                $_SESSION['firstName'] = $firstName;

                header("Location: modules.php");
            }

            break;

        case "logout":
            session_unset();
            setcookie(session_name(), '', time()-1000, '/');
            $_SESSION = array();

            header("Location: login.php");

            break;

        default:
            header("Location: modules.php");

            break;
    }

    include "footer.html";
            
?>