<?php

require_once dirname(__FILE__).'/../../config/config.php';
  try {
    $bdd = new PDO('mysql:host='.getDBHost().';dbname=efreidynamo', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
  } catch(Exception $e) {
    exit ('Erreur while connecting to database: '.$e->getMessage());
  }

echo 'inscription<br>
<form action="register.php" method="post">
<input type="email" name="email" placeholder="Veulliez entrez votre mail" required="yes"/><br>
<input type="text" name="pseudo" placeholder="Entrez votre pseudo" required="yes"/><br>
<input type="password" name="mdp" placeholer="Mot de passe" required="yes"/><br>
<input type="password" name="vmdp" placeholer="Confirmez votre mot de passe" required="yes"/><br>
<input type="number" name="role" placeholer="rôle" required="yes"/><br>
<select name="role" id="role">
<option value="0">Elève</option>
<option value="1">Modérateur</option>
<option value="2">Professeur</option>
</select><br>
<input type="number" name="annee" placeholer="année" required="yes"/><br>
<input type="number" name="majeure" placeholer="majeure" required="yes"/><br>
<input type="submit" value="S\'incrire maintenant">
</form>'

?>
