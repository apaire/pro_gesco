<?php
// Table à créer
$fichier = "communs/".$table."_creation.sql"; // Nom du fichier contenant la structure de la table
if (!file_exists($fichier)){$fichier = "../".$fichier;} // Suivant appel de la page
$query = "DROP TABLE IF EXISTS $table"; // Supprime la table si elle est déjà présente
mysql_query($query);
// Création table
$query = file_get_contents($fichier); // Chargement du contenu du fichier
if (!mysql_query($query)){
	echo "<p class='center'><span class='alert'>&nbsp;La table $table n'a pas été créée</span><br />".mysql_error()."</p>";
	$flag_OK = "N";
}
?>
