<?php
// Impression Chien
$num_page = floor($num / $concurrentsparpage) + 1;
$controle = ceil($num / $concurrentsparpage);
if ($num_page > $controle){$num_page--;}
if ($num_page > $num_page_preced){
	// Copyright
	$num_page--;
	include("../utilitaires/imp_copyright_p.php");
	include("avantagi_penalantsimp_1.php");
	$posy = 70;
	$num_page_preced++;
}
$hauteur = 35; // Hauteur d'un enregistrement
// Ligne 1
$pdf->setxy(10, $posy);
$pdf->setfont("", "", 10);
$pdf->cell(18, 5, $licence, 0, 0, "C");
$nomchien = utf8_decode($nomchien);
while ($pdf->GetStringWidth($nomchien) > 59){
	$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
}
$pdf->cell(60, 5, $nomchien, 0, 0);
$pdf->cell(75, 5, utf8_decode($conducteur), 0, 0);
$pdf->cell(0, 5, $totalpenalites, 0, 1);
// Lignes penalites
$y = $posy + 7;
for ($n = 1; $n <= 5; $n++){
	$pdf->setxy(28, $y);
	$pdf->cell(60, 5, $dates[$n], 0, 0);
	$pdf->cell(75, 5, $juges[$n], 0, 0);
	$pdf->cell(0, 5, $penalites[$n], 0, 0);
	$y = $y + 5;
}
// Cadre
$y = $posy - 1.5;
$pdf->setxy(10, $y);
$pdf->cell(0, $hauteur, "", 1);
$posy = $posy + $hauteur;
?>