<?php
session_start();
$titre = "<a href='apresagi.php'>Après le concours</a> &gt; <a href='apresagi_restauration.php'>Restauration d'un concours</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../agility/apres/utilitaires/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h3 class="center">Cliquez sur le concours à restaurer</h3>
<?php
include("../utilitaires/nomvars_agi.php");
include("../../communs/connexion.php");
//Ouverture dossier
$dir = dir("../../../../CNEAC/");
?>
<table class="general" align="center">
<?php
//Liste des fichiers .cneac
while (($fichier = $dir->read()) !== false){
	if (substr($fichier, strlen($fichier) - 5) == "cneac" and substr($fichier, 0, 7) == "agility"){
		$codeclub = substr($fichier, 8, 3);
		$an = substr($fichier, 12, 4);
		$mois = $nommoiss[substr($fichier, 16, 2)];
		$jour = substr($fichier, 18, 2);
		// Clubs
		$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$club = $row['NomComplet'];
		// Identification fichier
		$joursauv = substr($fichier, 24, 2);
		$moissauv = substr($fichier, 21, 3);
		$heuresauv = substr($fichier, 26, 2);
		$minsauv = substr($fichier, 28, 2);
		echo "<tr><th><a href='../../communs/restauration_fichier.php?concours=$fichier'>$club ($codeclub) du $jour $mois $an sauvegardé le $joursauv $moissauv à $heuresauv:$minsauv</a></th></tr>";
	}
}
$dir->close();
?>
</table>
<table align="center"><tr><th><div class="bouton"><a href="apresagi.php">RETOUR</a></div></th></tr></table>
</body>
</html>
