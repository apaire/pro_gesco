<?php
include("../utilitaires/imp_titre_l.php");
$hligne = 5;
// En-tête des pages
$pdf->setfont("Arial", "B", 14);
$pdf->setxy(10, 25);
$texte = utf8_decode("RESULTATS - ".$nomepreuves[$epreuve]." - Catégorie ".$nomcategories[$categorie]." - Classe ".$nomclasses[$classe]);
if ($handi > 0){$texte .= " - Handi ".$handi;}
$pdf->cell(0, 7, $texte, 0, 1, "C");
$pdf->setfont("helvetica", "B", 10);
$posy = 45;
$pdf->setxy(10, $posy);

$numdeb = 1 + ($num_page - 1) * $concurrentsparpage;
if ($numdeb <= $nb_concurrents){ // Impression ligne de titre
	$pdf->cell(11, 10, "Clas.", 1, 0, "C");
	$pdf->cell(11, 10, "Dos.", 1, 0, "C");
	$pdf->setfont("Arial", "B", 11);
	if ($epreuve == 11 or $epreuve == 15){ // Affiche pénalités antérieures
		$pdf->cell(30, 10, "Nom du Chien", 1, 0);
		$pdf->cell(30, 10, "Race du chien", 1, 0);
		$pdf->cell(39, 10, "Conducteur", 1, 0);
		$pdf->cell(63, 10, utf8_decode("Club / Régionale"), 1, 0);
		$pdf->cell(15, 5, "Temps", 0, 0, "C");
		$pdf->cell(60, 5, utf8_decode("Pénalités"), 1, 0, "C");
		$pdf->cell(0, 10, "Qual.", 1, 0, "C");
		$pdf->setxy(194, $posy);
		$pdf->cell(15, 10, "", 1);
		$posy = $posy + $hligne;
		$pdf->setxy(194, $posy);
		$pdf->cell(15, 5, "sec", 0, 0, "C");
		$pdf->cell(15, 5, "Ant.", 1, 0, "C");
		$pdf->cell(15, 5, ">TPS", 1, 0, "C");
		$pdf->cell(15, 5, "Parc.", 1, 0, "C");
		$pdf->cell(15, 5, "Total", 1, 0, "C");
	} else {
		$pdf->cell(38, 10, "Nom du Chien", 1, 0);
		$pdf->cell(38, 10, "Race du chien", 1, 0);
		$pdf->cell(44, 10, "Conducteur", 1, 0);
		$pdf->cell(63, 10, utf8_decode("Club / Régionale"), 1, 0);
		$pdf->cell(15, 5, "Temps", 0, 0, "C");
		$pdf->cell(45, 5, utf8_decode("Pénalités"), 1, 0, "C");
		$pdf->cell(0, 10, "Qual.", 1, 0, "C");
		$pdf->setxy(215, $posy);
		$pdf->cell(15, 10, "", 1);
		$posy = $posy + $hligne;
		$pdf->setxy(215, $posy);
		$pdf->cell(15, 5, "sec", 0, 0, "C");
		$pdf->cell(15, 5, ">TPS", 1, 0, "C");
		$pdf->cell(15, 5, "Parc.", 1, 0, "C");
		$pdf->cell(15, 5, "Total", 1, 0, "C");
	}
}
// Impression Ligne
$numdeb = 1 + ($num_page - 1) * $concurrentsparpage;
$numfin = $numdeb + $concurrentsparpage - 1;
if ($numfin > $nb_concurrents){$numfin = $nb_concurrents;}
$hauteur = 5; // Hauteur d'un enregistrement (1 ligne)
$posy = $posy + 5;
for ($num = $numdeb; $num <= $numfin; $num++){
	// Ligne 1
	$nomchien = utf8_decode($nomchiens[$num]);
	$race = utf8_decode($races[$num]);
	$nom = utf8_decode($noms[$num]);
	$club = utf8_decode($clubs[$num]);
	if ($epreuve == 11 or $epreuve == 15){ // Affiche pénalités antérieures
		$pdf->setxy(10, $posy);
		$pdf->setfont("", "", 10);
		$pdf->cell(11, 5, $classements[$num], 0, 0, "C");
		$pdf->cell(11, 5, $dossards[$num], 0, 0, "C");
		while ($pdf->GetStringWidth($nomchien) > 30){
			$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
		}
		$pdf->cell(30, 5, $nomchien, 0, 0);
		while ($pdf->GetStringWidth($race) > 30){
			$race = substr($race, 0, strlen($race)-1);
		}
		$pdf->cell(30, 5, $race, 0, 0);
		while ($pdf->GetStringWidth($nom) > 39){
			$nom = substr($nom, 0, strlen($nom)-1);
		}
		$pdf->cell(39, 5, $nom, 0, 0);
		$pdf->setfont("", "", 8);
		while ($pdf->GetStringWidth($club) > 63){
			$club = substr($club, 0, strlen($club)-1);
		}
		$pdf->cell(63, 5, $club, 0, 0);
		$pdf->setfont("", "", 10);
		$pdf->cell(15, 5, $tempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $penalitesants[$num], 0, 0, "C");
		$pdf->cell(15, 5, $depastempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $penalitess[$num], 0, 0, "C");
		$pdf->cell(15, 5, $totals[$num], 0, 0, "C");
		$pdf->cell(0, 5, $nomresultatcodes[$resultats[$num]], 0, 0, "C");
	} else if ($epreuve == 12 or $epreuve == 16 or $epreuve == 19){
		$pdf->setxy(10, $posy);
		$pdf->setfont("", "", 10);
		$pdf->cell(11, 5, $classements[$num], 0, 0, "C");
		$pdf->cell(11, 5, $dossards[$num], 0, 0, "C");
		while ($pdf->GetStringWidth($nomchien) > 38){
			$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
		}
		$pdf->cell(38, 5, $nomchien, 0, 0);
		while ($pdf->GetStringWidth($race) > 38){
			$race = substr($race, 0, strlen($race)-1);
		}
		$pdf->cell(38, 5, $race, 0, 0);
		while ($pdf->GetStringWidth($nom) > 44){
			$nom = substr($nom, 0, strlen($nom)-1);
		}
		$pdf->cell(44, 5, $nom, 0, 0);
		while ($pdf->GetStringWidth($club) > 63){
			$club = substr($club, 0, strlen($club)-1);
		}
		$pdf->cell(63, 5, $club, 0, 0);
		$pdf->setfont("", "", 10);
		$pdf->cell(15, 5, $tempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $depastempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $penalitess[$num], 0, 0, "C");
		$pdf->cell(15, 5, $totals[$num], 0, 0, "C");
		$pdf->cell(0, 5, $nomresultatcodes[$resultats[$num]], 0, 0, "C");
	}
	// Impression manches
	$dossard = $dossards[$num];
	if ($epreuve == 11 or $epreuve == 12){
		$epreuveimp = 9;
		$manche = "Manche 1";
		include("pendantagi_resultatsimp_3_ChR.php");
		$epreuveimp = 10;
		$manche = "Manche 2";
		include("pendantagi_resultatsimp_3_ChR.php");
	}
	if ($epreuve == 15 or $epreuve == 16){
		$epreuveimp = 13;
		$manche = "Manche 1";
		include("pendantagi_resultatsimp_3_ChR.php");
		$epreuveimp = 14;
		$manche = "Manche 2";
		include("pendantagi_resultatsimp_3_ChR.php");
	}
	if ($epreuve == 19){
		$epreuveimp = 17;
		$manche = "Manche 1";
		include("pendantagi_resultatsimp_3_ChR.php");
		$epreuveimp = 18;
		$manche = "Manche 2";
		include("pendantagi_resultatsimp_3_ChR.php");
	}
	// Cadre
	$pdf->setxy(10, $posy - 10);
	$pdf->cell(0, 15, "", 1);
	// Suite
	$posy = $posy + $hauteur;
}

// Copyright
include("../utilitaires/imp_copyright_l.php");
?>