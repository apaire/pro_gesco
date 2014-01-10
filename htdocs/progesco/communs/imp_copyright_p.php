<?php
// Copyright
$pdf->setfont("", "", 6);
$pdf->setXY(10, 287);
$pdf->cell(100, 0, "PROGESCO Version ".$_SESSION['Version'].".".$_SESSION['SousVersion'], 0, 0);
?>