<?php
include("../utilitaires/imp_titre_p.php");
// En-tête des pages dossards
$pdf->setfont("Arial", "B", 10);
$pdf->setxy(10, 40);
$pdf->cell(70, 7, utf8_decode("EPREUVE : ".$nomepreuveabr1s[$epreuve]), 0, 0);
$pdf->cell(33, 7, "CATEGORIE : ".$nomcategories[$categorie_preced], 0, 0);
if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){$pdf->cell(33, 7, "CLASSE : ".$nomclasses[$classe_preced], 0, 0);}
if ($handi_preced > 0){$pdf->cell(30, 7, "HANDI : ".$nomhandis[$handi_preced], 0, 0);}
$pdf->setfont("", "", 8);
if ($nb_concurrents == 1){$pdf->cell(0, 7, "(".$nb_concurrents." concurrent)", 0, 0, "R");}
else {$pdf->cell(0, 7, "(".$nb_concurrents." concurrents)", 0, 0, "R");}
$pdf->setfont("Arial", "B", 10);
$pdf->setxy(10, 50);
$pdf->cell(15, 5, "Passage", 1, 0, "C");
$pdf->cell(15, 5, "Dossard", 1, 0, "C");
$pdf->cell(40, 5, "Nom du Chien", 1, 0);
$pdf->cell(40, 5, "Race du chien", 1, 0);
$pdf->cell(40, 5, "Conducteur", 1, 0);
$pdf->cell(0, 5, "Club", 1, 0);
// Impression Ligne
$num = 1 + ($num_page - 1) * $concurrentsparpage;
if ($num_page == $nb_pages){$nmax = fmod($nb_concurrents - $num, $concurrentsparpage) + 1;} else {$nmax = $concurrentsparpage;}
if ($nmax == 0){$nmax = $concurrentsparpage;}
$hauteur = 5; // Hauteur d'un enregistrement (2 lignes)
$posy = 55;
for ($n = 1; $n <= $nmax; $n++){
	// Ligne 1
	$pdf->setxy(10, $posy);
	$pdf->setfont("", "", 10);
	$pdf->cell(15, 5, $ordrepassages[$num], 0, 0, "C");
	$pdf->cell(15, 5, $dossards[$num], 0, 0, "C");
	$nomchien = utf8_decode($nomchiens[$num]);
	while ($pdf->GetStringWidth($nomchien) > 39){
		$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
	}
	$pdf->cell(40, 5, $nomchien, 0, 0);
	$pdf->setfont("", "", 8);
	$race = utf8_decode($races[$num]);
	while ($pdf->GetStringWidth($race) > 38){
		$race = substr($race, 0, strlen($race)-1);
	}
	$pdf->cell(40, 5, $race, 0, 0);
	$pdf->cell(40, 5, utf8_decode($conducteurs[$num]), 0, 0);
	$pdf->cell(0, 5, utf8_decode($clubs[$num]), 0, 0);
	// Cadre
	$pdf->setxy(10, $posy);
	$pdf->cell(0, 5, "", 1, 0);
	// Suite
	$num++;
	$posy = $posy + $hauteur;
}
// Copyright
include("../utilitaires/imp_copyright_p.php");
?>