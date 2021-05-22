<?php
require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }
if(!isset($_POST['mdp']) AND !isset($_POST['vmdp'])){

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
            <li class="nav-item">
              <a class="nav-link" href="index.php">Répondre à des questions
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="newquestion.php">Poser une question</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Mon compte</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Connexion</a>
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

          echo '<h1 class="my-4">Inscription</h1>
          <form action="register.php" method="post">
            <div class="form-group">
              <label for="titre">Adresse email scolaire</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="En @efrei.net ou @efrei.fr" required>
            </div>
            <div class="form-group">
              <label for="titre">Votre pseudonyme</label>
              <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo" required>
            </div>
            <div class="form-group">
              <label for="titre">Votre mot de passe</label>
              <input type="password" name="mdp" class="form-control" id="mdp" placeholder="Prenez un mot de passe sûr" required>
            </div>
            <div class="form-group">
              <label for="titre">Confirmez le mot de passe</label>
              <input type="password" name="vmdp" class="form-control" id="vmdp" placeholder="Confirmation" required>
            </div>

            <div class="form-group">
              <label for="role">Choisissez votre rôle</label>
              <select name="role" class="form-control" id="role" required>
                <option value="0">Étudiant (vérification automatique)</option>
                <option value="1">Modérateur (requiert une double vérification manuelle)</option>
                <option value="2">Professeur (requiert un mail en efrei.fr)</option>
              </select>
            </div>

            <div class="form-group">
              <label for="annee">Choisissez votre niveau</label>
              <select name="annee" class="form-control" id="annee" required>
                <option value="1">Cycle préparatoire - L1</option>
                <option value="2">Cycle préparatoire - L2</option>
                <option value="3">Cycle ingénieur - L3</option>
                <option value="4">Cycle ingénieur - M1</option>
                <option value="5">Cycle ingénieur - M2</option>
                <option value="6">Ancien élève diplomé</option>
                <option value="7">Intervenant (tous niveaux)</option>
              </select>
            </div>

            <div class="form-group">
              <label for="majeure">Choisissez votre niveau</label>
              <select name="majeure" class="form-control" id="majeure" required>';

              $majeure_fetch = $bdd->prepare('SELECT * FROM majeures;');
              $majeure_fetch->execute();

              while ($majeure = $majeure_fetch->fetch()) {
                echo '<option value="', $majeure['id'] ,'">', $majeure['nom'] ,'</option>';
              }

              echo '
              </select>
            </div>


            <button type="submit" class="btn btn-primary">S\'inscrire maintenant !</button>
            </form><br><br>';


        echo '</div>

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

  </html>';

}else{
  $req=$bdd->prepare('INSERT INTO utilisateurs(pseudo, email, mdp, role, annee, majeure, inscription) VALUES(:pseudo, :email, :mdp, :role, :annee, :majeure, :inscription);');
  if (isset($_POST['mdp']) AND isset($_POST['vmdp']) AND $_POST['mdp'] == $_POST['vmdp']) {
    $hash=password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    $date = date('Y-m-d H:i:s');
    $req->execute(array(
      'pseudo'=> $_POST['pseudo'],
      'email'=> $_POST['email'],
      'mdp'=> $hash,
      'role'=> $_POST['role'],
      'annee'=> $_POST['annee'],
      'majeure'=> $_POST['majeure'],
      'inscription'=> $date
    ));
    header( "refresh:0;url=index.php" );
    echo 'bienvenue chez le sevice dynamo.';
  }else{
    header( "refresh:0;url=register.php" );
    echo 'Confirmation du mot de passe invalide.';
  }
}
?>
