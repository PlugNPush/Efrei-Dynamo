<?php
require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }
if(!isset($_POST['mdp']) AND !isset($_POST['vmdp'])){
  echo '<!DOCTYPE html>
  <html>
      <head>
          <meta charset="utf-8" />
          <title>INSCRIPTION</title>
      </head>
      <body>
  inscription<br>
  <form action="register.php" method="post">
  <input type="email" name="email" placeholder="Veulliez entrez votre mail" required="yes"/><br>
  <input type="text" name="pseudo" placeholder="Entrez votre pseudo" required="yes"/><br>
  <input type="password" name="mdp" placeholer="Mot de passe" required="yes"/><br>
  <input type="password" name="vmdp" placeholer="Confirmez votre mot de passe" required="yes"/><br>
  <input type="password" name="mdp" placeholder="Mot de passe" required="yes"/><br>
  <input type="password" name="vmdp" placeholder="Confirmez votre mot de passe" required="yes"/><br>
  <select name="role" id="role">
  <option value="0">Elève</option>
  <option value="1">Modérateur</option>
  <option value="2">Professeur</option>
  </select><br>
  <select name="annee" id="annee">
  <option value="1">L1</option>
  <option value="2">L2</option>
  <option value="3">L3</option>
  <option value="4">M1</option>
  <option value="5">M2</option>
  </select><br>
  <input type="number" name="majeure" placeholer="majeure" required="yes"/><br>
  <input type="submit" value="S\'incrire maintenant">
  </form>
  </body>';
}else{
  $req=$bdd->prepare('INSERT INTO utilisateurs(pseudo, email, mdp, role, annee, majeure, inscription) VALUES(:pseudo, :email, :mdp, :role, :annee, :majeure, :inscription)');
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
    echo 'bienvenue chez le sevice dynamo.';
  }else{
    echo 'Confirmation du mot de passe invalide.';
  }
}
?>