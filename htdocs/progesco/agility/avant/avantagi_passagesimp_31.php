<?php
session_start();
// Liste des dossards
if ($posy > 260){
	$pdf->addpage;
	include("../utilitaires/imp_titre_p.php");
	$posy = 40;
}
$pdf->setfont("Arial", "B", 10);
$pdf->setxy(10, $posy);
$pdf->cell(70, 0, utf8_decode("EPREUVE : ".$nomepreuveabr1s[$epreuve]), 0, 0);
$pdf->cell(33, 0, "CATEGORIE : ".$nomcategories[$categorie], 0, 0);
if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
	$pdf->cell(33, 0, "CLASSE : ".$nomclasses[$classe], 0, 0);
}
if ($handi > 0){$pdf->cell(30, 0, "HANDI : ".$nomhandis[$handi], 0, 0);}
if ($nb_concurrents == 1){$pdf->cell(0, 0, "(".$nb_concurrents." concurrent)", 0, 1, "R");}
else {$pdf->cell(0, 0, "(".$nb_concurrents." concurrents)", 0, 1, "R");}
$texte = "";
while ($row = mysql_fetch_assoc($result)){
	$texte .= $row['Dossard']."   ";
}
// Impression liste dossards
$posy = $posy + 5;
$pdf->setxy(10, $posy);
$pdf->multicell(0, 5, $texte, 0, 1);
$posy = $pdf->gety() + 7;
?>