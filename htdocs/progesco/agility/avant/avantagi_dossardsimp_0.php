<?php
session_start(); 
// Nombre de Dossard par page
$dossardsparpage = 23;
// connexion bdd
include("../../communs/connexion.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
include("../utilitaires/nomvars_agi.php");
$ordre = $_GET['ordre'];
$classement = $ordre;
if ($ordre == "Club"){$classement = "CodeClub, Licence";}
if ($ordre == "Race"){$classement = "CodeRace";}
// Liste des dossards
if ($ordre == 'Dossard'){
	$query = "SELECT * FROM agility_resultats ORDER BY Dossard";
	$result = mysql_query($query);
	$n = 1;
	$dossard_preced = "";
	while ($row = mysql_fetch_assoc($result)){
		$dossards[$n] = $row['Dossard'];
		if ($dossards[$n] != $dossard_preced){
			$idlicence = $row['IdLicence'];
			$licence = $row['Licence'];
			$licences[$n] = $licence;
			// Licence
			$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$nomchiens[$n] = $row['NomChien'];
			$sexes[$n] = $row['Sexe'];
			$coderace = $row['CodeRace'];
			$tatouage = $row['Tatouage'];
			$puce = $row['Puce'];
			$categorie = $row['Categorie'];
			$classes[$n] = $nomclasses[$row['Classe']];
			$conducteurs[$n] = $row['Nom']." ".$row['Prenom'];
			$codeclub = $row['CodeClub'];
			// Catégorie
			$categories[$n] = $nomcategories[$categorie];
			// Identification
			if ($tatouage != ""){$idents[$n] = $tatouage;} else {$idents[$n] = $puce;}
			// Décodage Race
			$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$races[$n] = $row1['Race'];
			// Décodage Club
			$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$clubs[$n] = $row1['Club'];
			$dossard_preced = $dossards[$n];
			$nb_dossards = $n;
			$n++;
		}
	}
} else {
	$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY $classement";
	$result = mysql_query($query);
	$nb_dossards = mysql_num_rows($result);
	$n = 1;
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['Id'];
		$licence = $row['Licence'];
		$licences[$n] = $licence;
		$nomchiens[$n] = $row['NomChien'];
		$sexes[$n] = $row['Sexe'];
		$coderace = $row['CodeRace'];
		$tatouage = $row['Tatouage'];
		$puce = $row['Puce'];
		$categorie = $row['Categorie'];
		$classes[$n] = $nomclasses[$row['Classe']];
		$conducteurs[$n] = $row['Nom']." ".$row['Prenom'];
		$codeclub = $row['CodeClub'];
		// Dossard
		$query = "SELECT Dossard FROM agility_resultats WHERE IdLicence='$idlicence' LIMIT 1";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$dossards[$n] = $row['Dossard'];
		// Catégorie
		$categories[$n] = $nomcategories[$categorie];
		// Identification
		if ($tatouage != ""){$idents[$n] = $tatouage;} else {$idents[$n] = $puce;}
		// Décodage Race
		$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
		$result1 = mysql_query($query);
		$row1 = mysql_fetch_assoc($result1);
		$races[$n] = $row1['Race'];
		// Décodage Club
		$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result1 = mysql_query($query);
		$row1 = mysql_fetch_assoc($result1);
		$clubs[$n] = $row1['Club'];
		$n++;
	}
}
$num_dossard = 1;
$num_page = 1;
$titre = "LISTE DES DOSSARDS classés par $ordre";
$nb_pages = ceil($nb_dossards / $dossardsparpage);
include("../../communs/imp_init_p.php");
// Impression Dossards
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	include("../utilitaires/imp_titre_p.php");
	// En-tête des pages dossards
	$pdf->setfont("Arial", "B", 11);
	$pdf->setxy(10, 40);
	$pdf->cell(22, 5, utf8_decode("N° Dossard"), 1, 0, "C");
	$pdf->cell(18, 5, "Licence", 1, 0, "C");
	$pdf->cell(45, 5, "Nom du Chien", 1, 0);
	$pdf->cell(10, 5, "M/F", 1, 0, "C");
	$pdf->cell(55, 5, "Race du chien", 1, 0);
	$pdf->cell(30, 5, "Identification", 1, 0);
	$pdf->cell(0, 5, "Cat.", 1, 0);

	$pdf->setxy(50, 45);
	$pdf->cell(75, 5, utf8_decode("NOM et Prénom du Conducteur"), 1, 0);
	$pdf->cell(65, 5, "Club", 1, 0);
	$pdf->cell(0, 5, "Clas.", 1, 1);
	// Impression Ligne
	$num = 1 + ($num_page - 1) * $dossardsparpage;
	if ($num_page == $nb_pages){$nmax = fmod($nb_dossards - $num + 1, $dossardsparpage);} else {$nmax = $dossardsparpage;}
	if ($nmax == 0){$nmax = $dossardsparpage;}
	$hauteur = 10; // Hauteur d'un enregistrement (2 lignes)
	$posy = 50;
	for ($n = 1; $n <= $nmax; $n++){
		// Ligne 1
		$pdf->setxy(10, $posy);
		$pdf->setfont("", "", 10);
		$pdf->cell(22, 5, $dossards[$num], 0, 0, "C");
		$pdf->cell(18, 5, $licences[$num], 0, 0, "C");
		$nomchien = utf8_decode($nomchiens[$num]);
		while ($pdf->GetStringWidth($nomchien) > 44){
			$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
		}
		$pdf->cell(45, 5, $nomchien, 0, 0);
		$pdf->setfont("", "", 8);
		$pdf->cell(10, 5, $sexes[$num], 0, 0, "C");
		$pdf->cell(55, 5, utf8_decode($races[$num]), 0, 0);
		$pdf->cell(30, 5, $idents[$num], 0, 0);
		$pdf->cell(0, 5, $categories[$num], 0, 1);
		// Ligne 2
		$pdf->setxy(50, $posy + 5);
		$pdf->cell(75, 5, utf8_decode($conducteurs[$num]), 0, 0);
		$pdf->cell(60, 5, utf8_decode($clubs[$num]), 0, 0);
		$pdf->cell(0, 5, $classes[$num], 0, 1, "R");
		// Cadre
		$pdf->setxy(10, $posy);
		$pdf->cell(0, 10, "", 1);
		// Suite
		$num++;
		$posy = $posy + $hauteur;
	}
	// Copyright
	include("../utilitaires/imp_copyright_p.php");
}
$pdf->output()
?>