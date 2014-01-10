<?php
session_start();
// connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
include("../../communs/imp_init_p.php");
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
// Choix des liasses à imprimer
$epreuve = $_GET['epreuve'];
$ordre = $_GET['ordre'];
if ($epreuve == 11){
	include("apresagi_liassesimp_1_ChR.php");
	$epreuve = 15;
	include("apresagi_liassesimp_1_ChR.php");
}
if ($epreuve == 12){
	include("apresagi_liassesimp_1_ChR.php");
	$epreuve = 16;
	include("apresagi_liassesimp_1_ChR.php");
}
if ($epreuve == 19){
	include("apresagi_liassesimp_1_ChR.php");
}
$pdf->output();

?>