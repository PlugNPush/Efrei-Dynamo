<?php
require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }
  session_start();
  if (!isset($_GET['question'])){
    echo '<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Erreur</title>
        </head>
        <body>
    Il semblerait que vous ne répondiez à personne...<br>
    </body>';

  } else if(!isset($_POST['contenu'])){
  echo '<!DOCTYPE html>
  <html>
      <head>
          <meta charset="utf-8"/>
          <title>Nouvelle réponse</title>
      </head>
      <body>
  Nouvelle réponse<br>
  <form action="newresponse.php?question=',$_GET['question'],'" method="post">
  <textarea name="contenu" rows="15" placeholder="Expliquez votre réponse" required="yes"></textarea><br>
  <input type="submit" value="Envoyez la réponse">
  </form>
  </body>';
  } else {
  $req=$bdd->prepare('INSERT INTO reponses(question, auteur, contenu, date) VALUES(:question, :auteur, :contenu, :date);');
  if (isset($_SESSION['id'])) {
    $date = date('Y-m-d H:i:s');
    $req->execute(array(
      'question'=> $_GET['question'],
      'auteur'=> $_SESSION['id'],
      'contenu'=> $_POST['contenu'],
      'date'=> $date
    ));
    header( "refresh:0;url=question.php?id=" . $_GET['question']);
    echo 'Votre réponse a bien été envoyée !';
  }else{
    header( "refresh:0;url=login.php" );
    echo 'Votre session a expiré.';
  }
}
?>
