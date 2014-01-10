<?php
// Impression ligne
//$y = $y + $hligne;
//$pdf->setxy(10, $y);
$pdf->cell(85, 5, utf8_decode($nomepreuves[$epreuve_preced]." ".$nomcategories[$categorie_preced]), "L", 0);
for ($m = 0; $m < 7; $m++){$pdf->cell(15, 5, $nb_mentions[$m], 0, 0, "C");}
//$pdf->setxy(10, $y);
$pdf->cell(0, 5, "", "R", 1);
// Remise à zéro
for ($m = 0; $m < 7; $m++){$nb_mentions[$m] = "0";}
?>