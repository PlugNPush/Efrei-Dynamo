<?php
require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }
  session_start();
if(!isset($_POST['titre']) AND !isset($_POST['contenu']) AND !isset($_POST['matiere'])){

  echo '<!DOCTYPE html>
  <html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta http-equiv="Content-Security-Policy" content="default-src \'self\'; img-src https://* \'self\' data:; child-src \'none\';">

    <title>Efrei Dynamo (internal)</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Projet Efrei Dynamo (internal)</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Répondre à des questions
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="newquestion.php">Poser une question</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Mon compte</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Se déconnecter</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">';

        if (!isset($_SESSION['id'])){
          header( "refresh:5;url=login.php" );
          echo 'Votre session a expiré.';
        } else if (isset($_SESSION['validation']) && $_SESSION['validation'] == 1){
          echo '<h1 class="my-4">Nouvelle question</h1>
          <form action="newquestion.php" method="post">
          <input type="text" name="titre" placeholder="Titre de la question" required="yes"/><br>
          <textarea name="contenu" rows="15" placeholder="Détaillez le plus possible votre question..." required="yes"></textarea><br>
          <select name="matiere" id="matiere">
          <option value="0">MAT1</option>
          <option value="1">MAT2</option>
          <option value="2">MAT3</option>
          </select><br>
          <input type="submit" value="Envoyer la question">
          </form>';
        } else {
          echo '<div class="alert alert-danger fade show" role="alert">
            <strong>Votre statut d\'Efreien n\'a pa encore été vérifié.</strong>. Vérifiez vos spams ou contactez un modérateur avec votre adresse mail Efrei. <a href="logout.php">Déconnectez-vous ici</a>.
            <hr>
            <b>Rappel: ce qu\'il se passe sur la Internal reste sur la Internal.</b>
            <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
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
