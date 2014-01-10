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
	// Lecture des champs
	$lignes = explode(";", $texte[0]);
	$nb_champs = $lignes[0];
	for ($n = 2; $n <= $nb_champs; $n++){
		$lignes = explode(";", $texte[$n]);
		$nomchamps[$n] = $lignes[0];
	}

	// Enregistrement des lignes
	for ($n = $nb_champs + 1; $n < $nb_lignes; $n++){
		$champs = explode(";", $texte[$n]);
		$query = "SELECT Id FROM cneac_licences WHERE Licence='$champs[1]' AND Nom='$champs[14]' AND Prenom='$champs[15]'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){ // La ligne existe déjà dans la table
			$row = mysql_fetch_assoc($result);
			$id = $row['Id'];
			$query = "UPDATE cneac_licences SET ";
			for ($c = 3; $c < 17; $c++){
				$champ = mysql_real_escape_string($champs[$c]);
				$query .= $nomchamps[$c + 1]."='".$champ."', ";
			}
			$query .= $nomchamps[23]."='".$champs[23]."' WHERE Is='$id'";
			if (!mysql_query($query))
				echo "<p class='center'><span class='alert'>&nbsp;La mise à jour de la licence n'a pas pu être réalisée&nbsp;</span><br />
				$query<br />".mysql_error()."</p>";
			}
		} else { // La ligne n'existe pas dans la table
			for ($n = $nb_champs + 1; $n < $nb_lignes; $n++){
			$query = "INSERT INTO $table SET ";
			$champs = explode(";", $texte[$n]);
			for ($c = 0; $c < $nb_champs; $c++){
				$champ = mysql_real_escape_string($champs[$c]);
				$query .= $nomchamps[$c + 1]."='".$champ."', ";
			}
			$query = substr($query, 0, strlen($query) - 2);
			if (!mysql_query($query)){
				echo "<p class='center'><span class='alert'>La licence \"".$champs[1]."\" n'a pas pu être ajoutée à la table</span><br />
				$query<br />".mysql_error()."</p>";
			}
		}
	}
	mysql_query($query);
	$msg .= "<p class='center'>La table $table a été mise à jour</p>";
}
?>