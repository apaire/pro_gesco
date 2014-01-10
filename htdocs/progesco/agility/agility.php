<?php
session_start();
$_SESSION['Activite'] = "Agility";
$_SESSION['Programme'] = "agility";
include("../communs/lect_variables_genes.php"); // Variables générales
include("utilitaires/lect_variables_agi.php"); // Variables agility
include("utilitaires/bandeau_logos.php");
?>
<meta name="version" content="01.02.06" />
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../communs/styles.css" rel="stylesheet" type="text/css" />

<h2 class="center"><span class="">Choisir un onglet</span></h2>

<table class="general" align="center" width="950">
	<tbody><tr><th><table align="center"><tbody><tr><th><div class="boutonchoix"><a href="init/initagi.php">INITIALISATION DU CONCOURS</a></div></th></tr></tbody></table></th></tr>
	<tr><th><table align="center"><tbody><tr><th><div class="boutonchoix"><a href="avant/avantagi.php">AVANT LE CONCOURS</a></div></th></tr></tbody></table></th></tr>
	<tr><th><table align="center"><tbody><tr><th><div class="boutonchoix"><a href="pendant/pendantagi.php">PENDANT LE CONCOURS</a></div></th></tr></tbody></table></th></tr>
	<tr><th><table align="center"><tbody><tr><th><div class="boutonchoix"><a href="apres/apresagi.php">APRES LE CONCOURS</a></div></th></tr></tbody></table></th></tr>
	<tr><th><table align="center"><tbody><tr><th><div class="boutonchoix"><a href="../boiteaoutils/boiteaoutils.php">BOITE A OUTILS</a></div></th></tr></tbody></table></th></tr>
	<tr><th><table align="center"><tbody><tr><th><div class="boutonchoix"><a href="init/initagi_apropos.php">A PROPOS DE PROGESCO AGILITY</a></div></th></tr></tbody></table></th></tr>
	<tr><th><table align="center"><tbody><tr><th><div class="bouton"><a href="../progesco.php" target="_top">FIN DU TRAITEMENT</a></div></th></tr></tbody></table></th></tr>
</tbody></table>
