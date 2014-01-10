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
include("../communs/connexion.php");
//max_allowed_packet = 2 Mo;
// Traitement
if (isset($_GET['table'])){
	$type = $_GET['table'];
	$_SESSION['type'] = $type;
} else {$type = $_SESSION['type'];}
echo "<h3 class='center'>Importation d'une table des $type</h3>";
if (isset($_GET['import'])){
	$table = "cneac_".$type;
	$query = "SHOW COLUMNS FROM $table";
	$result = mysql_query($query);
	$nbchamps = mysql_num_rows($result);
	while ($row = mysql_fetch_row($result)){
		$nomchamps[] = $row[0];
	}
	$nomfichier = "../CNEAC/".$_GET['import'];
	$fichier = file($nomfichier);
	$nblignes = count($fichier);
	$n = 0;
	$table = "cneac_".$type;
	$query = "INSERT INTO $table (";
	for ($n = 1; $n < $nbchamps; $n++){
		$query .= $nomchamps[$n].", ";
	}
	$query = substr($query, 0, strlen($query) - 2).") VALUES ";
	for ($n = 1; $n < $nblignes; $n++){
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
		$query = "SELECT * FROM $table ORDER BY Nom, Prenom, Id DESC";
		if (!$result = mysql_query($query)){echo mysql_error();}
		$nompreced = "";
		$prenompreced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$nom = $row['Nom'];
			$prenom = $row['Prenom'];
			if ($nom == $nompreced and $prenom == $prenompreced){ // Doublon
				$query = "DELETE FROM $table WHERE Id='$id'";
				mysql_query($query);
			} else {
				$nompreced = $nom;
				$prenompreced = $prenom;
			}
		}
	}
	if ($type == "clubs"){
		$query = "SELECT * FROM $table ORDER BY CodeClub, Id DESC";
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
		$query = "SELECT * FROM $table ORDER BY Licence, Nom, Prenom, Id DESC";
		$result = mysql_query($query);
		$licencepreced = "";
		$nompreced = "";
		$prenompreced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$licence = $row['Licence'];
			$nom = $row['Nom'];
			$prenom = $row['Prenom'];
			if ($licence == $licencepreced and $nom == $nompreced and $prenom == $prenompreced){ // Doublon
				$query = "DELETE FROM $table WHERE Id='$id'";
				mysql_query($query);
			} else {
				$licencepreced = $licence;
				$nompreced = $nom;
				$prenompreced = $prenom;
			}
		}
	}
	if ($type == "races"){
		$query = "SELECT * FROM $table ORDER BY CodeRace, Race, Id DESC";
		if (!$result = mysql_query($query)){echo mysql_error();}
		$coderace_preced = "";
		$race_preced = "";
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['Id'];
			$coderace = $row['CodeRace'];
			$race = $row['Race'];
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
<p class='center'>Cliquer sur le code Club du fichier à importer</p>
<table class='fond' align='center' border='1'>
	<colgroup><col /><col /></colgroup>
	<thead><tr><td>Code Club</td><td>Club</td></thead>
	<tbody>
<?php
$dir = dir("../CNEAC/");
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