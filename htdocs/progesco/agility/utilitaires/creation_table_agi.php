<?php
$query = "DROP TABLE $table";
@mysql_query($query);
// Table à créer
$fichier = "utilitaires/".$table."_creation.sql";
// Création table
$query = file_get_contents($fichier);
if (!mysql_query($query)){
	echo "<p class='center'><span class='alert'>&nbsp;La table $table n'a pas été créée</span><br />".mysql_error()."</p>";
	$flag_OK = "N";
}
?>
