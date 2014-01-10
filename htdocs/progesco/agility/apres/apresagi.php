<?php
session_start();
$titre = "<a href='apresagi.php'>Après le concours</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="version" content="01.02.06" />
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<body>
<body>
	<table style="width: 950px; height: 184px;" align="center">
	<tbody><tr>
		<td align="left" valign="top" width="1%"><img src="../../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td align="right" valign="top" width="1%"><img src="../../images/CNEAC.jpg" width="100" /></td>
	</tr>
</tbody></table>
<table class="general" align="center">
	<tr><th><div class="boutonimp"><a href="apresagi_liassesimp.php">IMPRESSION DES LIASSES</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="apresagi_statsimp.php" target="_blank">IMPRESSION DES STATISTIQUES</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="apresagi_impbrevets.php" target="_blank">IMPRESSION DES BREVETS</a></div></th></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><th><div class="boutonchoix"><a href="apresagi_sauvegarde.php">SAUVEGARDE DU CONCOURS</a></div></th></tr>
	<tr><th><div class="boutonchoix"><a href="apresagi_restauration_SQL.php">RESTAURATION D'UN CONCOURS</a></div></th></tr>
	<tr><th><div class="boutonchoix"><a href="apresagi_restauration.php">RESTAURATION D'UN CONCOURS<br />au format cneac (obsolète)</a></div></th></tr>
	
	<tr><td>&nbsp;</td></tr>
	<tr><th><div class="boutonchoix"><a href="apresagi_envoiinternet.php">ENVOI des Fichiers par INTERNET</a></div></th></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><th align="center"><div class="bouton"><a href="../agility.php">RETOUR</a></div></th></tr>
</table>
</body>
</html>