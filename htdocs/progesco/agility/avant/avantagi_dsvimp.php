<?php
session_start(); 
// Nombre de chiens par page
$chiensparpage = 15;
// connexion bdd
include("../../communs/connexion.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
// Liste des dossards
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY NomChien";
$result = mysql_query($query);
$nb_chiens = mysql_num_rows($result);
$n = 1;
$titre = "LISTE DES CHIENS POUR LES SERVICES VETERINAIRES";
while ($row = mysql_fetch_assoc($result)){
	$licences[$n] = $row['Licence'];
	$nomchiens[$n] = $row['NomChien'];
	$coderace = $row['CodeRace'];
	$conducteurs[$n] = $row['Nom']." ".$row['Prenom'];
	$adresses[$n] = $row['Adresse1'];
	$adresse2 = $row['Adresse2'];
	if ($adresse2 != ""){$adresses[$n] .= " / ".$adresse2;}
	$cps[$n] = $row['CP'];
	$villes[$n] = $row['Ville'];
	$tatouage = $row['Tatouage'];
	$puce = $row['Puce'];
	if ($puce != ""){$idents[$n] = $puce;} else {$idents[$n] = $tatouage;}
	// Décodage Race
	$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$races[$n] = $row1['Race'];
	$n++;
}

$num_dossard = 1;
$num_page = 1;
$titre = "LISTE DES CHIENS POUR LES SERVICES VETERINAIRES ($nb_chiens chiens)";
$nb_pages = ceil($nb_chiens / $chiensparpage);
include("../../communs/imp_init_l.php");
// Impression Chiens
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	include("../utilitaires/imp_titre_l.php");
	// En-tête des pages DV
	$pdf->setfont("Arial", "B", 10);
	$pdf->setfont("Arial", "B", 10);
	$pdf->setxy(10, 38);
	$pdf->cell(80, 5, "Nom du chien", 1, 0);
	$pdf->cell(110, 5, "Race", 1, 0);
	$pdf->cell(45, 5, "Identification", 1, 0);
	$pdf->cell(0, 5, "Licence", 1, 0);
	$pdf->setxy(10, 43);
	$pdf->cell(80, 5, "Conducteur", 1, 0);
	$pdf->cell(0, 5, "Adresse", 1, 0);
	// Impression Ligne
	$num = 1 + ($num_page - 1) * $chiensparpage;
	if ($num_page == $nb_pages){$nmax = fmod($nb_chiens - $num + 1, $chiensparpage);} else {$nmax = $chiensparpage;}
	$hauteur = 10; // Hauteur d'un enregistrement (2 lignes)
	$posy = 48;
	for ($n = 1; $n <= $nmax; $n++){
		// Ligne 1
		$pdf->setxy(10, $posy);
		$pdf->setfont("", "", 10);
		$nomchien = utf8_decode($nomchiens[$num]);
		while ($pdf->GetStringWidth($nomchien) > 109){$nomchien = substr($nomchien, 0, strlen($nomchien)-1);}
		$pdf->cell(80, 5, $nomchien, 0, 0);
		$race = utf8_decode($races[$num]);
		while ($pdf->GetStringWidth($race) > 109){$race = substr($race, 0, strlen($race)-1);}
		$pdf->cell(110, 5, $race, 0, 0);
		$pdf->cell(45, 5, $idents[$num], 0, 0);
		$pdf->cell(0, 5, $licences[$num], 0, 0);
		$pdf->setxy(10, $posy+5);
		$conducteur = utf8_decode($conducteurs[$num]);
		while ($pdf->GetStringWidth($conducteur) > 79){$conducteur = substr($conducteur, 0, strlen($conducteur)-1);}
		$pdf->cell(80, 5, $conducteur, 0, 0);
		$adresse = utf8_decode($adresses[$num]." - ".$cps[$num]." ".$villes[$num]);
		while ($pdf->GetStringWidth($adresse) > 109){$adresse = substr($adresse, 0, strlen($adresse)-1);}
		$pdf->cell(0, 5, $adresse, 0, 0);
		// Cadre
		$pdf->setxy(10, $posy);
		$pdf->cell(0, 10, "", 1);
		// Suite
		$num++;
		$posy = $posy + $hauteur;
	}
	// Copyright
	include("../utilitaires/imp_copyright_l.php");
}
$pdf->output();
?>