<?php
// Mise à jour nombre d'engagés par épreuve
// connexion bdd
include("../../communs/connexion.php");
// Liste des épreuves
$nb_epreuves = 0;
$epreuve_preced = "";
$categorie_preced = "";
$classe_preced = "";
$query = "SELECT * FROM agility_epreuves";
if (!($result = mysql_query($query))){echo mysql_error();}
while ($row = mysql_fetch_assoc($result)){
	$idepreuve = $row['Id'];
	$query = "SELECT Id FROM agility_resultats WHERE IdEpreuve='$idepreuve'";
	$result1 = mysql_query($query);
	$engages = mysql_num_rows($result1);
	$query = "UPDATE agility_epreuves SET Engages='$engages' WHERE Id='$idepreuve'";
	mysql_query($query);
}
?>