<?php
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

header( "refresh:5;url=index.php" );
echo 'Déconnexion effective! Au revoir et à bientôt.';

?>
