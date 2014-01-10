<?php
session_start();
$epreuvesparpage = 47;
// Mise à jour nombre d'engagés par épreuve
include("avantagi_epreuvesstats.php");
// connexion bdd
include("../../communs/connexion.php");
// Mise à jour statistiques *******************************************************
$query = "SELECT * FROM agility_epreuves ORDER BY Epreuve, Categorie, Classe, Handi";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$id = $row['Id'];
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Handi='$handi'";
	if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){$query .= " AND Classe='$classe'";}
	$result1 = mysql_query($query);
	$engages = mysql_num_rows($result1);
	$query = "UPDATE agility_epreuves SET Engages='$engages' WHERE Id='$id'";
	mysql_query($query);
}
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
include("../utilitaires/nomvars_agi.php");
$query = "SELECT * FROM agility_epreuves WHERE Engages>'0' ORDER BY Epreuve, Categorie, Classe, Handi";
$result = mysql_query($query);
$nb_epreuves = mysql_num_rows($result);
$nb_pages = ceil($nb_epreuves / $epreuvesparpage);
$titre = "LISTE DES EPREUVES";
include("../../communs/imp_init_p.php");
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	// Impression titre page
	include("../utilitaires/imp_titre_p.php");
	// En-tête de la page
	$pdf->setfont("Arial", "B", 10);
	$pdf->setxy(10, 40);
	$pdf->cell(100, 7, "EPREUVE", 1, 0);
	$pdf->cell(22, 7, "CATEGORIE", 1, 0, "C");
	$pdf->cell(22, 7, "CLASSE", 1, 0, "C");
	$pdf->cell(22, 7, "HANDI", 1, 0, "C");
	$pdf->cell(0, 7, "NB CONCUR.", 1, 0, "C");
	// Impression Ligne
	$hauteur = 5; // Hauteur d'un enregistrement (1 lignes)
	$posy = 47;
	$numligne = 1;
	$num_page = 1;
	while ($row = mysql_fetch_assoc($result)){
		$epreuve = $row['Epreuve'];
		if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
			$categorie = $row['Categorie'];
			$classe = $row['Classe'];
			$handi = $row['Handi'];
			$engages = $row['Engages'];
			$nomepreuve = $nomepreuves[$epreuve];
			$nomcategorie = $nomcategories[$categorie];
			$nomclasse = $nomclasses[$classe];
			$nomhandi = $nomhandis[$handi];
			if ($numligne > $epreuvesparpage){ // Nouvelle page
				include("../utilitaires/imp_copyright_p.php");
				include("../utilitaires/imp_titre_p.php");
				$pdf->setfont("Arial", "B", 10);
				$pdf->setxy(10, 40);
				$pdf->cell(100, 7, "EPREUVE", 1, 0);
				$pdf->cell(22, 7, "CATEGORIE", 1, 0, "C");
				$pdf->cell(22, 7, "CLASSE", 1, 0, "C");
				$pdf->cell(22, 7, "HANDI", 1, 0, "C");
				$pdf->cell(0, 7, "NB CONCUR.", 1, 0, "C");
				$posy = 47;
				$numligne = 1;
				$num_page++;
			}
			$pdf->setxy(10, $posy);
			$pdf->setfont("", "", 10);
			$pdf->cell(100, 5, utf8_decode($nomepreuve), 0, 0);
			$pdf->cell(22, 5, $nomcategorie, 0, 0, "C");
			$pdf->cell(22, 5, $nomclasse, 0, 0, "C");
			$pdf->cell(22, 5, $nomhandi, 0, 0, "C");
			$pdf->cell(0, 5, $engages, 0, 0, "C");
			// Cadre
			$pdf->setxy(10, $posy);
			$pdf->cell(0, 5, "", 1, 0);
			// Suite
			$posy = $posy + $hauteur;
			$numligne++;
		}
	}
	// Copyright
	include("../utilitaires/imp_copyright_p.php");
}
$pdf->output();
?>