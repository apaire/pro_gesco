<?php
// Impression page
//$pdf->SetAutoPagebreak(True);
$pdf->addpage();
$hligne = 5;
// En-tête des pages
$pdf->image("../../images/SCC.jpg", 10, 10, 15);
$pdf->image("../../images/CNEAC.jpg", 185, 10, 15);
$pdf->setfont("Arial", "B", 12);
$texte = "CONCOURS D'AGILITY du ".$date;
$y = 12;
$pdf->setxy(10, $y);
$pdf->cell(0, 0, $texte, 0, 0, "C");
$texte = "ORGANISE PAR : ".utf8_decode($_SESSION['Club']);
$y = $y + 7;
$pdf->setxy(10, $y);
$pdf->cell(0, 0, $texte, 0, 0, "C");
$texte = "REGIONALE : ".utf8_decode($_SESSION['Regionale']);
$y = $y + 7;
$pdf->setxy(10, $y);
$pdf->cell(0, 0, $texte, 0, 0, "C");
$y = $y + 7;
$pdf->setxy(10, $y);
$pdf->cell(0, 0, $titre, 0, 0, "C");
$y = $pdf->gety() + 5;
$pdf->setfont("Arial", "B", 10);
?>