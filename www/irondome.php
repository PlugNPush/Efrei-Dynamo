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
  $_SESSION['ban'] = $test['ban'];
}

if (isset($_SESSION['id'])){

    // Back-end only
    // Handle moderation and report here, then redirect to source

    if (isset($_GET['type']) && isset($_GET['id']) && isset($_GET['action'])) {
      $interval = new DateInterval('P1M');
      $date = date('Y-m-d H:i:s');
      $bandate = date('Y-m-d H:i:s');
      $bandate->add($interval)
      if ($_GET['type'] == 'q') {
        if ($_GET['action'] == 'ban' && $_SESSION['role'] >= 1) {
          $ban = $bdd->prepare('UPDATE questions SET ban = ? WHERE id = ?;');
          $ban->execute(array($bandate, $_GET['id']));

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, publication, action) VALUES(:type, :expiration, :utilisateur, :delateur, :publication, :action);');
          $banhistory->execute(array(
            'type' => 'q',
            'expiration' => $bandate,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'action' => 1
          ));

          $gatherdata = $bdd->prepare('SELECT * FROM questions WHERE id = ?;');
          $gatherdata->execute(array($_GET['id']));
          $data = $gatherdata->fetch();

          $karma = $bdd->prepare('UPDATE utilisateurs SET karma = karma - 10 WHERE id = ?;');
          $karma->execute(array($data['auteur']));

        } else if ($_GET['action'] == 'unban' && $_SESSION['role'] >= 1) {
          $ban = $bdd->prepare('UPDATE questions SET ban = NULL WHERE id = ?;');
          $ban->execute(array($_GET['id']));

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, publication, action) VALUES(:type, :expiration, :utilisateur, :delateur, :publication, :action);');
          $banhistory->execute(array(
            'type' => 'q',
            'expiration' => $date,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'action' => 2
          ));

          $gatherdata = $bdd->prepare('SELECT * FROM questions WHERE id = ?;');
          $gatherdata->execute(array($_GET['id']));
          $data = $gatherdata->fetch();

          $karma = $bdd->prepare('UPDATE utilisateurs SET karma = karma + 10 WHERE id = ?;');
          $karma->execute(array($data['auteur']));
        } else if ($_GET['action'] == 'report'){

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, publication, action) VALUES(:type, :expiration, :utilisateur, :delateur, :publication, :action);');
          $banhistory->execute(array(
            'type' => 'q',
            'expiration' => $date,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'action' => 0
          ));

        } else {
          header( "refresh:0;url=index.php?dperror=true" );
        }

      } else if ($_GET['type'] == 'r') {
        if ($_GET['action'] == 'ban' && $_SESSION['role'] >= 1) {
          $ban = $bdd->prepare('UPDATE reponses SET ban = ? WHERE id = ?;');
          $ban->execute(array($bandate, $_GET['id']));

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, publication, action) VALUES(:type, :expiration, :utilisateur, :delateur, :publication, :action);');
          $banhistory->execute(array(
            'type' => 'r',
            'expiration' => $bandate,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'publication' => $_GET['id'],
            'action' => 1
          ));

          $gatherdata = $bdd->prepare('SELECT * FROM reponses WHERE id = ?;');
          $gatherdata->execute(array($_GET['id']));
          $data = $gatherdata->fetch();

          $karma = $bdd->prepare('UPDATE utilisateurs SET karma = karma - 10 WHERE id = ?;');
          $karma->execute(array($data['auteur']));

        } else if ($_GET['action'] == 'unban' && $_SESSION['role'] >= 1) {
          $ban = $bdd->prepare('UPDATE reponses SET ban = NULL WHERE id = ?;');
          $ban->execute(array($_GET['id']));

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, publication, action) VALUES(:type, :expiration, :utilisateur, :delateur, :publication, :action);');
          $banhistory->execute(array(
            'type' => 'r',
            'expiration' => $date,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'publication' => $_GET['id'],
            'action' => 2
          ));

          $gatherdata = $bdd->prepare('SELECT * FROM questions WHERE id = ?;');
          $gatherdata->execute(array($_GET['id']));
          $data = $gatherdata->fetch();

          $karma = $bdd->prepare('UPDATE utilisateurs SET karma = karma + 10 WHERE id = ?;');
          $karma->execute(array($data['auteur']));
        } else if ($_GET['action'] == 'report'){

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, publication, action) VALUES(:type, :expiration, :utilisateur, :delateur, :publication, :action);');
          $banhistory->execute(array(
            'type' => 'r',
            'expiration' => $date,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'publication' => $_GET['id'],
            'action' => 0
          ));

        } else {
          header( "refresh:0;url=index.php?dperror=true" );
        }
      } else if ($_GET['type'] == 'u') {
        if ($_GET['action'] == 'ban' && $_SESSION['role'] >= 1) {
          $ban = $bdd->prepare('UPDATE questions SET ban = ? WHERE id = ?;');
          $ban->execute(array($bandate, $_GET['id']));

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, action) VALUES(:type, :expiration, :utilisateur, :delateur, :action);');
          $banhistory->execute(array(
            'type' => 'u',
            'expiration' => $bandate,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'action' => 1
          ));

          $gatherdata = $bdd->prepare('SELECT * FROM questions WHERE id = ?;');
          $gatherdata->execute(array($_GET['id']));
          $data = $gatherdata->fetch();

          $karma = $bdd->prepare('UPDATE utilisateurs SET karma = karma - 50 WHERE id = ?;');
          $karma->execute(array($data['auteur']));

        } else if ($_GET['action'] == 'unban' && $_SESSION['role'] >= 1) {
          $ban = $bdd->prepare('UPDATE questions SET ban = NULL WHERE id = ?;');
          $ban->execute(array($_GET['id']));

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, action) VALUES(:type, :expiration, :utilisateur, :delateur, :action);');
          $banhistory->execute(array(
            'type' => 'u',
            'expiration' => $date,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'action' => 2
          ));

          $gatherdata = $bdd->prepare('SELECT * FROM questions WHERE id = ?;');
          $gatherdata->execute(array($_GET['id']));
          $data = $gatherdata->fetch();

          $karma = $bdd->prepare('UPDATE utilisateurs SET karma = karma + 50 WHERE id = ?;');
          $karma->execute(array($data['auteur']));
        } else if ($_GET['action'] == 'report'){

          $banhistory = $bdd->prepare('INSERT INTO sanctions(type, expiration, utilisateur, delateur, action) VALUES(:type, :expiration, :utilisateur, :delateur, :action);');
          $banhistory->execute(array(
            'type' => 'u',
            'expiration' => $date,
            'utilisateur' => $_GET['user'],
            'delateur' => $_SESSION['id'],
            'action' => 0
          ));

        } else {
          header( "refresh:0;url=index.php?dperror=true" );
        }
      } else {
        header( "refresh:0;url=index.php?ierror=true" );
      }
    } else {
      header( "refresh:0;url=index.php?ierror=true" );
    }


}
else {
  header( "refresh:0;url=login.php?expired=true" );
}

?>
