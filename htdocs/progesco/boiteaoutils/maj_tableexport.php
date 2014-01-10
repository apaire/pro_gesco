<?php
session_start();
$titre = "<span class='lien'><a href='boiteaoutils.php'>Boite à Outils</a></span> &gt; Exportation d'une table";
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
// Traitement
$crlf = chr(13).chr(10);
$type = $_GET['table'];
$table = "cneac_".$type;
$texte = "";
echo "<h3 class='center'>Exportation de la table des $type</h3>";
$query = "SHOW COLUMNS FROM $table";
$result = mysql_query($query);
$nbchamps = mysql_num_rows($result);
while ($row = mysql_fetch_row($result)){
	$nomchamps[] = $row[0];
	$texte .= $row[0].";";
}
$texte .= $crlf;
$query = "SELECT * FROM $table ORDER BY Id";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	for ($n = 0; $n < $nbchamps; $n++){
		$numchamp = $nomchamps[$n];
		$champ = $row[$numchamp];
		$texte .= $champ.";";
	}
	$texte .= $crlf;
}
include("../communs/lect_variables_genes.php");
$codeclub = $_SESSION['CodeClub'];
$nomfichier = "xampplite/CNEAC/".$codeclub."_".$type.".cneac";
$fichier = "../../../CNEAC/".$codeclub."_".$type.".cneac";
$fp = fopen($fichier, "w");
fputs($fp, $texte);
fclose($fp);
echo "<p class='center'>La table des $type a été exportée dans le fichier '$nomfichier'</p>";
?>

<table align="center"><tr><th><div class="bouton"><a href="boiteaoutils.php">RETOUR</a></div></th></tr></table>

</body>
</html>