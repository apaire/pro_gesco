<?php
// Impression ligne total
$y = $pdf->gety();
$pdf->line(95, $y, 200, $y);
$pdf->cell(85, 7, "", "L", 0);
for ($m = 0; $m < 7; $m++){$pdf->cell(15, 7, $nb_mentionstotals[$m], 0, 0, "C");}
$pdf->cell(0, 7, "", "R", 1);
// Impression %
$pdf->cell(85, 7, "% --> ", "L", 0, "R");
for ($m = 0; $m < 6; $m++){
	if ($nb_mentionstotals[6] > 0){$pc = round($nb_mentionstotals[$m] / $nb_mentionstotals[6] * 10000) / 100;}
	else {$pc = 0;}
	$pdf->cell(15, 7, $pc, 0, 0, "C");
}
$pdf->cell(0, 7, "", "R", 1);
$y = $pdf->gety();
$pdf->line(10, $y, 200, $y);
// Remise à zéro
for ($m = 0; $m < 7; $m++){$nb_mentionstotals[$m] = "0";}
?>