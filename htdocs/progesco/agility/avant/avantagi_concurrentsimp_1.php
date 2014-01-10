<?php
session_start(); 
// Nombre de Concurrents par page
if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
	$concurrentsparpage = 15;
	$hauteur = 15;
} else {
	$concurrentsparpage = 22;
	$hauteur = 10;
}
// connexion bdd
include("../../communs/connexion.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
include("../utilitaires/nomvars_agi.php");
// Ordre d'affichage
$ordre = $_GET['ordre'];
// Liste des dossards
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY $ordre";
$result = mysql_query($query);
$nb_concurrents = mysql_num_rows($result);
$n = 1;
while ($row = mysql_fetch_assoc($result)){
	$idlicences[$n] = $row['Id'];
	$licences[$n] = $row['Licence'];
	$nomchiens[$n] = $row['NomChien'];
	$affixe = $row['Affixe'];
	$coderace = $row['CodeRace'];
	$tatouage = $row['Tatouage'];
	$puce = $row['Puce'];
	$lofs[$n] = $row['LOF'];
	$categorie = $row['Categorie'];
	$classes[$n] = $row['Classe'];
	$conducteurs[$n] = $row['Nom']." ".$row['Prenom'];
	$handis[$n] = $row['Handi'];
	$codeclub = $row['CodeClub'];
	$nomchiens[$n] .= " ".$affixe;
	// Identification
	if ($puce != ""){$idents[$n] = $puce;} else {$idents[$n] = $tatouage;}
	// Décodage Catégorie, Classe
	$categories[$n] = $nomcategories[$categorie];
	$classes[$n] = $nomclasses[$classes[$n]];
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
	$coderegionale = $row1['CodeRegionale'];
	// Décodage Régionale
	$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$clubs[$n] .= " / ".$row1['Regionale'];
	// Etranger
	if ($licences[$n] >= "90000"){$etrangers[$n] = "Y";} else {$etrangers[$n] = "N";} 
	// Epreuves
	$idlicence = $idlicences[$n];
	$query = "SELECT * FROM agility_resultats WHERE IdLicence='$idlicence' ORDER BY Epreuve";
	$result1 = mysql_query($query);
	$epreuves[$n] = "";
	while ($row1 = mysql_fetch_assoc($result1)){
		$epreuve = $row1['Epreuve'];
		if ($epreuve <= 8 or $epreuve == 11 or $epreuve == 12 or $epreuve == 15 or $epreuve == 16 or $epreuve == 19){
			$epreuves[$n] .= " / ".$nomepreuveabrs[$epreuve];
		}
	}
	$epreuves[$n] = substr($epreuves[$n], 3);
	$n++;
}
if ($ordre == "CodeClub"){$ordre = "Club";}
if ($ordre == "CodeRace"){$ordre = "Race";}
$num_page = 1;
$titre = "LISTE DE CONTROLE DES CONCURRENTS ENTRES";
$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
include("../../communs/imp_init_p.php");
// Impression Concurrents
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	include("../utilitaires/imp_titre_p.php");
	// En-tête des pages
	$pdf->setfont("Arial", "B", 11);
	$pdf->setxy(10, 35);
	$pdf->cell(0, 7, utf8_decode("Classés par $ordre ($nb_concurrents concurrents)"), 0, 0, "C");
	if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
		$pdf->setxy(10, 45);
		$pdf->cell(18, 5, "Licence", 1, 0, "C");
		$pdf->cell(60, 5, "Nom du Chien", 1, 0);
		$pdf->cell(40, 5, "Race du chien", 1, 0);
		$pdf->cell(35, 5, "Identification", 1, 0);
		$pdf->cell(30, 5, "LOF", 1, 0);
		$pdf->cell(0, 5, "Cat.", 1, 0, "C");
		$pdf->setxy(28, 50);
		$pdf->cell(75, 5, utf8_decode("NOM et Prénom du Conducteur"), 1, 0);
		$pdf->cell(10, 5, "Clas.", 1, 0);
		$pdf->cell(80, 5, utf8_decode("Club / Régionale"), 1, 0);
		$pdf->cell(0, 5, "Etr.", 1, 0, "C");
		$pdf->setxy(28, 55);
		$pdf->cell(0, 5, "EPREUVES", 1, 0);
	} else {
		$pdf->setxy(10, 45);
		$pdf->cell(18, 5, "Licence", 1, 0, "C");
		$pdf->cell(60, 5, "Nom du Chien", 1, 0);
		$pdf->cell(40, 5, "Race du chien", 1, 0);
		$pdf->cell(35, 5, "Identification", 1, 0);
		$pdf->cell(30, 5, "LOF", 1, 0);
		$pdf->cell(0, 5, "Cat.", 1, 0, "C");
		$pdf->setxy(28, 50);
		$pdf->cell(80, 5, utf8_decode("NOM et Prénom du Conducteur"), 1, 0);
		$pdf->cell(85, 5, utf8_decode("Club / Régionale"), 1, 0);
		$pdf->cell(0, 5, "Han.", 1, 0, "C");
	}
	// Impression Ligne
	$num = 1 + ($num_page - 1) * $concurrentsparpage;
	if ($num_page == $nb_pages){$nmax = fmod($nb_concurrents - $num + 1, $concurrentsparpage);} else {$nmax = $concurrentsparpage;}
	if ($nmax == 0){$nmax = $concurrentsparpage;}
