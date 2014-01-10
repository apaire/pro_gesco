<?php
session_start();
$nb_lignes = count($fichier);
for ($n = 0; $n <= $nb_lignes; $n++){
	$lignes = explode(";", $fichier[$n]);
	if ($lignes[0]{0} == "["){
		if ($lignes[0] == "[Infos_juge]"){break;}
		$table = substr($lignes[0], 1, strlen($lignes[0]) - 2);
		mysql_query("TRUNCATE $table"); // Effacement contenu précédent
		$n++;
		$lignes = explode(";", $fichier[$n]);
		$nb_champs = $lignes[0];
		// Récupération des noms des champs
		for ($champ = 0; $champ < $nb_champs; $champ++){
			$n++;
			$lignes = explode(";", $fichier[$n]);
			$nomchamps[$champ] = $lignes[0];
		}
	} else {
		$query = "INSERT INTO $table SET ";
		// Lectures des lignes de données
		for ($champ = 0; $champ < $nb_champs; $champ++){ // Lecture d'un enregistrement
			$valeur = mysql_real_escape_string($lignes[$champ]);
			$query .= "$nomchamps[$champ]='$valeur', ";
			echo mysql_error();
		}
		$query = substr($query, 0, strlen($query) - 2);
		mysql_query($query);
	}
}
?>
