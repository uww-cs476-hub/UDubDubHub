<?php
  session_start();
  include "db_conn.php";

  if (!isset($_SESSION["netID"])) {
    header("Location: login.php");
  }

  $sql = "SELECT f.name as facilityName, d.dayName as dayName, d.hours as hours FROM `facility` f, `day` d WHERE f.name = d.facilityName AND f.type = :type ORDER BY f.name, d.dayName;";
  $parameters = [
    ":type" => "Dining"
  ];
  $stm = $db->prepare($sql);
  $stm->execute($parameters);
  $resultSet = $stm->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dining Hours</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
      .cell {
        display: flex;
        margin: 0;
        flex-direction: column;
        border: 1px solid;
        height: 10%;
      }
    </style>
</head>
<body>
    <div class="styled-container">
      <div class="a-modules a" style="margin-right: 95%;"><a href="modules.php">← Dashboard</a></div>
      <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width: 25%">
      <h1>Dining Hours</h1>
    </div>
    <div class="container-fluid">
      <?php
      for ($x = 0; $x < count($resultSet); $x += 7) {
      ?>
        <div class="row">
          <div class="col-lg-6 cell" style="text-align: center; border-style: solid hidden hidden;">
            <h2><?php echo $resultSet[$x]["facilityName"]; ?></h2>
            <h4><?php echo $resultSet[$x + 1]["dayName"]; ?>: <?php echo $resultSet[$x + 1]["hours"]; ?></h4>
            <h4><?php echo $resultSet[$x + 5]["dayName"]; ?>: <?php echo $resultSet[$x + 5]["hours"]; ?></h4>
            <h4><?php echo $resultSet[$x + 6]["dayName"]; ?>: <?php echo $resultSet[$x + 6]["hours"]; ?></h4>
            <h4><?php echo $resultSet[$x + 4]["dayName"]; ?>: <?php echo $resultSet[$x + 4]["hours"]; ?></h4>
            <h4><?php echo $resultSet[$x]["dayName"]; ?>: <?php echo $resultSet[$x]["hours"]; ?></h4>
            <h4><?php echo $resultSet[$x + 2]["dayName"]; ?>: <?php echo $resultSet[$x + 2]["hours"]; ?></h4>
            <h4><?php echo $resultSet[$x + 3]["dayName"]; ?>: <?php echo $resultSet[$x + 3]["hours"]; ?></h4>
          </div>
          <div class="col-lg-6 cell" style="text-align: center; border-style: solid hidden hidden;">
            <?php
            if (file_exists("Facility Pictures/".$resultSet[$x]['facilityName'].".png")) {
            ?>
              <img src="Facility Pictures/<?php echo $resultSet[$x]["facilityName"] ?>.png" alt="<?php echo $resultSet[$x]["facilityName"] ?>" style="display: block; margin: auto; width: 25%; margin-top: 10px;">
            <?php
            }
            ?>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
<?php
  include "footer.html";
?>