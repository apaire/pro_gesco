<?php
$hauteur = 5; // Hauteur d'un enregistrement (1 ligne)
$hligne = 5;
include("../utilitaires/imp_titre_l.php");
include("pendantagi_cumulsimp_titre.php");

/*
if (($_SESSION['typeconcours'] == "ChF") and ($epreuve0 == "O" or $epreuve0 == "C")){
	$posy = $posy + $hligne;
	$pdf->setxy(107, $posy);
	$pdf->cell(60, 5, "Agility 1", 1, 0, "C");
	$pdf->cell(60, 5, "Agility 2", 1, 0, "C");
	$pdf->cell(60, 5, "Jumping", 1, 0, "C");
	$posy = $posy + $hligne;
	$pdf->setxy(107, $posy);
	for ($x = 0; $x < 3; $x++){
		$pdf->cell(15, 10, "Temps", 1, 0, "C");
		$pdf->cell(45, 5, utf8_decode("Pénalités"), 1, 0, "C");
	}
	$posy = $posy + $hligne;
	$pdf->setxy(107, $posy);
	for ($x = 0; $x < 3; $x++){
		$pdf->cell(15, 5, "", 0, 0);
		$pdf->cell(15, 5, "temps", 1, 0, "C");
		$pdf->cell(15, 5, "parc.", 1, 0, "C");
		$pdf->cell(15, 5, "Total", 1, 0, "C");
	}
}
if ($_SESSION['typeconcours'] == "ChF" and $epreuve0 == "C"){
	$y = $posy - 7;
	$pdf->setxy(87, $y);
	$pdf->cell(20, 5, utf8_decode("Pénal."), 0, 0, "C");
	$y = $y + $hligne;
	$pdf->setxy(87, $y);
	$pdf->cell(20, 5, utf8_decode("Antér."), 0, 0, "C");
	$y = $posy - 10;
	$pdf->setxy(87, $y);
	$pdf->cell(20, 15, "", 1, 0);
}
*/


// Impression Ligne
$num = 1 + ($num_page - 1) * $concurrentsparpage;
if ($num_page == $nb_pages){$nmax = fmod($nb_concurrents - $num + 1, $concurrentsparpage);} else {$nmax = $concurrentsparpage;}
$posy = $posy + 7;
for ($n = 1; $n <= $nmax; $n++){
	// Ligne 
	$pdf->setxy(10, $posy);
	$pdf->setfont("", "", 10);
	$pdf->cell(11, 5, $classements[$num], 0, 0, "C");
	$pdf->cell(11, 5, $dossards[$num], 0, 0, "C");
	$nomchien = utf8_decode($nomchiens[$num]);
	while ($pdf->GetStringWidth($nomchien) > 38){
		$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
	}
	$pdf->cell(38, 5, $nomchien, 0, 0);
	$race = utf8_decode($races[$num]);
	while ($pdf->GetStringWidth($race) > 38){
		$race = substr($race, 0, strlen($race)-1);
	}
	$pdf->cell(38, 5, $race, 0, 0);
	$nom = utf8_decode($noms[$num]);
	while ($pdf->GetStringWidth($nom) > 44){
		$nom = substr($nom, 0, strlen($nom)-1);
	}
	$pdf->cell(44, 5, $nom, 0, 0);
	$pdf->setfont("", "", 8);
	$club = utf8_decode($clubs[$num]);
	while ($pdf->GetStringWidth($club) > 48){
		$club = substr($club, 0, strlen($club)-1);
	}
	if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$pdf->cell(48, 5, $club, 0, 0);}
	else {$pdf->cell(63, 5, $club, 0, 0);}
	$pdf->cell(15, 5, $tempss[$num], 0, 0, "C");
	if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$pdf->cell(15, 5, $penalitesants[$num], 0, 0, "C");}
	$pdf->cell(15, 5, $depastempss[$num], 0, 0, "C");
	$pdf->cell(15, 5, $penalitess[$num], 0, 0, "C");
	$pdf->cell(15, 5, $totals[$num], 0, 0, "C");
	$pdf->cell(0, 5, $nomresultatabrs[$resultats[$num]], 0, 0, "C");
	$num++;
	$posy = $posy + $hauteur;
}

// Copyright
include("../utilitaires/imp_copyright_l.php");
?>