<?php
session_start(); 
// Nombre de Dossard par page
$dossardsparpage = 20;
// connexion bdd
include("../../communs/connexion.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
include("../utilitaires/nomvars_agi.php");
$ordre = 'Dossard';
$classement = $ordre;
// Liste des dossards


if ($_SESSION['Dossards'] == ""){
	$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_dossards_affichage.php'>Affichage pour la remise des dossards</a>";
	include("../utilitaires/bandeau_agi.php");
	echo"<p class='center'><span class='alert'>&nbsp;Les dossards n'ont pas encore été attribués&nbsp;</span></p>
	<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></td></tr></table>";
	
	exit;
	}
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
			$coderace = $row['CodeRace'];
			$categorie = $row['Categorie'];
			$handi[$n] = $nomhandis[$row['Handi']];
			$classes[$n] = $nomclasses[$row['Classe']];
			$conducteurs[$n] = $row['Nom']." ".$row['Prenom'];
			$codeclub = $row['CodeClub'];
			// Catégorie
			$categories[$n] = $nomcategories[$categorie];
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


			
			// Epreuves
			$query = "SELECT * FROM agility_resultats WHERE IdLicence='$idlicence' ORDER BY Epreuve";
			$result1 = mysql_query($query);

			$epreuves[$n] = "";
				while ($row1 = mysql_fetch_assoc($result1)){
					$epreuve = $row1['Epreuve'];
					if ($epreuve <= 8 or $epreuve == 11 or $epreuve == 12 or $epreuve == 15 or $epreuve == 16 or $epreuve == 19){
					$epreuves[$n] .= " / ".$nomepreuveabrs[$epreuve];
					}
				}
			$epreuves[$n] = substr($epreuves[$n], 2, 100);
			$n++;
		}
	}

}
$num_dossard = 1;
$num_page = 1;
$titre = "Affichage pour la remise des dossards";
$nb_pages = ceil($nb_dossards / $dossardsparpage);
include("../../communs/imp_init_p.php");
// Impression Dossards
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	include("../utilitaires/imp_titre_p.php");
	// En-tête des pages dossards
	$pdf->SetDrawColor (125);
	$pdf->SetfillColor (230);
	$pdf->setfont("Arial", "B", 11);
	$pdf->setxy(10, 40);
	$pdf->cell(10, 9.9, utf8_decode("n°"), 1, 0, "C",true);
	$pdf->setfont("Arial", "", 11);
	$pdf->cell(15, 5, "Licence", 1, 0, "C",true);
	$pdf->cell(45, 5, "Nom du Chien", 1, 0,"",true);
	$pdf->cell(40, 5, "Race du chien", 1, 0,"",true);
	$pdf->cell(10, 9.9, "Cat.", 1, 0,"",true);
	$pdf->cell(56, 5, utf8_decode("Conducteur"), 1, 0,"",true);
	$pdf->cell(14, 5, "Clas.", 1, 0,"",true);
	$pdf->setxy(20, 45);
	$pdf->setfont('Arial', "Bi", 11,"",true);
	$pdf->SetTextColor(0,0,255);
	$pdf->cell(100, 5, utf8_decode("épreuves"), 1, 0,"",true);
	$pdf->setxy(130, 45);
	$pdf->setfont('arial', "", 11);
	$pdf->SetTextColor(0,0,0);
	$pdf->cell(19.9, 5, "handi",1,0,"L", true);
	$pdf->cell(0, 5, "Club", 1, 0, "R",true);
	
	// Impression Ligne
	$num = 1 + ($num_page - 1) * $dossardsparpage;
	if ($num_page == $nb_pages){$nmax = fmod($nb_dossards - $num + 1, $dossardsparpage);} else {$nmax = $dossardsparpage;}
	if ($nmax == 0){$nmax = $dossardsparpage;}
	$hauteur = 11.5; // Hauteur d'un enregistrement (2 lignes)
	$posy = 50;
	for ($n = 1; $n <= $nmax; $n++){
		// Ligne 1
		$pdf->setxy(10, $posy );
		$pdf->setfont('arial', "B", 12);
		$pdf->cell(9.9, 11.5, $dossards[$num], 1, 0, "C");	
		$pdf->setxy(20, $posy);
		$pdf->setfont('arial', "", 10);
		$pdf->cell(15, 5, $licences[$num], 0, 0, "C");
		$pdf->setfont('arial', "B", 10);
		$nomchien = utf8_decode($nomchiens[$num]);
		while ($pdf->GetStringWidth($nomchien) > 45){
			$nomchien = substr($nomchien, 0, strlen($nomchien)-1);
		}
		$pdf->cell(45, 5, $nomchien, 0, 0);
		$pdf->setfont("", "", 8);
		$pdf->cell(43, 5, utf8_decode($races[$num]), 0, 0);
		$pdf->setxy(121, $posy );
		$pdf->setfont('arial', "", 12);
		$pdf->cell(8, 11.5, $categories[$num], 0, 0, "C");
		$pdf->setfont('arial', "B", 9);
		$pdf->setxy(131, $posy );
		$pdf->cell(60, 5, utf8_decode($conducteurs[$num]), 0, 0);
		$pdf->setfont("", "", 8);
		$pdf->cell(0, 5, $classes[$num], 0, 1, "C");

		// Ligne 2
		$pdf->setxy(20, $posy + 5);
		$epreuve = utf8_decode($epreuves[$num]);
		$pdf->setfont('Arial',"i", 12);
		$pdf->SetTextColor(0,0,255);
		$pdf->Cell(100, 6.5, $epreuve, 0, 0, "L");
		$pdf->setfont('arial', "", 8);
		$pdf->SetTextColor(0,0,0);
		$pdf->setxy(131, $posy +5);
		if (($handi[$num])<>"") {$pdf->cell(20, 5.55, "$handi[$num]", 0, 0);}
		$pdf->cell(0, 5.55, utf8_decode($clubs[$num]), 0, 0, "R");
		// Suite
	$num++;
		//Cadre
	$pdf->setxy(20, $posy);	
	$pdf->cell(0, 11.5, "", 1);
	$posy = $posy + $hauteur ;
	}


	// Copyright
	include("../utilitaires/imp_copyright_p.php");
}
$pdf->output()
?>
