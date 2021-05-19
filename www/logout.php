<?php
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

header( "refresh:0;url=index.php" );
echo 'Déconnexion effective! Au revoir et à bientôt.';

?>
