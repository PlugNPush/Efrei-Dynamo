<?php
require_once dirname(__FILE__).'/../../config/config.php';
require_once dirname(__FILE__).'/../../config/efreidynconfig.php';

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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
  $_SESSION['ban'] = $test['ban'];
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
  } else if (empty($_POST['email']) && empty($_GET['token']) && !isset($_GET['resend']) && !isset($_GET['cancel'])){
    echo '<!DOCTYPE html>
    <html lang="fr">

    <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <meta http-equiv="Content-Security-Policy" content="default-src \'self\'; img-src https://* \'self\' data:; child-src \'none\';">

      <title>Efrei Dynamo</title>

      <link href="css/custom.css" rel="stylesheet">

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
            <span id="new-dark-navbar-toggler-icon" class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">R??pondre ?? des questions</a>
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
                  <a class="nav-link" href="logout.php">Se d??connecter</a>
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

            if (isset($_GET['invalidtoken'])) {
              echo '<div class="alert alert-danger fade show" role="alert">
                <strong>Erreur lors de la validation !</strong><br> Il semblerait que la cl?? d\'authentification unique envoy??e sur votre adresse email soit erron??e. Veuillez r??essayer.
              </div>';
            }

            if (isset($_GET['serror'])) {
              echo '<div class="alert alert-danger fade show" role="alert">
                <strong>Erreur lors de la validation !</strong><br> Le courrier ??l??ctronique contenant votre code de validation n\'a pas pu s\'envoyer. Veuillez contacter un mod??rateur.
              </div>';
            }

            if (isset($_GET['ierror'])) {
              echo '
              <div class="alert alert-danger fade show" role="alert">
                <strong>Une erreur interne inattendue s\'est produite</strong>. Un param??tre attendu n\'est pas parvenu ?? sa destination. Veuillez r??esayer puis contacter un mod??rateur si l\'erreur se reproduit.
              </div>';
            }

            if (isset($_GET['pending'])) {
              echo '<div class="alert alert-success fade show" role="alert">
                <strong>Validation en attente.</strong><br> Votre code d\'authentification vous a ??t?? envoy?? sur votre adresse mail. Le mail de validation se trouve dans votre dossier de spams, aussi appel?? courrier ind??sirable.
              </div>';
            }

            if (isset($_GET['resent'])) {
              echo '<div class="alert alert-success fade show" role="alert">
                <strong>Email renvoy?? !</strong><br> Votre code d\'authentification vous a ??t?? envoy?? une nouvelle fois sur votre adresse mail. Le mail de validation se trouve dans votre dossier de spams, aussi appel?? courrier ind??sirable.
              </div>';
            }

            if (isset($_GET['emailexists'])) {
              echo '
              <div class="alert alert-danger fade show" role="alert">
                <strong>Echec de la validation du mail.</strong> Un compte a d??j?? ??t?? v??rifi?? avec cette adresse mail.
              </div>';
            }

            if (isset($_SESSION['validation']) && $_SESSION['validation'] == 1 && $data) {
              echo '<div class="alert alert-success fade show" role="alert">
                <strong>F??licitations, votre compte Efrei est valid?? !</strong><br>Vous n\'avez rien ?? faire, nous avons v??rifi?? votre appartenance ?? l\'Efrei avec une signature num??rique le ', $data['date'], ' via l\'adresse email Efrei suivante : <a href="mailto:', $data['email'] ,'">', $data['email'] ,'</a>.
              </div>
              <a href="index.php" class="btn btn-success btn-lg btn-block">Acc??der ?? Efrei Dynamo</a><br><br>';
            } else if (isset($_SESSION['validation']) && $_SESSION['validation'] == 1) {
              echo '<div class="alert alert-success fade show" role="alert">
                <strong>Votre compte Efrei est valid?? manuellement !</strong><br>Vous n\'avez rien ?? faire, nous avons v??rifi?? votre appartenance ?? l\'Efrei via un de nos mod??rateurs.
              </div>
              <a href="index.php" class="btn btn-success btn-lg btn-block">Acc??der ?? Efrei Dynamo</a><br><br>';
            } else if ($data) {
              echo '<div class="alert alert-info fade show" role="alert">
                <strong>Un processus de v??rification est en cours...</strong><br> Votre code d\'authentification vous a ??t?? envoy?? sur votre adresse mail. Le mail de validation se trouve dans votre dossier de spams, aussi appel?? courrier ind??sirable. En cas de probl??me, contactez un mod??rateur.
              </div>
              <form action="validation.php" method="get">
                <div class="form-group">
                  <label for="token">Saisissez le code ?? usage unique</label>
                  <input type="text" name="token" class="form-control" id="token" placeholder="Saisissez le code re??u sur votre adresse mail" required>
                  <small id="emailHelp" class="form-text text-muted">
                    Vous pouvez ??galement cliquer sur le lien envoy?? dans le mail que vous avez re??u. En cas de probl??me, contactez un mod??rateur.
                  </small>
                </div>
                <button type="submit" class="btn btn-primary">V??rifier l\'authenticit?? du compte</button>
                <a href="validation.php?resend=true" class="btn btn-secondary">Renvoyer le code</a>
                <a href="validation.php?cancel=true" class="btn btn-danger">Annuler la validation</a>
                </form><br><br>';
            } else {

              if ($_SESSION['role'] == 0 || $_SESSION['role'] == 2) {
                echo '<div class="alert alert-warning fade show" role="alert">
                  <strong>Bonjour ', $_SESSION['pseudo'], ' !</strong><br> Vous devez confirmer votre statut d\'Efreien pour acc??der au site.<br>Veuillez suivre les instructions ci-dessous pour proc??der ?? la validation.<br>
                </div>';

                if ($_SESSION['role'] == 2) {
                  echo '<div class="alert alert-warning fade show" role="alert">
                    <strong>Pas d\'adresse email en @efrei.fr ou @intervenants.efrei.net ?</strong> Contactez un mod??rateur pour manuellement valider votre compte, ou r??trogradez vers un profil ??tudiant pour valider votre compte imm??diatement.
                  </div>
                  <a href="validation.php?downgrade=true" class="btn btn-warning btn-lg btn-block">R??trograder vers un profil ??tudiant</a><br>';
                }

                echo '
                <form action="validation.php" method="post">
                  <div class="form-group">
                    <label for="email">Confirmez votre adresse mail Efrei</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="', $_SESSION['email'] ,'" value="', $_SESSION['email'] ,'" required>
                    <small id="emailHelp" class="form-text text-muted">
                      Vous devez utiliser une adresse en ', ($_SESSION['role'] == 0) ? ("@efrei.net") : ("@efrei.fr ou @intervenants.efrei.net") ,'
                    </small>
                  </div>
                  <button type="submit" class="btn btn-primary">D??marrer le processus de v??rification</button>
                  </form><br><br>';

              } else if ($_SESSION['role'] == 1) {
                echo '<div class="alert alert-danger fade show" role="alert">
                  <strong>Tu n\'es pas ??ligible ?? la v??rification automatique</strong>.<br> Tu as demand?? ?? ??tre mod??rateur, et pour cela nous devons v??rifier manuellement ton statut. Contacte un autre mod??rateur, ou r??trograde ton profil vers un profil ??tudiant pour valider ton compte imm??diatement.
                </div>
                <a href="validation.php?downgrade=true" class="btn btn-warning btn-lg btn-block">R??trograder vers un profil ??tudiant</a><br><br>';
              } else {
                echo '<div class="alert alert-danger fade show" role="alert">
                  <strong>Tu n\'es pas ??ligible ?? la v??rification automatique</strong>.<br> Tu es un super-mod??rateur, il semblerait que nous ayons oubli?? de v??rifier manuellement ton statut. Utilise ton pouvoir de super-mod??rateur pour t\'auto-certifier.
                </div>
                <a href="account.php" class="btn btn-primary btn-lg btn-block">Modifier les r??glages du compte</a><br><br>';
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
          <p class="m-0 text-center text-white">&copy; 2021 Efrei Dynamo. Tous droits reserv??s. <a href="/legal.php">Mentions l??gales</a>.</p>
        </div>
        <!-- /.container -->
      </footer>

      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>
';
} else if (isset($_GET['resend'])){

  $gatherdata = $bdd->prepare('SELECT * FROM validations WHERE user = ?;');
  $gatherdata->execute(array($_SESSION['id']));
  $data = $gatherdata->fetch();

  if ($data) {
    $to = $data['email']; //$data['email']
    $subject = 'Verification automatique Efrei Dynamo';
    $message = '
        <html>
         <body>
          <h1>V??rification automatique d\'appartenance ?? l\'Efrei.</h1>
          <p>Bonjour ' . $_SESSION['pseudo'] . ', et bienvenue sur Efrei Dynamo. Pour confirmer votre inscription, vous devez prouver votre appartenance ?? l\'Efrei. Gr??ce ?? votre adresse email Efrei, vous ??tes ??ligible ?? notre solution de validation automatique. Cliquez simplement sur le lien ci-dessous pour terminer l\'activation de votre compte.
          <p>Adresse email utilis??e</p>
          <h4>' . $data['email'] . '</h4>
          <p>Certification demand??e le</p>
          <h4>' . $data['date'] . '</h4>
          <br><br>
          <a href="https://www.efrei-dynamo.fr/validation.php?token=' . $data['token'] . '">Cliquez ici pour activer automatiquement votre compte</a>.
          <br>
          <p>En cas de probl??me avec le lien ci-dessus, vous pouvez aussi copier votre code d\'authentification ?? usage unique :</p>
          <h4>' . $data['token'] . '</h4>
          <br>
          <p>?? tr??s vite !</p>
          <p>- L\'??quipe Efrei Dynamo.</p><br><br>
          <p>P.S.: Ce courriel est automatique, veuillez ne pas y r??pondre.</p>
       </body>
      </html>
      ';

      // Pour envoyer un mail HTML, l'en-t??te Content-type doit ??tre d??fini
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';

      // En-t??tes additionnels
      $headers[] = 'To: <' . $data['email'] . '>';
      $headers[] = 'From: Validation Efrei Dynamo <noreply@efrei-dynamo.fr>';

      $mail = new PHPmailer();
      $mail->IsSMTP();
      $mail->IsHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Host = 'smtp.free.fr';
      $mail->Port = 465;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Username = 'craftsearch';
      $mail->Password = getSMTPPassword();
      $mail->SMTPOptions = array(
          'ssl' => array(
             'verify_peer' => false,
             'verify_peer_name' => false,
             'allow_self_signed' => true
          )
      );
      $mail->From = 'no-reply@efrei-dynamo.fr';
      $mail->FromName = 'Validation Efrei Dynamo';
      $mail->AddAddress($to);
      $mail->Subject = $subject;
      $mail->Body = $message;

      // Send the mail
      $sent = $mail->send();

      // Envoi
      //$sent = mail($to, $subject, $message, implode("\r\n", $headers));

      if ($sent) {
        header( "refresh:0;url=validation.php?resent=true" );
      } else {
        header( "refresh:0;url=validation.php?serror=true" );
      }

  } else {
    header( "refresh:0;url=validation.php?ierror=true" );
  }

} else if (isset($_GET['cancel'])){

  $deletetoken = $bdd->prepare('DELETE FROM validations WHERE user = ?');
  $deletetoken->execute(array($_SESSION['id']));

  header( "refresh:0;url=validation.php" );

} else if (!isset($_GET['token'])){

  if ((strpos($_POST['email'], "@efrei.net") !== false AND $_SESSION['role'] == 0) OR ((strpos($_POST['email'], "@efrei.fr") !== false OR strpos($_POST['email'], "@intervenants.efrei.net") !== false) AND $_SESSION['role'] == 2)) {

    $mail_fetch = $bdd->prepare('SELECT * FROM validations WHERE email = ?;');
    $mail_fetch->execute(array($_POST['email']));
    $mail = $mail_fetch->fetch();

    if ($mail) {
      header( "refresh:0;url=validation.php?emailexists=true" );
    } else {
      $token = generateRandomString(32);
      $date = date('Y-m-d H:i:s');

      $newtoken = $bdd->prepare('INSERT INTO validations(user, email, token, date) VALUES(:user, :email, :token, :date);');
      $newtoken->execute(array(
        'user' => $_SESSION['id'],
        'email' => $_POST['email'],
        'token' => $token,
        'date' => $date
      ));


      $to = $_POST['email']; // $_POST['email']
      $subject = 'Verification automatique Efrei Dynamo';
      $message = '
          <html>
           <body>
            <h1>V??rification automatique d\'appartenance ?? l\'Efrei.</h1>
            <p>Bonjour ' . $_SESSION['pseudo'] . ', et bienvenue sur Efrei Dynamo. Pour confirmer votre inscription, vous devez prouver votre appartenance ?? l\'Efrei. Gr??ce ?? votre adresse email Efrei, vous ??tes ??ligible ?? notre solution de validation automatique. Cliquez simplement sur le lien ci-dessous pour terminer l\'activation de votre compte.
            <p>Adresse email utilis??e</p>
            <h4>' . $_POST['email'] . '</h4>
            <p>Certification demand??e le</p>
            <h4>' . $date . '</h4>
            <br>
            <h3><a href="https://www.efrei-dynamo.fr/validation.php?token=' . $token . '">Cliquez ici pour activer automatiquement votre compte</a>.</h3>
            <br>
            <p>En cas de probl??me avec le lien ci-dessus, vous pouvez aussi copier votre code d\'authentification ?? usage unique :</p>
            <h4>' . $token . '</h4>
            <br>
            <p>?? tr??s vite !</p>
            <p>- L\'??quipe Efrei Dynamo.</p><br><br>
            <p>P.S.: Ce courriel est automatique, veuillez ne pas y r??pondre.</p>
         </body>
        </html>
        ';


      // Pour envoyer un mail HTML, l'en-t??te Content-type doit ??tre d??fini
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';

      // En-t??tes additionnels
      $headers[] = 'To: <' . $_POST['email'] . '>';
      $headers[] = 'From: Validation Efrei Dynamo <noreply@efrei-dynamo.fr>';

      $mail = new PHPmailer();
      $mail->IsSMTP();
      $mail->IsHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Host = 'smtp.free.fr';
      $mail->Port = 465;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Username = 'craftsearch';
      $mail->Password = getSMTPPassword();
      $mail->SMTPOptions = array(
          'ssl' => array(
             'verify_peer' => false,
             'verify_peer_name' => false,
             'allow_self_signed' => true
          )
      );
      $mail->From = 'no-reply@efrei-dynamo.fr';
      $mail->FromName = 'Validation Efrei Dynamo';
      $mail->AddAddress($to);
      $mail->Subject = $subject;
      $mail->Body = $message;

      // Send the mail
      $sent = $mail->send();
      // Envoi
      //$sent = mail($to, $subject, $message, implode("\r\n", $headers));

      if ($sent) {
        header( "refresh:0;url=validation.php?pending=true" );
      } else {
        header( "refresh:0;url=validation.php?serror=true" );
      }
    }

  } else {
    header( "refresh:0;url=validation.php?invalidmail=true" );
  }

} else {
  $vtoken = $bdd->prepare('SELECT * FROM validations WHERE token = ?;');
  $vtoken->execute(array($_GET['token']));
  $token = $vtoken->fetch();

  if ($token && ((strpos($token['email'], "@efrei.net") !== false AND $_SESSION['role'] == 0) OR ((strpos($token['email'], "@efrei.fr") !== false OR strpos($token['email'], "@intervenants.efrei.net") AND $_SESSION['role'] == 2)))) {
    $validation = $bdd->prepare('UPDATE utilisateurs SET validation = 1 WHERE id = ?;');
    $validation->execute(array($_SESSION['id']));

    header( "refresh:0;url=validation.php" );
  } else {
    header( "refresh:0;url=validation.php?invalidtoken=true" );
  }

}

}
else {
  header( "refresh:0;url=login.php?expired=true" );
}

?>
