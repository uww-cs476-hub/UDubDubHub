<?php
    session_start();
    if (!isset($_SESSION["isAdmin"])) {
        header("Location: modules.php");
    }
    if (!$_SESSION["isAdmin"]) {
        header("Location: modules.php");
    }

    include "db_conn.php";

    $title = "Submitted Events";
    include "header.php";

    if (isset($_POST["decline"])) {
        $sql = "DELETE FROM `event` WHERE `ID` = :id";
        $parameters = [
            "id" => $_POST["decline"]
        ];
        $stm = $db->prepare($sql);
        $stm->execute($parameters);

        header("Location: submittedEvents.php");
    }

    $sql = "SELECT `ID`, `name`, `description`, `location`, `startTime`, `endTime`, `netID` FROM `event`;";
    $stm = $db->prepare($sql);
    $stm->execute();
    $resultSet = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="styled-container">
    <div class="a-modules a" style="margin-right: 95%;"><a href="modules.php">← Dashboard</a></div>
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width: 25%;">
    <h2>Submitted Events</h2>
</div>

<?php
    $columns = ["Name", "Description", "Location", "Start Time", "End Time", "Submitted By", "Accept/Decline"];
?>

<table class="event-table">
    <tr>
    <?php
    foreach($columns as $column) {
    ?>
        <th class="event-th" style="font-size: 20px; border: 1px solid; color: black;"><?php echo $column; ?></th>
    <?php
    }
    ?>
    </tr>
    <?php
    foreach($resultSet as $event) {
    ?>
        <tr>
            <?php
            foreach($event as $key => $value) {
                if ($key == "ID") {
                    continue;
                }
            ?>
                <td class="event-td">
                    <?php
                    if ($key == "startTime" || $key == "endTime") {
                        echo formatDateTime($value);
                    }
                    else {
                        echo $value;
                    }
                    ?>
                </td>
            <?php
            }
            ?>
            <td class="event-td">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <button type="submit" name="accept" id="event-admin-accept" value="<?php echo $event["ID"] ?>">Accept</button>
                    <button type="submit" name="decline" id="event-admin-decline" value="<?php echo $event["ID"] ?>">Decline</button>
                </form>
            </td>
        </tr>
    <?php
    }
    ?>
</table>

<?php
    function formatDateTime($datetime) {
        $year = substr($datetime, 0, 4);
        $month = substr($datetime, 5, 2);
        $day = substr($datetime, 8, 2);
        $hoursStr = substr($datetime, 11, 2);
        $hours = intval($hoursStr);
        $minutes = substr($datetime, 14, 2);

        $ampm = $hours > 12 ? "PM" : "AM";

        if ($ampm == "PM") {
            $hours = $hours - 12;
        }

        return $month . "/" . $day . "/" . $year . " at " . $hours . ":" . $minutes . " " . $ampm;
    }

    include "footer.html";
?>