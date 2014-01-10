<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_cumulsimp.php'>Impression des résultats des cumuls</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body onload="parent.Bandeau.location.href='pendant_cumulsregles_bandeau.php'">
<h3 class="center">Impression des résultats d'une règle de cumul d'épreuves</h3>
<h4 class="center">Cliquez sur le nom de la règle à éditer</h4>
<?php
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
// Connexion bdd
include("../../communs/connexion.php");
// Choix Cumuls
$query = "SELECT * FROM agility_reglescumuls ORDER BY NomCumul";
$result = mysql_query($query);
if (mysql_num_rows($result) == 0){
	echo "<p class='center'><span class='alert'>&nbsp;Vous n'avez défini aucun cumul&nbsp;</span></p>
	<table align='center'><tr><th><div class='bouton'><a href='pendantagi_cumulsregles.php'>RETOUR</a></div></th></tr></table>";
	mysql_close();
	exit;
}
echo "<table class='general' align='center'>";
while ($row = mysql_fetch_assoc($result)){
	$id = $row['Id'];
	$nomcumul = $row['NomCumul'];
	echo "<tr><th><div class='boutonimp'><a href='pendantagi_cumulsimp_1.php?idcumul=$id' target='_blank'>$nomcumul</a></div></th></tr>";
}
?>
	<tr><th align="center"><div class="bouton"><a href="pendantagi.php">RETOUR</a></div></th></tr>
</table>
</body>
</html>