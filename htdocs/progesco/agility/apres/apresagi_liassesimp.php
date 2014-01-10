<?php
session_start();
$titre = "<a href='apresagi.php'>Après le concours</a> &gt; <a href='apresagi_liassesimp.php'>Impression des liasses</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<table style="width: 950px; height: 184px;" align="center">
	<tbody><tr>
		<td align="left" valign="top" width="1%"><img src="../../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td align="right" valign="top" width="1%"><img src="../../images/CNEAC.jpg" width="100" /></td>
	</tr>
</tbody></table>
<body onload="parent.Bandeau.location.href='apres_liassesimp_bandeau.php'">
<h3 class="center">Impression des liasses</h3>

<?php
$typeconcours = $_SESSION['TypeConcours'];
if ($typeconcours == 'ChR' or $typeconcours == 'ChRSGPF' or $typeconcours == 'Comp'){
	echo "<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_ChR.php?epreuve=11&ordre=clas' target='_blank'>CHAMPIONNAT REGIONAL PAR CLASSEMENT</a></div></th></tr></table>
	<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_ChR.php?epreuve=11&ordre=dossard' target='_blank'>CHAMPIONNAT REGIONAL PAR DOSSARD</a></div></th></tr></table>
	<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_ChR.php?epreuve=12&ordre=clas' target='_blank'>COUPE REGIONALE PAR CLASSEMENT</a></div></th></tr></table>
	<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_ChR.php?epreuve=12&ordre=dossard' target='_blank'>COUPE REGIONALE PAR DOSSARD</a></div></th></tr></table>
	<br />";
}
if ($typeconcours == 'SGPF' or $typeconcours == 'ChRSGPF' or $typeconcours == 'Comp'){
	echo "<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_ChR.php?epreuve=19&ordre=clas' target='_blank'>SELECTIF GPF PAR CLASSEMENT</a></div></th></tr></table>
	<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_ChR.php?epreuve=19&ordre=dossard' target='_blank'>SELECTIF GPF PAR DOSSARD</a></div></th></tr></table>
	<br />";
}
if ($typeconcours == "CC" or $typeconcours == "Comp"){
	?>
	<table align='center'><tr><th><div class='boutonimp'><a href='apresagi_liassesimp_2.php' target='_blank'>LIASSES PAR CLUB</a></div></th></tr></table>
	<table align='center'><tr><th><div class="boutonimp"><a href="apresagi_liassesimp_1.php" target="_blank">LIASSES PAR N° DE DOSSARD</a></div></th></tr></table>
	</table>
	<table align="center"><tr><th><div class="boutonimp"><a href="apresagi_liassesimp_2.php?categorie=1" target="_blank">LIASSES CATEGORIE A</a></div></th></tr></table>
	<table align="center"><tr><th><div class="boutonimp"><a href="apresagi_liassesimp_2.php?categorie=2" target="_blank">LIASSES CATEGORIE B</a></div></th></tr></table>
	<table align="center"><tr><th><div class="boutonimp"><a href="apresagi_liassesimp_2.php?categorie=3" target="_blank">LIASSES CATEGORIE C</a></div></th></tr></table>
	<table align="center"><tr><th><div class="boutonimp"><a href="apresagi_liassesimp_2.php?categorie=4" target="_blank">LIASSES CATEGORIE D</a></div></th></tr></table>
	<?php
}
?>
<table align="center"><tr><th><div class="bouton"><a href="apresagi.php">RETOUR</a></div></th></tr></table>
</body>
</html>