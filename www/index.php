<?php
session_start();
echo '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Efrei Dynamo</title>
    <style>
      .screen {
        height: 100vh;
        width: 100%;
        text-align: center;
        display: table;
      }

      .v-center {
        display: table-cell;
        vertical-align: middle;
      }

      p {
        margin: auto;
        color: white;
        font-family: "Helvetica Neue Light", Helvetica, sans-serif;
        text-decoration: none;
        font-size: 60px;
        font-weight: thin;
      }
      b {
        color: white;
        font-family: "Helvetica Neue Bold", Helvetica, sans-serif;
        font-size: 60px;
        font-weight: 3000;
      }
      a {
        color: white;
        font-family: "Helvetica Neue Bold", Helvetica, sans-serif;
        text-decoration: none;
        font-size: 60px;
        font-weight: thin;
      }
      a:hover {
        cursor: default;
      }
      body {
        background-color: black;
      }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div class="screen">
      <div class="v-center">';
if(isset($_SESSION['id'])){
    echo '<p><b>Bienvenue à toi ', $_SESSION['pseudo'], '</b>. <a href = "logout.php">Se déconnecter</a></p>';
}
else {
  echo '<p><b>Projet Dynamo</b><br>Rendez-vous prochainement.</p>';
}
echo '</div>
</div>
</body>
</html>';
?>
