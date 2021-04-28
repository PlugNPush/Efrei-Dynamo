<?php
require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }
if(!isset($_POST['titre']) AND !isset($_POST['contenu'])){
  echo '<!DOCTYPE html>
  <html>
      <head>
          <meta charset="utf-8" />
          <title>Nouvelle question</title>
      </head>
      <body>
  Nouvelle question<br>
  <form action="newquestion.php" method="post">
  <input type="text" name="titre" placeholder="Titre de la question" required="yes"/><br>
  <textarea name="contenu" rows="15" placeholder="Détaillez le plus possible votre question..." required="yes">
  </textarea><br>
  <select name="matiere" id="matiere">
  <option value="0">MAT1</option>
  <option value="1">MAT2</option>
  <option value="2">MAT3</option>
  </select><br>
  <input type="submit" value="Envoyer la question">
  </form>
  </body>';
}else{
  $req=$bdd->prepare('INSERT INTO questions(auteur, titre, contenu, matiere, date) VALUES(:auteur, :titre, :contenu, :matiere, :date)');
  if (isset($_SESSION['id'])) {
    $date = date('Y-m-d H:i:s');
    $req->execute(array(
      'auteur'=> $_SESSION['id'],
      'titre'=> $_POST['titre'],
      'contenu'=> $_POST['contenu'],
      'matiere'=> $_POST['matiere'],
      'date'=> $date
    ));
    header( "refresh:5;url=index.php" );
    echo 'Votre question a bien été envoyée !';
  }else{
    header( "refresh:5;url=login.php" );
    echo 'Votre session a expiré.';
  }
}
?>
