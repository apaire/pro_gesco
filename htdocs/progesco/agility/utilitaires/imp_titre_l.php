<?php
// initialisation page
$pdf->addpage();
// en-tête 1
$pdf->image("../../images/SCC.jpg", 10, 10, 15);
$pdf->image("../../images/CNEAC.jpg", 272, 10, 15);
$pdf->setfont("Arial", "B", 14);
if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$texte = "CHAMPIONNAT DE FRANCE";}
else if ($_SESSION['Epreuve'] == "53" or $_SESSION['Epreuve'] == "54"){$texte = "COUPE DE FRANCE";}
else if ($_SESSION['Epreuve'] == "55"){$texte = "GRAND PRIX DE FRANCE";}
else {$texte = "CONCOURS D'AGILITY";}
$texte .= " du ".$date;
$l = $pdf->GetStringWidth($texte);
$x = (297 - $l)/2;
$pdf->setxy($x, 15);
$pdf->cell(33, 0, $texte);
$texte = "ORGANISE PAR : ".utf8_decode($_SESSION['Club']);
$l = $pdf->GetStringWidth($texte);
$x = (297 - $l)/2;
$pdf->setxy($x, 22);
$pdf->cell(33, 0, $texte);
$texte = utf8_decode($titre);
$l = $pdf->GetStringWidth($texte);
$x = (297 - $l)/2;
$pdf->setxy($x, 30);
$pdf->cell(33, 0, $texte);
?>