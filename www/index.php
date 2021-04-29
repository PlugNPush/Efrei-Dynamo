<?php
require_once dirname(__FILE__).'/../../config/config.php';
try
{
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['validation']) && $_SESSION['validation'] == 1){

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
          <div class="col-md-8">

            <h1 class="my-4">Bienvenue sur Efrei Dynamo,
              <small>', $_SESSION['pseudo'], '</small>
            </h1>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Avertissement de confidentialité</strong> : Vous êtes actuellement sur une version Internal du projet Dynamo. En théorie, si vous voyez ceci, vous faites partie de l\'équipe du projet Transverse. Le contenu de ce site Internet n\'est pas contrôlé ou modéré, et le traitement des données n\'est pas conforme aux normes européennes RGPD car le site n\'est pas censé être accéssible au public. Si vous lisez ce message alors que vous n\'êtes pas isolé, cessez immédiatement la navigation et <a href="logout.php">déconnectez-vous ici</a>.
              <hr>
              <b>Ce qu\'il se passe sur la Internal reste sur la Internal.</b>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';

            $fetch_question=$bdd->prepare('SELECT * FROM questions;');
            $fetch_question->execute();
            while($temp_question=$fetch_question->fetch()){

              $auteur_question=$bdd->prepare('SELECT pseudo FROM utilisateurs WHERE id = ?;');
              $auteur_question->execute(array($temp_question['auteur']));
              $auteur = $auteur_question->fetch();

              echo '<!-- Blog Post -->
              <div class="card mb-4">
                <div class="card-body">
                  <h2 class="card-title">', $temp_question['titre'],'</h2>
                  <p class="card-text">', limit_text($temp_question['contenu'], 80),'</p>
                  <a href="question.php?id=',$temp_question['id'],'" class="btn btn-primary">Voir plus &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                  Publié le ', $temp_question['date'],' par
                  <a href="#">', $auteur['pseudo'],'</a>
                </div>
              </div>';
            }

            echo '<!-- Pagination -->
            <ul class="pagination justify-content-center mb-4">
              <li class="page-item">
                <a class="page-link" href="#">&larr; Plus ancien</a>
              </li>
              <li class="page-item disabled">
                <a class="page-link" href="#">Plus récent &rarr;</a>
              </li>
            </ul>

          </div>

          <!-- Sidebar Widgets Column -->
          <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
              <h5 class="card-header">Rechercher</h5>
              <div class="card-body">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Rechercher...">
                  <span class="input-group-append">
                    <button class="btn btn-secondary" type="button">Go !</button>
                  </span>
                </div>
              </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
              <h5 class="card-header">Catégories</h5>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                      <li>
                        <a href="#">L1</a>
                      </li>
                      <li>
                        <a href="#">L2</a>
                      </li>
                      <li>
                        <a href="#">L3</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                      <li>
                        <a href="#">M1</a>
                      </li>
                      <li>
                        <a href="#">M2</a>
                      </li>
                      <li>
                        <a href="#">Campus</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
              <h5 class="card-header">Récapitulatif</h5>
              <div class="card-body">
                Vous avez posé 0 questions, et vous avez répondu à 0 questions sur Efrei Dynamo. 0 questions sont en attente de réponse dans votre promo.
              </div>
            </div>

          </div>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.container -->

      <!-- Footer -->
      <footer class="py-5 bg-dark">
        <div class="container">
          <p class="m-0 text-center text-white">&copy; 2021 Efrei Dynamo. Tous droits reservés.</p>
        </div>
        <!-- /.container -->
      </footer>

      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>
';

}
else {
  echo '<!DOCTYPE html>
  <html lang=fr>
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
        if (isset($_SESSION['validation'])) {
          echo '<p><b>Hello ', $_SESSION['pseudo'], ' !</b><br> Tu dois confirmer ton statut d\'Efreien pour accéder au site.<br><a href = "logout.php">Se déconnecter</a></p>';
        } else {
          echo'<p><b>Projet Dynamo</b><br>Rendez-vous prochainement.</p>';
        }
        echo '
        </div>
      </div>
    </body>
  </html>';
}

?>
