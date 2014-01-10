<?php
// Choix des liasses à imprimer
if ($ordre == "clas"){$order = "Handi, Classe, Categorie, Classement";}
if ($ordre == "dossard"){$order = "Dossard";}
$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' AND Resultat<>'' AND Resultat<>'F' ORDER BY $order";
$result = mysql_query($query);
$num_chien = 1;
while ($row = mysql_fetch_assoc($result)){
	// Résultats cumul
	$idlicence = $row['IdLicence'];
	$dossard = $row['Dossard'];
	$temps = $row['Temps'];
	$depastemps = $row['Depastemps'];
	$penalites = $row['Penalites'];
	$total = $row['Total'];
	$penalitesant = $row['PenalitesAnt'];
	$classement = $row['Classement'];
	$resultat = $row['Resultat'];
	// Lecture licence
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$licence = $row1['Licence'];
	$nomchien = $row1['NomChien'];
	$coderace = $row1['CodeRace'];
	$sexe = $row1['Sexe'];
	$nom = $row1['Titre']." ".$row1['Nom']." ".$row1['Prenom'];
	$codeclub = $row1['CodeClub'];
	$categorie = $row1['Categorie'];
	$classe = $row1['Classe'];
	$handi = $row1['Handi'];
	$nomhandi = $nomhandis[$handi];
	$nomcategorie = $nomcategories[$categorie];
	// Décodage Race
	$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$race = $row1['Race']." ".$row1['RaceVariete'];
	// Décodage Club
	$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$club = $row1['Club'];
	$coderegionale = $row1['CodeRegionale'];
	// Décodage Régionale
	$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$regionale = $row1['Regionale'];

	// Résultats manche 1
	if ($epreuve == 11 or $epreuve == 12){
		$epreuve1 = 9;
		$epreuve2 = 10;
	}
	if ($epreuve == 15 or $epreuve == 16){
		$epreuve1 = 13;
		$epreuve2 = 14;
	}
	if ($epreuve == 19){
		$epreuve1 = 17;
		$epreuve2 = 18;
	}
	for ($e = $epreuve1; $e <= $epreuve2; $e++){
		$query = "SELECT * FROM agility_resultats WHERE Epreuve='$e' AND IdLicence='$idlicence'";
		$resultat1 = mysql_query($query);
		$row = mysql_fetch_assoc($resultat1);
		$idepreuves[$e] = $row['IdEpreuve'];
		$classements[$e] = $row['Classement'];
		$tempss[$e] = $row['Temps'];
		$penalitess[$e] = $row['Penalites'];
		$depastempss[$e] = $row['Depastemps'];
		$totals[$e] = $row['Total'];
		$resultats[$e] = $row['Resultat'];
		if ($classements[$e] == 0){$classement1 = "";}
		if ($classements[$e] == 9995){$classement1 = "NC";}
		if ($classements[$e] > 9995){$classement1 = "";}
		$qualificatifs[$e] = $nomresultatabrs[$resultats[$e]];
		// Caractéristiques de la manche 1
		$query = "SELECT * FROM agility_epreuves WHERE Id='$idepreuves[$e]'";
		$resultepreuve = mysql_query($query);
		$row = mysql_fetch_assoc($resultepreuve);
		$epreuves[$e] = $row['Epreuve'];
		$engagess[$e] = $row['Engages'];
		$juges[$e] = $row['Juge'];
		$nbobstacless[$e] = $row['NbObstacles'];
		$longueurs[$e] = $row['Longueur'];
		$vitesses[$e] = $row['Vitesse'];
		$tpss[$e] = $row['TPS'];
		$tmps[$e] = $row['TMP'];
		$epreuves[$e] = $nomepreuveabr1s[$epreuves[$e]];
		if ($tempss[$e] > 0){$vitevs[$e] = number_format($longueurs[$e] / $tempss[$e], 2);} else {$vitevs[$e] = 0;}
	}
	// Impression******************************************************************************
	// Position d'impression
	if ($num_chien == 1){ // Premier chien de la page
		// initialisation page
		$pdf->addpage();
		$pdf->line(0, 148.5, 10, 148.5);
		$pdf->line(200, 148.5, 210, 148.5);
		$ydeb = 12;
		$yfin = 138.5;
		$ybrevet = 135;
		$num_chien = 2;
	} else { // Deuxième chien de la page
		$ydeb = 156.5;
		$yfin = 287;
		$ybrevet = 280;
		$num_chien = 1;
	}
	// En-tête des pages
	$pdf->image("../../images/CNEAC_bw.jpg", 10, $ydeb, 15);
	$pdf->setfont("Arial", "B", 12);
	$texte = "CONCOURS D'AGILITY du ".$date;
	$l = $pdf->GetStringWidth($texte);
	$x = (210 - $l)/2;
	$y = $ydeb + 2;
	$pdf->setxy($x, $y);
	$pdf->cell(33, 0, $texte);
	$texte = "ORGANISE PAR : ".utf8_decode($_SESSION['Club']);
	$l = $pdf->GetStringWidth($texte);
	$x = (210 - $l)/2;
	$y = $y + 7;
	$pdf->setxy($x, $y);
	$pdf->cell(33, 0, $texte);
	$texte = "REGIONALE : ".utf8_decode($_SESSION['Regionale']);
	$l = $pdf->GetStringWidth($texte);
	$x = (210 - $l)/2;
	$y = $y + 7;
	$pdf->setxy($x, $y);
	$pdf->cell(33, 0, $texte);
	// Cadre
	$y1 = $y + 10;
	$pdf->setxy(10, $y1);
	$pdf->cell(0, 26, "", 1, 0);
	// Chien
	$y = $y + 15;
	$pdf->setxy(10, $y);
	$pdf->cell(30, 0, "Chien :", 0, 0);
	$chien = utf8_decode($nomchien." (".$race.")");
	while ($pdf->GetStringWidth($chien) > 90){
		$chien = substr($chien, 0, strlen($chien)-1);
	}
	$pdf->cell(20, 0, $chien, 0, 0);
	$pdf->setx(130);
	$pdf->cell(20, 0, "Sexe : ".$sexe, 0, 0);
	$pdf->setx(170);
	$pdf->cell(0, 0, utf8_decode("Catégorie : ".$nomcategorie), 0, 0, "R");
	// Conducteur
	$y = $y + 8;
	$pdf->setxy(10, $y);
	$pdf->cell(30, 0, "Conducteur :", 0, 0);
	$pdf->cell(60, 0, utf8_decode($nom), 0, 0);
	if ($handi > 0){$pdf->cell(20, 0, utf8_decode("Handi $nomhandi"), 0, 0);}
	$pdf->setx(130);
	$pdf->cell(20, 0, "Licence : ".$licence, 0, 0);
	$pdf->setx(170);
	$pdf->cell(0, 0, "Dossard : ".$dossard, 0, 0, "R");
	// Club
	$y = $y + 8;
	$pdf->setxy(10, $y);
	$pdf->cell(30, 0, "Club :", 0, 0);
	$pdf->cell(20, 0, utf8_decode($club), 0, 0);
	$pdf->setx(130);
	$pdf->cell(0, 0, utf8_decode("Régionale : ".$regionale), 0, 0, "R");
	// Cadre
	$y1 = $y + 7;
	$pdf->setxy(10, $y1);
	$pdf->cell(0, 65, "", 1, 0);
	// Titre résultats
	$pdf->setfont("Arial", "B", 10);
	$y = $y + 10;
	$pdf->setxy(10, $y);
	$pdf->cell(40, 0, "Epreuve", 0, 0);
	$pdf->cell(11, 0, "Eng.", 0, 0, "C");
	$pdf->cell(11, 0, "Lon.", 0, 0, "C");
	$pdf->cell(11, 0, "Obst.", 0, 0, "C");
	$pdf->cell(11, 0, "Vit.", 0, 0, "C");
	$pdf->cell(11, 0, "TPS", 0, 0, "C");
	$pdf->cell(12, 0, "TMP", 0, 0, "C");
	$pdf->cell(14, 0, "Temps", 0, 0, "C");
	$pdf->cell(14, 0, "Vit.Ev", 0, 0, "C");
	$pdf->cell(33, 0, utf8_decode("Pénalités"), 0, 0, "C");
	$pdf->cell(11, 0, "Pla.", 0, 0, "C");
	$pdf->cell(11, 0, "Qual.", 0, 0, "C");
	$y = $y + 5;
	$pdf->setxy(20, $y);
	$pdf->cell(41, 0, "Juge", 0, 0);
	$pdf->cell(11, 0, "(m)", 0, 0, "C");
	$pdf->cell(11, 0, "", 0, 0, "C");
	$pdf->cell(11, 0, "(m/s)", 0, 0, "C");
	$pdf->cell(11, 0, "(sec)", 0, 0, "C");
	$pdf->cell(12, 0, "(sec)", 0, 0, "C");
	$pdf->cell(14, 0, "(sec)", 0, 0, "C");
	$pdf->cell(14, 0, "(m/s)", 0, 0, "C");
	$pdf->cell(11, 0, "> TPS", 0, 0, "C");
	$pdf->cell(11, 0, "Parc.", 0, 0, "C");
	$pdf->cell(11, 0, "Total", 0, 0, "C");
	// Résultats Manches 1 et 2
	$pdf->setfont("Arial", "", 10);
	for ($e = $epreuve1; $e <= $epreuve2; $e++){
		$y = $y + 5;
		$pdf->setxy(10, $y);
		$pdf->cell(40, 0, utf8_decode($epreuves[$e]), 0, 0);
		$pdf->cell(11, 0, $engagess[$e], 0, 0, "C");
		$pdf->cell(11, 0, $longueurs[$e], 0, 0, "C");
		$pdf->cell(11, 0, $nbobstacless[$e], 0, 0, "C");
		$pdf->cell(11, 0, $vitesses[$e], 0, 0, "C");
		$pdf->cell(11, 0, $tpss[$e], 0, 0, "C");
		$pdf->cell(12, 0, $tmps[$e], 0, 0, "C");
		$pdf->cell(14, 0, $tempss[$e], 0, 0, "C");
		$pdf->cell(14, 0, $vitevs[$e], 0, 0, "C");
		$pdf->cell(11, 0, $depastempss[$e], 0, 0, "C");
		$pdf->cell(11, 0, $penalitess[$e], 0, 0, "C");
		$pdf->cell(11, 0, $totals[$e], 0, 0, "C");
		$pdf->cell(11, 0, $classements[$e], 0, 0, "C");
		$pdf->cell(11, 0, $qualificatifs[$e], 0, 0, "C");
		$y = $y + 5;
		$pdf->setxy(20, $y);
		$pdf->cell(45, 0, utf8_decode($juges[$e]), 0, 0);
	}
	// Cumul
	$nomepreuve = $nomepreuves[$epreuve];
	$y = $y + 8;
	$pdf->setxy(10, $y);
	$pdf->setfont("Arial", "B", 10);
	$pdf->cell(40, 0, utf8_decode($nomepreuve), 0, 0);
	$pdf->setfont("Arial", "", 10);
	if ($epreuve == 11 or $epreuve == 15){
		$pdf->cell(67, 0, utf8_decode("Pénal. Antérieures : ").$penalitesant, 0, 0, "R");
	} else {
		$pdf->cell(67, 0, "", 0, 0);
	}
	$pdf->cell(14, 0, $temps, 0, 0, "C");
	$pdf->cell(14, 0, "");
	$pdf->cell(11, 0, $depastemps, 0, 0, "C");
	$pdf->cell(11, 0, $penalites, 0, 0, "C");
	$pdf->cell(11, 0, $total, 0, 0, "C");
	$pdf->cell(11, 0, $classement, 0, 0, "C");
	$pdf->cell(11, 0, $qualificatif, 0, 0, "C");
	$y = $y + 5;
	// Signature
	if ($epreuve == 11 or $epreuve == 15 or $epreuve == 19){
		$pdf->setxy(10, $y);
		$pdf->cell(25, 20, "Le concurrent", 0, 0, "L");
		$pdf->cell(20, 10, "ACCEPTE", 1, 0);
		$pdf->cell(50, 10, "", 1, 0);
		$pdf->setxy(35, $y + 10);
		$pdf->cell(20, 10, "REFUSE", 1, 0);
		$pdf->cell(50, 10, "", 1, 0);
		$pdf->setxy(105, $y);
		$pdf->cell(20, 20, utf8_decode("la sélection"), 0, 0);
		if ($epreuve == 19){
			$y = $y + 2.5;
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("TOUT DESISTEMENT DOIT ETRE SIGNALE"), 0, 0);
			$y = $y + 5;
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("LE JOUR DU SELECTIF. AU-DELA AUCUN"), 0, 0);
			$y = $y + 5;
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("REMPLACEMENT NE SERA POSSIBLE"), 0, 0);
		} else {
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("TOUT DESISTEMENT DOIT ETRE SIGNALE"), 0, 0);
			$y = $y + 5;
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("LE JOUR DU CHAMPIONNAT. AU-DELA"), 0, 0);
			$y = $y + 5;
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("AUCUN REMPLACEMENT NE SERA"), 0, 0);
			$y = $y + 5;
			$pdf->setxy(125, $y);
			$pdf->cell(20, 5, utf8_decode("POSSIBLE"), 0, 0);
		}
	}
	// Copyright
	$pdf->setfont("", "", 6);
	$pdf->setXY(10, $yfin);
	$pdf->cell(100, 0, "PROGESCO Version ".$_SESSION['Version'].".".$_SESSION['SousVersion'], 0, 0);
}
?>