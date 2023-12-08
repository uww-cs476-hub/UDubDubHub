<?php
    session_start();

    include "db_conn.php";

    $netID = $_SESSION["netID"];

    $data = json_decode(file_get_contents("php://input"), true);

    $method = $data["method"];
    
    if ($method == "add") {
        $title = $data["noteTitle"];
        $details = $data["noteContent"];
        $updateTime = $data["noteUpdateTime"];
        $creationTime = $data["noteCreationTime"];

        $sql = "INSERT INTO `note` (`title`, `details`, `creationTime`, `updateTime`, `netID`)
                VALUES (:title, :details, :creationTime, :updateTime, :netID);";
        $parameters = [
            ":title" => $title,
            ":details" => $details,
            ":creationTime" => $creationTime,
            ":updateTime" => $updateTime,
            ":netID" => $netID
        ];
        $stm = $db->prepare($sql);
        $stm->execute($parameters);
        
        $responseID = $db->lastInsertId();
        $returnData = array('responseID' => $responseID);
        echo json_encode($returnData);
    }
    else if ($method == "update") {
        $ID = $data["noteID"];
        $updateTime = $data["noteUpdateTime"];

        $sql = "";
        $parameters = [];

        if (isset($data["noteTitle"])) {
            $title = $data["noteTitle"];
            $sql = "UPDATE `note` SET `title` = :title, `updateTime` = :updateTime WHERE `ID` = :ID;";
            $parameters = [
                ":ID" => $ID,
                ":title" => $title,
                ":updateTime" => $updateTime
            ];
        }
        else if (isset($data["noteContent"])) {
            $details = $data["noteContent"];
            $sql = "UPDATE `note` SET `details` = :details, `updateTime` = :updateTime WHERE `ID` = :ID;";
            $parameters = [
                ":ID" => $ID,
                ":details" => $details,
                ":updateTime" => $updateTime
            ];
        }

        $stm = $db->prepare($sql);
        $stm->execute($parameters);
    }
    else if ($method == "delete") {
        $ID = $data["noteID"];

        $sql = "DELETE FROM `note` WHERE `ID` = :ID";
        $parameters = [":ID" => $ID];
        $stm = $db->prepare($sql);
        $stm->execute($parameters);
    }
?>