<?php
$hligne = 5;
// En-tête des pages
$pdf->image("../../images/CNEAC_bw.jpg", 10, $ydeb, 15);
$pdf->setfont("Arial", "B", 12);
//if ($_SESSION['TypeConcours'] == "CC"){
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

// Résultats
$pdf->setfont("Arial", "", 10);
for ($n = 1; $n <= $nb_epreuves; $n++){
	$y = $y + 8;
	$pdf->setxy(10, $y);
	$pdf->cell(40, 0, utf8_decode($epreuves[$n]), 0, 0);
	$pdf->cell(11, 0, $engagess[$n], 0, 0, "C");
	$pdf->cell(11, 0, $longueurs[$n], 0, 0, "C");
	$pdf->cell(11, 0, $nbobstacless[$n], 0, 0, "C");
	$pdf->cell(11, 0, $vitesses[$n], 0, 0, "C");
	$pdf->cell(11, 0, $tpss[$n], 0, 0, "C");
	$pdf->cell(12, 0, $tmps[$n], 0, 0, "C");
	$pdf->cell(14, 0, $tempss[$n], 0, 0, "C");
	$pdf->cell(14, 0, $vitevs[$n], 0, 0, "C");
	$pdf->cell(11, 0, $depastempss[$n], 0, 0, "C");
	$pdf->cell(11, 0, $penalitess[$n], 0, 0, "C");
	$pdf->cell(11, 0, $totals[$n], 0, 0, "C");
	$pdf->cell(11, 0, $classements[$n], 0, 0, "C");
	$pdf->cell(11, 0, $qualificatifs[$n], 0, 0, "C");
	$y = $y + 5;
	$pdf->setxy(20, $y);
	$pdf->cell(45, 0, utf8_decode($juges[$n]), 0, 0);
}

// Brevet
$pdf->setxy(50, $ybrevet);
$pdf->cell(0, 0, $textebrevet, 0, 0);
// Copyright
include("../../communs/imp_copyright_p.php");
?>