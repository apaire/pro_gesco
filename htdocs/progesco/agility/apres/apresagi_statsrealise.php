<?php
// connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
$query = "SELECT * FROM agility_epreuves WHERE Engages>'0'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$idepreuve = $row['Id'];
	$query = "SELECT Id FROM agility_resultats WHERE IdEpreuve='$idepreuve' AND Resultat<>'' AND Resultat<>'F'";
	$result1 = mysql_query($query);
	$concourrus = mysql_num_rows($result1);
	$query = "UPDATE agility_epreuves SET Concourrus='$concourrus' WHERE Id='$idepreuve'";
	mysql_query($query);
}
?>
