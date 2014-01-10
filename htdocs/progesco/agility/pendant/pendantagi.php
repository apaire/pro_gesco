<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a>";
include("../utilitaires/bandeau_agi.php");
// Initialisation variables
$_SESSION['civilite'] = "";
$_SESSION['nom'] = "";
$_SESSION['prenom'] = "";
$_SESSION['juge'] = "";
$_SESSION['tpscalc'] = "";
$_SESSION['tmpmin'] = "";
$_SESSION['tmpmax'] = "";
$_SESSION['drapeau_epreuve'] = "";
$_SESSION['choixepreuve'] = "";
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
	<table width="950" align="center">
	<tr>
		<td width="1%" align="left" valign="top"><img src="../../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td width="1%" align="right" valign="top"><img src="../../images/CNEAC.jpg" width="100" /></td>
	</tr>
</table>
<table class="general" align="center">
	<tr><th>&nbsp;</th></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th><div class="boutonchoix"><a href="pendantagi_epreuves.php">ENTREE DES PARAMETRES DES EPREUVES</a></div></th></tr>
	<tr><th><div class="boutonchoix"><a href="pendantagi_resultats.php">ENTREE DES RESULTATS</a></div></th></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th><div class="boutonchoix"><a href="pendantagi_resultatsaff.php">AFFICHAGE DES RESULTATS</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="pendantagi_resultatsimp.php">IMPRESSION DES RESULTATS</a></div></th></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th><div class="boutonchoix"><a href="pendantagi_cumulsregles.php">ENTREE D'UNE REGLE DE CUMUL</a></div></th></tr>
	<tr><th><div class="boutonchoix"><a href="pendantagi_cumulsaff.php">AFFICHAGE RESULTATS DES CUMULS</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="pendantagi_cumulsimp.php">IMPRESSION DES CUMULS D'EPREUVES</a></div></th></tr>
	<tr><th>&nbsp;</th></tr>
<?php
if ($_SESSION['TypeConcours'] == "ChF" or $_SESSION['TypeConcours'] == "GPF"){
	echo "<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww.php'>ENVOI DES RESULTATS SUR INTERNET</a></div></th></tr>
	<tr><td>&nbsp;</td></tr>";
}
?>

	<tr><th align="center"><div class="bouton"><a href="../agility.php">RETOUR</a></div></th></tr>
</table>
</body>
</html>