<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a>";
include("../utilitaires/bandeau_agi.php");
$_SESSION['retour'] = "avantagi.php";
$_SESSION['idlicence'] = "";
$_SESSION['licence'] = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="version" content="01.02.06" />
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<table width="950" align="center">
	<tr>
		<td width="1%" align="left" valign="top"><img src="../../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td width="1%" align="right" valign="top"><img src="../../images/CNEAC.jpg" width="100" /></td>
	</tr></table>
<table class="general" align="center">
	<tr><th class="center"><div class="boutonchoix"><a href="avantagi_concurrents.php?ordre=Licence">ENTREE DES CONCURRENTS</a></div></th></tr>
	<tr><th class="center"><div class="boutonimp"><a href="avantagi_concurrentsimp.php">IMPRESSION DES CONCURRENTS ENTRES</a></div></th></tr>
<?php
if ($_SESSION["TypeConcours"] == "ChR" or $_SESSION["TypeConcours"] == "Comp" or $_SESSION['TypeConcours'] == "ChF"){
	echo "<tr><th><div class='boutonimp'><a href='avantagi_penalantsimp.php' target='_blank'>IMPRESSION DES PENALITES ANTERIEURES</a></div></th></tr>";
}
?>
	<tr><td>&nbsp;</td></tr>
	<tr><th class="center"><div class="boutonchoix"><a href="avantagi_dossards.php">ATTRIBUTION DES DOSSARDS</a></div></th></tr>
	<tr><th class="center"><div class="boutonchoix"><a href="avantagi_dossardsmodif.php?ordre=Dossard">MODIF MANUELLE DES N° DE DOSSARD</a></div></th></tr>
	<tr><th class="center"><div class="boutonimp"><a href="avantagi_dossardsimp.php?ordre=Dossard">IMPRESSION DES NUMEROS DE DOSSARD</a></div></th></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><th class="center"><div class="boutonchoix"><a href="avantagi_passages.php">ATTRIBUTION DES ORDRES DE PASSAGE</a></div></th></tr>
	<tr><th class="center"><div class="boutonchoix"><a href="avantagi_passagesmodif.php?ordre=Epreuve">MODIF MANUELLE DES ORDRES DE PASSAGE</a></div></th></tr>
	<tr><th class="center"><div class="boutonimp"><a href="avantagi_passagesimp.php?ordre=Dossard">IMPRESSION DES ORDRES DE PASSAGE</a></div></th></tr>
	<tr><th class="center"><div class="boutonimp"><a href="avantagi_dossards_affichage.php" target="_blank">AFFICHAGE POUR LA REMISE DES DOSSARDS</a></div></th></tr>
	<tr><th class="center"><div class="boutonimp"><a href="avantagi_dsvimp.php" target="_blank">IMPRESSION LISTE VETERINAIRE</a></div></th></tr>
	<tr><th class="center"><div class="boutonimp"><a href="avantagi_epreuvesimp.php" target="_blank">IMPRESSION DES EPREUVES DU CONCOURS</a></div></th></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><th align="center"><div class="bouton"><a href="../agility.php">RETOUR</a></div></th></tr>
</table>
</body>
</html>