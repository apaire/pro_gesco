<?php
$bdd = "cneac"; // Base de données
$host = "localhost"; // Hote
$user = "root"; // Utilisateur
$pass = ""; // Mot de passe
@mysql_connect($host,$user,$pass) or die("Impossible de se connecter à la base de données");
@mysql_select_db($bdd);
?>