//	$hauteur = 15; // Hauteur d'un enregistrement
	$posy = 60;
	for ($n = 1; $n <= $nmax; $n++){
		// Ligne 1
		$pdf->setxy(10, $posy);
		$pdf->setfont("", "", 10);
		$pdf->cell(18, 5, $licences[$num], 0, 0, "C");
		$nomchien = utf8_decode($nomchiens[$num]);
		while ($pdf->GetStringWidth($nomchien) > 59){
			$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
		}
		$pdf->cell(60, 5, $nomchien, 0, 0);
		$pdf->setfont("", "", 8);
		$race = utf8_decode($races[$num]);
		while ($pdf->GetStringWidth($race) > 39){
			$race = substr($race, 0, strlen($race)-1);
		}
		$pdf->cell(40, 5, $race, 0, 0);
		$pdf->cell(35, 5, $idents[$num], 0, 0);
		$pdf->cell(30, 5, $lofs[$num], 0, 0);
		$pdf->cell(0, 5, $categories[$num], 0, 0);
		if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
			// Ligne 2
			$pdf->setxy(28, $posy + 5);
			$conducteur = utf8_decode($conducteurs[$num]);
			while ($pdf->GetStringWidth($conducteur) > 75){
				$conducteur = substr($conducteur, 0, strlen($conducteur)-1);
			}
			$pdf->cell(75, 5, $conducteur, 0, 0);
			$pdf->cell(10, 5, $classes[$num], 0, 0, "C");
			$club = utf8_decode($clubs[$num]);
			while ($pdf->GetStringWidth($club) > 80){
				$club = substr($club, 0, strlen($club)-1);
			}
			$pdf->cell(80, 5, $club, 0, 0);
			$pdf->cell(0, 5, $etrangers[$num], 0, 0, "R");
			// Ligne 3
			$pdf->setxy(28, $posy + 10);
			$epreuve = utf8_decode($epreuves[$num]);
			while ($pdf->GetStringWidth($epreuve) > 150){
				$epreuve = substr($epreuve, 0, strlen($epreuve)-1);
			}
			$pdf->cell(150, 5, $epreuve, 0, 0);
			if($handis[$n] > 0){
				$pdf->setx(159);
				$handi = "Handi ".$nomhandis[$handis[$n]];
				$pdf->cell(40, 5, $handi, 0, 0, "R");
			}
			// Cadre
			$pdf->setxy(10, $posy);
			$pdf->cell(0, 15, "", 1);
		} else {
			// Ligne 2
			$pdf->setxy(28, $posy + 5);
			$conducteur = utf8_decode($conducteurs[$num]);
			while ($pdf->GetStringWidth($conducteur) > 80){
				$conducteur = substr($conducteur, 0, strlen($conducteur)-1);
			}
			$pdf->cell(80, 5, $conducteur, 0, 0);
			$club = utf8_decode($clubs[$num]);
			while ($pdf->GetStringWidth($club) > 85){
				$club = substr($club, 0, strlen($club)-1);
			}
			$pdf->cell(85, 5, $club, 0, 0);
			$pdf->cell(0, 5, $nomhandis[$handis[$n]], 0, 0, "R");
			// Cadre
			$pdf->setxy(10, $posy);
			$pdf->cell(0, 10, "", 1);
		}
		// Suite
		$num++;
		$posy = $posy + $hauteur;
	}
	// Copyright
	include("../utilitaires/imp_copyright_p.php");
}
$pdf->output()
?>