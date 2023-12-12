<?php
session_start();

if (!isset($_SESSION["netID"])) {
    header("Location: login.php");
}

include "db_conn.php";

$title = "Module Visibility";
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM `save` WHERE `netID` = :netID;";
    $parameters = [
        ":netID" => $_SESSION["netID"]
    ];
    $stm = $db->prepare($sql);
    $stm->execute($parameters);

    if (isset($_POST["modules"])) {
        foreach($_POST["modules"] as $module) {
            $sql = "INSERT INTO `save` (`moduleName`, `netID`) VALUES (:moduleName, :netID);";
            $parameters = [
                ":moduleName" => $module,
                ":netID" => $_SESSION["netID"]
            ];
            $stm = $db->prepare($sql);
            $stm->execute($parameters);
        }
    }

    header("Location: modules.php");
    exit();
}

$sql = "SELECT * FROM `module`;";
$stm = $db->prepare($sql);
$stm->execute();
$modules = $stm->fetchAll();

$sql = "SELECT `moduleName` FROM `save` WHERE `netID` = :netID";
$parameters = [":netID" => $_SESSION["netID"]];
$stm = $db->prepare($sql);
$stm->execute($parameters);
$resultSet = $stm->fetchAll(PDO::FETCH_ASSOC);
$checked = array();
foreach ($resultSet as $module) {
    array_push($checked, $module["moduleName"]);
}
?>

<h2>Update Module Visibility</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php
    foreach($modules as $module) {
        $moduleName = $module["name"];
    ?>
        <input type="checkbox" name="modules[]" value="<?php echo $moduleName; ?>" <?php echo in_array($moduleName, $checked) ? 'checked' : ''; ?>>
        <label><?php echo $moduleName; ?></label>
        <br>
    <?php
    }
    ?>

    <br>
    <button type="submit">Update Visibility</button>
</form>

</body>

