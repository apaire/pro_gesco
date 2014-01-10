<?php
// initialisation page
require('../../communs/fpdf.php');
$pdf = new fpdf("P", "mm", "A4");
$pdf->SetAutoPagebreak(False);
$pdf->SetMargins(10,10,10);
$pdf->setfillcolor(135, 134, 133);
?>