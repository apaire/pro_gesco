<?php
$fichier = "../communs/connexion.php";
if (!file_exists($fichier)){$fichier = "../".$fichier;}
include($fichier);
$variables = array("TypeConcours", "Jour", "Mois", "Annee", "Concurrents", "Dossards", "OrdresPassage");

foreach($variables as $variable){
	$valeur = mysql_real_escape_string($_SESSION[$variable]);
	$query = "SELECT Id FROM cneac_variables WHERE Activite='agi' AND Variable='$variable'";
	if (mysql_num_rows(mysql_query($query)) > 0){
		$query = "UPDATE cneac_variables SET Valeur='$valeur' WHERE Activite='agi' AND Variable='$variable'";
	} else {
		$query = "INSERT INTO cneac_variables SET Activite='agi', Variable='$variable', Valeur='$valeur'";
	}
	mysql_query($query);
}
?>