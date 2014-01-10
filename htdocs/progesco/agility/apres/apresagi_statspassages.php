<?php
include("apresagi_statsrealise.php");
// Cumuls C C2 Nb épreuves
$nb_passages = 0;
for ($c = 1; $c <= 3; $c++){
	$query = "SELECT Id FROM agility_epreuves WHERE Classe='$c' AND Concourrus>'0'";
	$result = mysql_query($query);
	$nb_epreuves[$c] = mysql_num_rows($result);
}
// Nb de passages
$query = "SELECT Id FROM agility_resultats WHERE Resultat<>'F' AND Resultat<>''";
$result = mysql_query($query);
$nb_passages = mysql_num_rows($result);

// Cumuls C C2 Nb brevets
for ($b = 1; $b <= 3; $b++){
	$query = "SELECT Id FROM agility_resultats WHERE Epreuve='1' AND Brevet='$b'";
	$result = mysql_query($query);
	$nb_brevets[$b] = mysql_num_rows($result);
}
?>