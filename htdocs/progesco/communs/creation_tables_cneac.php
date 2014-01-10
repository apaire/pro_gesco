<?php
// Création des tables générales
$flag_OK = "Y";
$table = "cneac_clubs";
include("communs/creation_table.php");

$table = "cneac_juges";
include("communs/creation_table.php");

$table = "cneac_licences";
include("communs/creation_table.php");

$table = "cneac_races";
include("communs/creation_table.php");

$table = "cneac_regionales";
include("communs/creation_table.php");

$table = "cneac_variables";
include("communs/creation_table.php");
$query = "UPDATE cneac_variables SET Activite='com', Variable='Version', Valeur='".$_SESSION['Version']."'";
mysql_query($query);

if ($flag_OK == "Y"){
	echo "<p class='center'>Toutes les tables générales ont été créées</p>
	<p class='center'>Pour les remplir, vous devez lancer l'option 'INITIALISATION DU CONCOURS / MISE A JOUR DES TABLES SUR INTERNET'</p>";
} else {echo "<p class='center'>Un incident est survenu lors de la création des tables générales.<br />Nous sommes désolés pour ce contre-temps.<br />Veuillez noter le message d'erreur qui s'est affiché et contacter le support du programme.</p>";}
?>