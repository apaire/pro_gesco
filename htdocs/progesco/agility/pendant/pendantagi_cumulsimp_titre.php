<?php
// En-tête des pages
//include("../utilitaires/nomvars_agi.php");
$pdf->setfont("Arial", "B", 14);
$pdf->setxy(10, 25);
$texte = "RESULTATS ".$nomcumul;
if ($epreuves{49} == "N"){$texte .= " - Catégorie ".$nomcategories[$categorie];}
if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){$texte .= " - Classe ".$nomclasses[$classe];}
if ($handi > 0){$texte .= " - Handi ".$handi;}
if ($num_page == 1){ $texte .= " ($nb_concurrents concurrents)";} else {$texte .= " (suite)";}
$pdf->cell(0, 10, utf8_decode($texte), 0, 0, "C");
$pdf->setfont("helvetica", "B", 10);
$posy = 37;
$pdf->setxy(10, $posy);
$pdf->cell(11, 10, "Clas.", 1, 0, "C");
$pdf->cell(11, 10, "Dos.", 1, 0, "C");
$pdf->setfont("Arial", "B", 11);
$pdf->cell(38, 10, "Nom du Chien", 1, 0);
$pdf->cell(38, 10, "Race du chien", 1, 0);
$pdf->cell(44, 10, "Conducteur", 1, 0);
if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$largeur = 48;} else {$largeur = 63;}
$pdf->cell($largeur, 10, utf8_decode("Club / Régionale"), 1, 0);
$pdf->cell(15, 10, "Temps", 1, 0, "C");
if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$largeur = 60;} else {$largeur = 45;}
$pdf->cell($largeur, 5, utf8_decode("Pénalités"), 1, 0, "C");
$pdf->cell(0, 10, "Qual.", 1, 0, "C");
$posy = $posy + $hligne;
if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$posx = 215;} else {$posx = 230;}
$pdf->setxy($posx, $posy);
if ($_SESSION['Epreuve'] == "51" or $_SESSION['Epreuve'] == "52"){$pdf->cell(15, 5, "Ant.", 1, 0, "C");}
$pdf->cell(15, 5, ">TPS", 1, 0, "C");
$pdf->cell(15, 5, "Parc.", 1, 0, "C");
$pdf->cell(15, 5, "Total", 1, 0, "C");
?>