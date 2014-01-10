<?php
include("connexion.php");
$variables = array("Version", "SousVersion", "CodeClub", "Club", "NomComplet", "Regionale", "President");

foreach($variables as $variable){
	$valeur = mysql_real_escape_string($_SESSION[$variable]);
	$query = "SELECT Id FROM cneac_variables WHERE Activite='com' AND Variable='$variable'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0){
		$row = mysql_fetch_assoc($result);
		$id = $row['Id'];
		$query = "UPDATE cneac_variables SET Valeur='$valeur' WHERE Id='$id'";
	} else {
		$query = "INSERT INTO cneac_variables SET Activite='com', Variable='$variable', Valeur='$valeur'";
	}
	mysql_query($query);
}
?>