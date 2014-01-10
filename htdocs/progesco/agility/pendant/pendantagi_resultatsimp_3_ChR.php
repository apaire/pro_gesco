<?php
// Impression manches
$query = "SELECT * FROM agility_resultats WHERE Dossard='$dossard' AND Epreuve='$epreuveimp'";
$resultmanche = mysql_query($query);
$rowmanche = mysql_fetch_assoc($resultmanche);
$temps = $rowmanche['Temps'];
$penalites = $rowmanche['Penalites'];
$depastemps = $rowmanche['Depastemps'];
$total = $rowmanche['Total'];
$classement = $rowmanche['Classement'];
$resultat = $rowmanche['Resultat'];
if ($classement >= 9995){$classement = " ";}
// Impression ligne
$posy = $posy + 5;
$pdf->setxy(10, $posy);
$pdf->cell(11, 5, $classement, 0, 0, "C");
if ($epreuve == 11){$posx = "131";} else {$posx = "152";}
$pdf->setxy($posx, $posy);
$pdf->setfont("", "", 10);
$pdf->cell(63, 5, $manche, 0, 0, "L");
$pdf->cell(15, 5, $temps, 0, 0, "C");
if ($epreuve == 11){$pdf->cell(15, 5, "", 0, 0);}
$pdf->cell(15, 5, $depastemps, 0, 0, "C");
$pdf->cell(15, 5, $penalites, 0, 0, "C");
$pdf->cell(15, 5, $total, 0, 0, "C");
$pdf->cell(0, 5, $nomresultatabrs[$resultat], 0, 0, "C");
?>