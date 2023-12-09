<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>UDubDubHub</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="styles.css">
    <style>
    .styled-container { 
        background-color: rebeccapurple;
        color: white;
        padding:1%;
        text-align: center;
        font-family: 'Times New Roman', Times, serif;
    }
    .cell {
      display:flex;
      margin:0;
      flex-direction:column;
      border: 1px solid;
      height: 10%;
    }
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      height: 10%;
      width: 100%;
      background-color: rebeccapurple;
      color: white;
      text-align: center;
    }
    </style> <!--This is temporary until connected back to css page-->
</head>
<body>
    <div class="styled-container">
      <div class="a-modules a" style="margin-right: 95%;"><a href="modules.php">← Dashboard</a></div>
      <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width: 25%">
      <h1>Dining Information</h1>
    </div>
    <div class="jumbotron text-center">
        <h1>Bootstrap 3 Jumbotron</h1>
        <p>Important info/alert area?</p>
    </div id = "grid-container">

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6 cell" style="text-align: center;">
            <h3>Column 1</h3>
            <h2>One for location name + days and hours?</h2>
          </div>
          <div class="col-lg-6 cell" style="text-align: left;">
            <h3>Column 2</h3>
            <h2>Another for picture/logo + info? </h2>
          </div>
        </div>
      </div>

      <div class="container footer">
        <div class="row">
          <div class="col-sm-12 cell" style="text-align: center;">
            <h3>for contact? Other links/info?</h3>
          </div>
        </div>
      </div>
<?php
  include "footer.html";
?>