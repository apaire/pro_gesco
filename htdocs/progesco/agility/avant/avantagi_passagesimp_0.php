<?php
session_start();
include("../utilitaires/nomvars_agi.php");
include("../../communs/imp_init_p.php");
include("../../communs/connexion.php");
$_SESSION['Ordre'] = $_GET['ordre'];
for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
	if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
		$_SESSION['Epreuve'] = $epreuve;
		$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$epreuve'";
		if (mysql_num_rows(mysql_query($query)) > 0){include ("avantagi_passagesimp_11.php");}
	}
}
$pdf->output();
?>