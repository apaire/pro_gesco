<?php
include("../utilitaires/imp_titre_l.php");
$hligne = 5;
// En-tête des pages
$pdf->setfont("Arial", "B", 14);
$pdf->setxy(10, 25);
$texte = utf8_decode("RESULTATS - ".$nomepreuves[$epreuve]." - Catégorie ".$nomcategories[$categorie]." - Classe ".$nomclasses[$classe]);
if ($handi > 0){$texte .= " - Handi ".$handi;}
$pdf->cell(0, 7, $texte, 0, 1, "C");
if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
	$texte = utf8_decode("Juge : $juge - Obstacles : $nbobstacles - Longueur : $longueur m - Vitesse : $vitesse m/sec - TPS : $tps sec - TMP : $tmp sec");
	$pdf->setfont("helvetica", "B", 12);
	$pdf->cell(0, 10, $texte, 0, 0, "C");
}
$pdf->setfont("helvetica", "B", 10);
$posy = 45;
$pdf->setxy(10, $posy);
$pdf->cell(11, 10, "Clas.", 1, 0, "C");
$pdf->cell(11, 10, "Dos.", 1, 0, "C");
$pdf->setfont("Arial", "B", 11);

if ($epreuve == 1 and $classe == 1){ // Affiche brevet
	$pdf->cell(28, 10, "Nom du Chien", 1, 0);
	$pdf->cell(35, 10, "Race du chien", 1, 0);
	$pdf->cell(44, 10, "Conducteur", 1, 0);
	$pdf->cell(43, 10, utf8_decode("Club / Régionale"), 1, 0);
	$pdf->cell(15, 5, "Temps", 0, 0, "C");
	$pdf->cell(15, 5, "Vit.Ev.", 0, 0, "C");
	$pdf->cell(45, 5, utf8_decode("Pénalités"), 1, 0, "C");
	$pdf->cell(15, 10, "Qual.", 1, 0, "C");
	$pdf->cell(15, 10, "Brevet", 1, 0, "C");
	$pdf->setxy(182, $posy);
	$pdf->cell(15, 10, "", 1);
	$pdf->cell(15, 10, "", 1);
	$posy = $posy + $hligne;
	$pdf->setxy(182, $posy);
	$pdf->cell(15, 5, "sec", 0, 0, "C");
	$pdf->cell(15, 5, "m/sec", 0, 0, "C");
	$pdf->cell(15, 5, ">TPS", 1, 0, "C");
	$pdf->cell(15, 5, "Parc.", 1, 0, "C");
	$pdf->cell(15, 5, "Total", 1, 0, "C");
} else if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
	$pdf->cell(38, 10, "Nom du Chien", 1, 0);
	$pdf->cell(38, 10, "Race du chien", 1, 0);
	$pdf->cell(44, 10, "Conducteur", 1, 0);
	$pdf->cell(48, 10, utf8_decode("Club / Régionale"), 1, 0);
	$pdf->cell(15, 5, "Temps", 0, 0, "C");
	$pdf->cell(15, 5, "Vit.Ev.", 0, 0, "C");
	$pdf->cell(45, 5, utf8_decode("Pénalités"), 1, 0, "C");
	$pdf->cell(0, 10, "Qual.", 1, 0, "C");
	$pdf->setxy(200, $posy);
	$pdf->cell(15, 10, "", 1);
	$pdf->cell(15, 10, "", 1);
	$posy = $posy + $hligne;
	$pdf->setxy(200, $posy);
	$pdf->cell(15, 5, "sec", 0, 0, "C");
	$pdf->cell(15, 5, "m/sec", 0, 0, "C");
	$pdf->cell(15, 5, ">TPS", 1, 0, "C");
	$pdf->cell(15, 5, "Parc.", 1, 0, "C");
	$pdf->cell(15, 5, "Total", 1, 0, "C");
} else if ($epreuve == 11 or $epreuve == 15){ // Affiche pénalités antérieures
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
} else if ($epreuve == 12 or $epreuve == 16 or $epreuve == 19){
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
	if ($epreuve == 1 and $classe == 1){
		$pdf->setxy(10, $posy);
		$pdf->setfont("", "", 10);
		$pdf->cell(11, 5, $classements[$num], 0, 0, "C");
		$pdf->cell(11, 5, $dossards[$num], 0, 0, "C");
		while ($pdf->GetStringWidth($nomchien) > 28){
			$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
		}
		$pdf->cell(28, 5, $nomchien, 0, 0);
		while ($pdf->GetStringWidth($race) > 35){
			$race = substr($race, 0, strlen($race)-1);
		}
		$pdf->cell(35, 5, $race, 0, 0);
		while ($pdf->GetStringWidth($nom) > 44){
			$nom = substr($nom, 0, strlen($nom)-1);
		}
		$pdf->cell(44, 5, $nom, 0, 0);
		$pdf->setfont("", "", 8);
		while ($pdf->GetStringWidth($club) > 43){
			$club = substr($club, 0, strlen($club)-1);
		}
		$pdf->cell(43, 5, $club, 0, 0);
		$pdf->setfont("", "", 10);
		$pdf->cell(15, 5, $tempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $vitevs[$num], 0, 0, "C");
		$pdf->cell(15, 5, $depastempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $penalitess[$num], 0, 0, "C");
		$pdf->cell(15, 5, $totals[$num], 0, 0, "C");
		$pdf->cell(15, 5, $nomresultatcodes[$resultats[$num]], 0, 0, "C");
		$pdf->cell(15, 5, utf8_decode($brevets[$num]), 0, 0, "C");
	} else if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
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
		$pdf->setfont("", "", 8);
		while ($pdf->GetStringWidth($club) > 48){
			$club = substr($club, 0, strlen($club)-1);
		}
		$pdf->cell(48, 5, $club, 0, 0);
		$pdf->setfont("", "", 10);
		$pdf->cell(15, 5, $tempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $vitevs[$num], 0, 0, "C");
		$pdf->cell(15, 5, $depastempss[$num], 0, 0, "C");
		$pdf->cell(15, 5, $penalitess[$num], 0, 0, "C");
		$pdf->cell(15, 5, $totals[$num], 0, 0, "C");
		$pdf->cell(0, 5, $nomresultatcodes[$resultats[$num]], 0, 0, "C");
	} else if ($epreuve == 11 or $epreuve == 15){ // Affiche pénalités antérieures
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
	// Cadre
	$pdf->setxy(10, $posy);
	$pdf->cell(0, 5, "", 1);
	// Suite
	$posy = $posy + $hauteur;
}

// Copyright
include("../utilitaires/imp_copyright_l.php");
?>