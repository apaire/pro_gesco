<?php
session_start();
$titre = "<span class='lien'><a href='boiteaoutils.php'>Boite à Outils</a></span> &gt; Importation d'une table";
include("bandeau_bao.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<body>
<?php
// Connexion bdd
include("../communs/connexion_cneac.php");
// Traitement
if (isset($_GET['table'])){
	$type = $_GET['table'];
	$_SESSION['type'] = $type;
} else {$type = $_SESSION['type'];}
echo "<h3 class='center'>Importation de la table des $type</h3>";
if (isset($_GET['import'])){
	$table = "cneac_".$type;
	$query = "SHOW COLUMNS FROM $table";
	$result = mysql_query($query);
	$nbchamps = mysql_num_rows($result);
	while ($row = mysql_fetch_row($result)){
		$nomchamps[] = $row[0];
	}
	$nomfichier = "c:/".$_GET['import'];
	$fichier = file($nomfichier);
	$nblignes = count($fichier);
	$n = 0;
	$table = "cneac_".$type;
	$query = "INSERT INTO $table (";
	for ($n = 1; $n < $nbchamps; $n++){
		$query .= $nomchamps[$n].", ";
	}
	$query = substr($query, 0, strlen($query) - 2).") VALUES ";
	for ($n = 0; $n < $nblignes; $n++){
		$ligne = explode(";", $fichier[$n]);
		$query .= "(";
		for ($p = 1; $p < $nbchamps; $p++){
			$query .= "'".mysql_real_escape_string($ligne[$p])."', ";
		}
		$query = substr($query, 0, strlen($query) - 2)."), ";
	}
	$query = substr($query, 0, strlen($query) - 2).";";
	if (!mysql_query($query)){echo mysql_error();}
	echo "<p class='center'><span class='alert'>&nbsp;La table des $type a été importée&nbsp;</span></p>
	<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR</a></div></th></tr></table>";
	// Suppression doublons
	if ($type == "juges"){
		$query = "SELECT * FROM $table ORDER BY Nom, Prenom";
		if (!$result = mysql_query($query)){echo mysql_error();}
		$nom_preced = "";
		$prenom_preced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$nom = $row['Nom'];
			$prenom = $row['Prenom'];
			if ($nom == $nom_preced and $prenom == $prenom_preced){ // Doublon
				$query = "DELETE FROM $table WHERE Id='$id'";
				mysql_query($query);
			} else {
				$nom_preced = $nom;
				$prenom_preced = $prenom;
			}
		}
	}
	if ($type == "clubs"){
		$query = "SELECT * FROM $table ORDER BY CodeClub";
		if (!$result = mysql_query($query)){echo mysql_error();}
		$codeclub_preced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$codeclub = $row['CodeClub'];
			if ($codeclub == $codeclub_preced){ // Doublon
				$query = "DELETE FROM $table WHERE Id='$id'";
				mysql_query($query);
			} else {
				$codeclub_preced = $codeclub;
			}
		}
	}
	if ($type == "licences"){
		$query = "SELECT * FROM $table ORDER BY Licence, Nom, Prenom";
		$result = mysql_query($query);
		$licence_preced = "";
		$nom_preced = "";
		$prenom_preced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$licence = $row['Licence'];
			$nom = $row['Nom'];
			$prenom = $row['Prenom'];
			if ($licence == $licence_preced and $nom == $nom_preced and $prenom == $prenom_preced){ // Doublon
				$query = "DELETE FROM $table WHERE Id='$id'";
				mysql_query($query);
			} else {
				$licence_preced = $licence;
				$nom_preced = $nom;
				$prenom_preced = $prenom;
			}
		}
	}
	if ($type == "races"){
		$query = "SELECT * FROM $table ORDER BY CodeRace, Race, RaceVariete";
		if (!$result = mysql_query($query)){echo mysql_error();}
		$coderace_preced = "";
		$race_preced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$coderace = $row['CodeRace'];
			$race = $row['Race'];
			$racevariete = $row['RaceVariete'];
			if ($coderace == $coderace_preced and $race == $race_preced){ // Doublon
				$query = "DELETE FROM $table WHERE Id='$id'";
				mysql_query($query);
			} else {
				$coderace_preced = $coderace;
				$race_preced = $race;
			}
		}
	}
	mysql_close();
	exit;
}
?>
<p class='center'>Cliquer sur le code club du fichier à importer</p>
<table class='fond' align='center' border='1' rules='groups'>
	<colgroup><col /><col /></colgroup>
	<thead><tr><td>Code Club</td><td>Club</td></thead>
	<tbody>";
<?php
$dir = dir("c:");
while (($fichier = $dir->read()) !== false){
	if (substr($fichier, 4, strlen($fichier) - 4) == $type.".cneac"){
		$codeclub = substr($fichier, 0, 3);
		$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$club = $row['Club'];
		echo "<tr><td><a href='maj_tableimport.php?import=$fichier'>$codeclub</a></td><td>$club</td></tr>";
	}
}
?>
<table align="center"><tr><th><div class="bouton"><a href="boiteaoutils.php">RETOUR</a></div></th></tr></table>
</body>
</html>