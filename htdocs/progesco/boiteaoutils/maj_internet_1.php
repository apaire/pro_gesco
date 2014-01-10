<?php
// Connexion bdd site CNEAC
include("../communs/connexion.php");
$crlf = chr(13).chr(10);
// Lecture fichier
$fichier = "http://sportscanins.fr/progesco/telechargements/$table.csv";
$texte = file($fichier);
$nb_lignes = count($texte);
if ($nb_lignes == 0){ // Fichier absent
	$msg .= "<p class='center'>La mise à jour de la table $table n'est pas disponible actuellement</p>";
} else {
	// Effacement de la table précédente
	$query = "DROP TABLE IF EXISTS `$table`";
	mysql_query($query);
	// Creation de la table
	$lignes = explode(";", $texte[0]);
	$nb_champs = $lignes[0];
	$query = "CREATE TABLE `$table` (".$crlf."  `Id` int(11) NOT NULL AUTO_INCREMENT,".$crlf;
	for ($n = 2; $n <= $nb_champs; $n++){
		$lignes = explode(";", $texte[$n]);
		$nomchamps[$n] = $lignes[0];
		$query .= "  `".$lignes[0]."` ".$lignes[1]." COLLATE utf8_unicode_ci NOT NULL,".$crlf;
	}
	$query .= "UNIQUE KEY Id (`Id`)".$crlf.") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
	mysql_query($query);

	// Enregistrement des lignes
	$nomchamps[1] = "Id";
	for ($n = $nb_champs + 1; $n < $nb_lignes; $n++){
		$query = "INSERT INTO $table SET ";
		$champs = explode(";", $texte[$n]);
		for ($c = 0; $c < $nb_champs; $c++){
			$champ = mysql_real_escape_string($champs[$c]);
			$query .= $nomchamps[$c + 1]."='".$champ."', ";
		}
		$query = substr($query, 0, strlen($query) - 2);
		mysql_query($query);
	}
	mysql_query($query);
	$msg .= "<p class='center'>La table $table a été mise à jour</p>";
}
?>