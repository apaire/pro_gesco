<?php
// Impression Titre page
include("../utilitaires/imp_titre_p.php");
// Impression en-tête page
$pdf->setfont("Arial", "B", 11);
$pdf->setxy(10, 35);
$texte = utf8_decode($nomepreuve." / Catégorie ".$nomcategorie. " / Classe ".$nomclasse);
if ($handi > 0){$texte .= " / Handi ".$nomhandi;}
$pdf->cell(0, 7, $texte, 0, 1, "C");
$pdf->cell(0, 7, utf8_decode("Classés par n° de licence ($nb_concurrents concurrents)"), 0, 0, "C");
$pdf->setxy(10, 55);
$pdf->cell(18, 5, "Licence", 1, 0, "C");
$pdf->cell(60, 5, "Nom du Chien", 1, 0);
$pdf->cell(75, 5, utf8_decode("NOM et Prénom du Conducteur"), 1, 0);
$pdf->cell(0, 5, utf8_decode("Total pénalités"), 1, 0);
$pdf->setxy(28, 60);
$pdf->cell(60, 5, "Date", 1, 0);
$pdf->cell(75, 5, "Juge", 1, 0);
$pdf->cell(0, 5, utf8_decode("Pénalités"), 1, 0);
?>