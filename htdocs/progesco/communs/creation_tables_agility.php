<?php
// Création des tables spécifiques Agility
$flag_OK = "Y";

$table = "agility_epreuves";
include("communs/creation_table.php");

$table = "agility_resultats";
include("communs/creation_table.php");

$table = "agility_penalants";
include("communs/creation_table.php");

$table = "agility_reglescumuls";
include("communs/creation_table.php");

$table = "agility_resultatscumuls";
include("communs/creation_table.php");

if ($flag_OK == "Y"){echo "<p class='center'>Toutes les tables pour l'Agility ont été créées</p>";}
else {echo "<p class='center'>Un incident est survenu lors de la création des tables pour l'Agility.<br />Nous sommes désolés pour ce contre-temps.<br />Veuillez noter le message d'erreur qui s'est affiché et contacter le support du programme.</p>";}
?>