<?php
$fichier = "../communs/connexion.php";
if (!file_exists($fichier)){$fichier = "../".$fichier;}
include($fichier);
$query = "SELECT * FROM cneac_variables WHERE Activite='agi'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$variable = $row['Variable'];
	$_SESSION[$variable] = stripslashes($row['Valeur']);
}
?>