<?php
require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }
  session_start();
  if (isset($_SESSION['id'])) {
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?;');
    $req->execute(array($_SESSION['id']));
    $test = $req->fetch();
    $_SESSION['id'] = $test['id'];
    $_SESSION['pseudo'] = $test['pseudo'];
    $_SESSION['email'] = $test['email'];
    $_SESSION['role'] = $test['role'];
    $_SESSION['annee'] = $test['annee'];
    $_SESSION['majeure'] = $test['majeure'];
    $_SESSION['validation'] = $test['validation'];
    $_SESSION['karma'] = $test['karma'];
    $_SESSION['inscription'] = $test['inscription'];
    $_SESSION['photo'] = $test['photo'];
    $_SESSION['linkedin'] = $test['linkedin'];
  }

if (!isset($_POST['contenu'])) {
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
        <a class="navbar-brand" href="index.php">Projet Efrei Dynamo (internal)</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Répondre à des questions
              </a>
              <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="newquestion.php">Poser une question</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Mon compte</a>
            </li>';

            if (isset($_SESSION['id'])) {
              echo '
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Se déconnecter</a>
              </li>';
            } else {
              echo '
              <li class="nav-item">
                <a class="nav-link" href="login.php">Connexion</a>
              </li>';
            }

            echo '
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
          header( "refresh:0;url=login.php" );
          echo 'Votre session a expiré.';
        } else if (isset($_SESSION['validation']) && $_SESSION['validation'] == 1){
          if (!isset($_GET['question'])) {
            echo '<div class="alert alert-danger fade show" role="alert">
              <strong>Il semblerait que vous ne répondiez à personne...</strong>. La question a peut-être été supprimée. Si vous pensez qu\'il s\'agit d\'une erreur, contactez un administrateur.
              <hr>
              <b>Rappel: ce qu\'il se passe sur la Internal reste sur la Internal.</b>
              <span aria-hidden="true">&times;</span>
              </button>
            </div><br><br>';
          } else {
            echo '<h1 class="my-4">Répondre à une question</h1>
            <form action="newresponse.php?question=',$_GET['question'],'" method="post">
              <div class="form-group">
                <label for="contenu">Votre réponse</label>
                <textarea name="contenu" class="form-control" id="contenu" placeholder="Soyez pédagogue, n\'oubliez pas que d\'autres Efreiens s\'appuieront sur votre réponse pour mieux apprendre si elle est validée..." rows="7" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Envoyer la réponse</button>
              </form><br><br>';
          }

        } else {
          echo '<div class="alert alert-danger fade show" role="alert">
            <strong>Votre statut d\'Efreien n\'a pa encore été vérifié.</strong>. Vérifiez vos spams ou contactez un modérateur avec votre adresse mail Efrei. <a href="logout.php">Déconnectez-vous ici</a>.
            <hr>
            <b>Rappel: ce qu\'il se passe sur la Internal reste sur la Internal.</b>
            <span aria-hidden="true">&times;</span>
            </button>
          </div><br><br>';
        }

        echo '</div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">&copy; 2021 Efrei Dynamo. Tous droits reservés. <a href="/legal.php">Mentions légales</a>.</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

  </html>';
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
