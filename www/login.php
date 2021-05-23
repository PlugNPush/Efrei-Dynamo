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

if (isset($_POST['email']) AND isset($_POST['mdp'])){
  // Hachage du mot de passe
  $pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

  // Vérification des identifiants
  $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = ?;');
  $req->execute(array($_POST['email']));
  $test = $req->fetch();


  $verify = password_verify($_POST['mdp'], $test['mdp']);
  if ($verify)
  {
      session_start();
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


      header( "refresh:0;url=index.php" );
  } else {
      header( "refresh:0;url=login.php?passworderror=true" );
  }
} else {
  echo '<!DOCTYPE html>
  <html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta http-equiv="Content-Security-Policy" content="default-src \'self\'; img-src https://* \'self\' data:; child-src \'none\';">

    <title>Efrei Dynamo</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Projet Efrei Dynamo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Répondre à des questions
              </a>
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
              <li class="nav-item active">
                <a class="nav-link" href="login.php">Connexion
                <span class="sr-only">(current)</span></a>
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

          echo '<h1 class="my-4">Connexion</h1>
          <form action="login.php" method="post">
            <div class="form-group">
              <label for="email">Saisissez votre adresse e-mail</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Courriel" required>
            </div>
            <div class="form-group">
              <label for="mdp">Saisissez votre mot de passe</label>
              <input type="password" name="mdp" class="form-control';

              if (isset($_GET['passworderror'])){
                echo ' is-invalid';
              }

              echo '" id="mdp" placeholder="Mot de passe" required>';

              if (isset($_GET['passworderror'])){
                echo '<div class="invalid-feedback">
                  Mot de passe incorrect ! Besoin d\'aide ? Contactez un administrateur.
                </div>';
              }

              echo '
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
            <br>Pas encore inscrit ? <a class="btn btn-secondary" href=/register.php>Inscrivez-vous maintenant !</a>
            </form><br><br>';

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

}

?>
