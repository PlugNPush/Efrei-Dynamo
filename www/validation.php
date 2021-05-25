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

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_SESSION['id'])){

  if (isset($_GET['downgrade'])) {
    $newrole = $bdd->prepare('UPDATE utilisateurs SET role = 0 WHERE id = ?;');
    $newrole->execute(array($_SESSION['id']));

    header( "refresh:0;url=validation.php" );
  } else if (!isset($_POST['email'])){
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
              </li>
              <li class="nav-item">
                <a class="nav-link" href="account.php">Mon compte</a>
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


            echo'<h1 class="my-4">Statut de validation Efrei</h1>';


            $gatherdata = $bdd->prepare('SELECT * FROM validations WHERE user = ?;');
            $gatherdata->execute(array($_SESSION['id']));
            $data = $gatherdata->fetch();


            if (isset($_GET['invalidmail'])) {
              echo '<div class="alert alert-danger fade show" role="alert">
                <strong>Adresse e-mail invalide !</strong><br> Il semblerait que l\'adresse email fournie ne soit pas fournie par l\'Efrei.
              </div>';
            }

            if (isset($_GET['invalidkey'])) {
              echo '<div class="alert alert-danger fade show" role="alert">
                <strong>Erreur lors de la validation !</strong><br> Il semblerait que la clé d\'authentification unique envoyée sur votre adresse email soit erronée. Veuillez réessayer.
              </div>';
              }

            if (isset($_SESSION['validation']) && $_SESSION['validation'] == 1 && $data) {
              echo '<div class="alert alert-success fade show" role="alert">
                <strong>Félicitations, votre compte Efrei est validé !</strong><br>Vous n\'avez rien à faire, nous avons vérifié votre appartenance à l\'Efrei avec l\'adresse email suivante : <a href="mailto:', $data['email'] ,'">', $data['email'] ,'</a>.
              </div>
              <a href="index.php" class="btn btn-success btn-lg btn-block">Accéder à Efrei Dynamo</a><br><br>';
            } else if (isset($_SESSION['validation']) && $_SESSION['validation'] == 1) {
              echo '<div class="alert alert-success fade show" role="alert">
                <strong>Votre compte Efrei est validé manuellement !</strong><br>Vous n\'avez rien à faire, nous avons vérifié votre appartenance à l\'Efrei via un de nos modérateurs.
              </div>
              <a href="index.php" class="btn btn-success btn-lg btn-block">Accéder à Efrei Dynamo</a><br><br>';
            } else {

              if ($_SESSION['role'] == 0 || $_SESSION['role'] == 2) {
                echo '<div class="alert alert-warning fade show" role="alert">
                  <strong>Hello ', $_SESSION['pseudo'], ' !</strong><br> Tu dois confirmer ton statut d\'Efreien pour accéder au site.<br>Suis les instructions ci-dessous pour procéder à la validation.
                </div>';
              } else if ($_SESSION['role'] == 1) {
                echo '<div class="alert alert-danger fade show" role="alert">
                  <strong>Tu n\'es pas éligible à la vérification automatique</strong>.<br> Tu as demandé à être modérateur, et pour cela nous devons vérifier manuellement ton statut. Contacte un autre modérateur, ou rétrograde ton profil vers un profil étudiant pour valider ton compte immédiatement.
                </div>
                <a href="validation.php?downgrade=true" class="btn btn-warning btn-lg btn-block">Rétrograder vers un profil étudiant</a><br><br>';
              } else {
                echo '<div class="alert alert-danger fade show" role="alert">
                  <strong>Tu n\'es pas éligible à la vérification automatique</strong>.<br> Tu es un super-modérateur, il semblerait que nous ayons oublié de vérifier manuellement ton statut. Utilise ton pouvoir de super-modérateur pour t\'auto-certifier.
                </div>
                <a href="account.php" class="btn btn-primary btn-lg btn-block">Modifier les réglages du compte</a><br><br>';
              }




          }

          echo '
          </div>

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

    </html>
';
} else if (!isset($_GET['key'])){

  if (str_contains($_POST['email'], "@efrei.net") OR str_contains($_POST['email'], "@efrei.fr")) {
    $newmail = $bdd->prepare('UPDATE utilisateurs SET email = ? WHERE id = ?;');
    $newmail->execute(array($_POST['email'], $_SESSION['id']));

    $key = generateRandomString(32);

    $newkey = $bdd->prepare('INSERT INTO validations(user, email, key) VALUES(:user, :email, :key);');
    $newkey->execute(array(
      'user' => $_SESSION['id'],
      'email' => $_POST['email'],
      'key' => $key
    ));

    // SEND THE MAIL ! (+ Vérifier mail efrei)

    $date = date('Y-m-d H:i:s');
    $to = $_POST['email'];
    $subject = 'Vérification automatique Efrei Dynamo';
    $message = '
        <html>
         <body>
          <h1>Vérification automatique d\'appartenance à l\'Efrei.</h1>
          <p>Bonjour ' . $_SESSION['pseudo'] . ', et bienvenue sur Efrei Dynamo. Pour confirmer votre inscription, vous devez prouver votre appartenance à l\'Efrei. Grâce à votre adresse email Efrei, vous êtes éligible à notre solution de validation automatique. Cliquez simplement sur le lien ci-dessous pour terminer l\'activation de votre compte.
          <p>Adresse email utilisée</p>
          <h4>' . $_POST['email'] . '</h4>
          <p>Certification demandée le</p>
          <h4>' . $date . '</h4>
          <br><br>
          <a href="https://www.efrei-dynamo.fr/validation.php?key=' . $key . '">Cliquez ici pour activer automatiquement votre compte</a>.
          <br>
          <p>En cas de problème, votre code de validation est</p>
          <h4>' . $key . '</h4>
          <br>
          <p>À très vite !</p><br>
          <p>- L\'équipe Efrei Dynamo.</p><br><br>
          <p>P.S.: Ce courriel est automatique, veuillez ne pas y répondre.</p>
       </body>
      </html>
      ';


    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    // En-têtes additionnels
    $headers[] = 'To: ' . $_SESSION['pseudo'] . '<'. $_POST['email'] .'>';
    $headers[] = 'From: Système de validation Efrei Dynamo <noreply@efrei-dynamo.fr>';

    // Envoi
    mail($to, $subject, $message, implode("\r\n", $headers));

  } else {
    header( "refresh:0;url=validation.php?invalidmail=true" );
  }

} else {
  $vkey = $bdd->prepare('SELECT * FROM validations WHERE key = ?;');
  $vkey->execute(array($_GET['key']));
  $key = $vkey->fetch();

  if ($key && (str_contains($key['email'], "@efrei.net") OR str_contains($key['email'], "@efrei.fr"))) {
    $validation = $bdd->prepare('UPDATE utilisateurs SET validation = 1 WHERE id = ?;');
    $validation->execute(array($_SESSION['id']));

    $deletekey = $bdd->prepare('DELETE FROM validations WHERE key = ?');
    $deletekey->execute(array($key));
  } else {
    header( "refresh:0;url=validation.php?invalidkey=true" );
  }

}

}
else {
  header( "refresh:0;url=login.php?expired=true" );
}

?>
