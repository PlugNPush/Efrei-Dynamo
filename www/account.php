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

if (isset($_GET['id'])){
  $compte = $_GET['id'];
} else if (isset($_SESSION['id'])){
  $compte = $_SESSION['id'];
} else {
  $compte = 0;
}

if (!isset($_POST['id'])) {

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
              <a class="nav-link" href="index.php">Répondre à des questions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="newquestion.php">Poser une question</a>
            </li>';

            if (isset($_SESSION['id']) && $_SESSION['id'] = $compte){
              echo '
              <li class="nav-item active">
                <a class="nav-link" href="account.php">Mon compte
                <span class="sr-only">(current)</span></a>
              </li>';
            } else {
              echo '
              <li class="nav-item">
                <a class="nav-link" href="account.php">Mon compte</a>
              </li>';
            }


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
        } else {
          echo '<h1 class="my-4">Nouvelle question</h1>';
          if (!isset($_SESSION['validation']) || $_SESSION['validation'] != 1){
            echo '
            <div class="alert alert-danger fade show" role="alert">
              <strong>Votre statut d\'Efreien n\'a pa encore été vérifié.</strong>. Vérifiez vos spams ou contactez un modérateur avec votre adresse mail Efrei. <a href="logout.php">Déconnectez-vous ici</a>.
            </div><br><br>';
          }

          // Informations standard + modification
          $gather = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?;');
          $gather->execute(array($compte));
          $data = $gather->fetch();

          if (!$data){
            echo '
            <div class="alert alert-danger fade show" role="alert">
              <strong>Une erreur s\'est produite</strong>. Il semblerait que le compte d\'utilisateur que vous cherchiez n\'existe plus. Essayez de <a href="login.php">vous reconnecter ici</a>.
            </div><br><br>';
          }

          // DYN $_SESSION['pseudo'] = $test['pseudo'];
          // DYN $_SESSION['email'] = $test['email'];
          // DYN $_SESSION['annee'] = $test['annee'];
          // DYN $_SESSION['majeure'] = $test['majeure'];
          // DYN $_SESSION['photo'] = $test['photo'];
          // DYN $_SESSION['linkedin'] = $test['linkedin'];

          echo '
          <h2>Informations sur le compte</h2>
          <form action="account.php" method="post">
          <div class="form-group">
            <label for="id">Identifiant interne</label>
            <input type="text" name="id" class="form-control" id="id" value="', $data['id'] ,'" ', ($_SESSION['role']>=50) ? ('') : ('disabled'), '>
            <small id="emailHelp" class="form-text text-muted">
              L\'identifiant interne est immuable et vaut ', $data['id'] ,'
            </small>
          </div>
          <div class="form-group">
            <label for="inscription">Date d\'inscription</label>
            <input type="text" name="inscription" class="form-control" id="inscription" value="', $data['inscription'] ,'" ', ($_SESSION['role']>=50) ? ('') : ('disabled'), '>
            <small id="emailHelp" class="form-text text-muted">
              La date d\'inscription est immuable et vaut ', $data['inscription'] ,'
            </small>
          </div>
          <div class="form-group">
            <label for="role">Rôle</label>
            <input type="text" name="role" class="form-control" id="role" value="', $data['role'] ,'" ', ($_SESSION['role']>=10) ? ('') : ('disabled'), '>
            <small id="emailHelp" class="form-text text-muted">
              ', ($_SESSION['role']>=10) ? ('En tant qu\'ultra-modérateur, vous pouvez modifier le rôle. ') : (''), 'Le rôle actuel est ', $data['role'] ,'
            </small>
          </div>
          <div class="form-group">
            <label for="karma">Karma</label>
            <input type="text" name="karma" class="form-control" id="karma" value="', $data['karma'] ,'" ', ($_SESSION['role']>=3) ? ('') : ('disabled'), '>
            <small id="emailHelp" class="form-text text-muted">
              ', ($_SESSION['role']>=3) ? ('En tant que super-modérateur, vous pouvez modifier le solde Karma. ') : (''), 'Le solde de Karma est ', $data['karma'] ,'
            </small>
          </div>
          <div class="form-group">
            <label for="validation">Validation Efrei</label>
            <input type="text" name="validation" class="form-control" id="validation" value="', $data['validation'] ,'" ', ($_SESSION['role']>=3) ? ('') : ('disabled'), '>
            <small id="emailHelp" class="form-text text-muted">
              ', ($_SESSION['role']>=3) ? ('En tant que super-modérateur, vous pouvez modifier le statut de validation Efrei. ') : ('Le statut de validation Efrei ne peut pas être modifié ici.'), 'Il est actuellement à ', $data['validation'] ,'
            </small>
          </div>


          <div class="form-group">
            <label for="titre">Pseudonyme</label>
            <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo">
          </div>
            <div class="form-group">
              <label for="titre">Adresse email scolaire</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="En @efrei.net ou @efrei.fr" required>
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
              <label for="majeure">Choisissez votre majeure</label>
              <select name="majeure" class="form-control" id="majeure" required>';

              $majeure_fetch = $bdd->prepare('SELECT * FROM majeures;');
              $majeure_fetch->execute();

              while ($majeure = $majeure_fetch->fetch()) {
                echo '<option value="', $majeure['id'] ,'">', $majeure['nom'] ,'</option>';
              }

              echo '
              </select>
            </div>


            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
            <button type="reset" class="btn btn-secondary">Annuler les modifications</button>
            </form><br><br>';

          // Boutons GDPR

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
    header( "refresh:0;url=account.php" );
  }else{
    header( "refresh:0;url=login.php" );
  }
}
?>