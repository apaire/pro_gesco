<?php
session_start();
// Nombre de chiens par page
$concurrentsparpage = 45;
// connexion bdd
include("../../communs/connexion.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
include("../utilitaires/nomvars_agi.php");
$ordre = $_GET['ordre'];
if (isset($_GET['epreuve'])){$_SESSION['Epreuve'] = $_GET['epreuve'];}
$epreuve = $_SESSION['Epreuve'];
// Liste des dossards
$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' ORDER BY Categorie, Classe, Handi, $ordre";
$result = mysql_query($query);
$nb_concurrents = mysql_num_rows($result);
if ($nb_concurrents == 0){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<link href='../../communs/styles.css' rel='stylesheet' type='text/css' />
	<p>&nbsp;</p><p class='center'><span class='alert'>&nbsp;Il n'y a aucun concurrent inscrit à cette épreuve&nbsp;</span></p>";
	exit;
}
$n = 1;
$categorie_preced = "";
$classe_preced = "";
$handi_preced = "";
//include("../../communs/imp_init_p.php");
$titre = "ORDRES DE PASSAGE";
if ($ordre == "Dossard"){$titre .= " classés par N° de dossard";}
if ($ordre == "OrdrePassage"){$titre .= " classés par ordre de passage";}
while ($row = mysql_fetch_assoc($result)){
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
		if (($categorie != $categorie_preced) or ($classe != $classe_preced) or ($handi != $handi_preced)){
			if ($categorie_preced != ""){ // Impression
				$nb_concurrents = $n - 1;
				$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
				// Impression Epreuves
				for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
					include("avantagi_passagesimp_2.php");
				}
			}
			$categorie_preced = $categorie;
			$classe_preced = $classe;
			$handi_preced = $handi;
			$n = 1;
		}
	} else {
		if (($categorie != $categorie_preced) or ($handi != $handi_preced)){
			if ($categorie_preced != ""){ // Impression
				$nb_concurrents = $n - 1;
				$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
				// Impression Epreuves
				for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
					include("avantagi_passagesimp_2.php");
				}
			}
			$categorie_preced = $categorie;
			$handi_preced = $handi;
			$n = 1;
		}
	}
	$dossards[$n] = $row['Dossard'];
	$licence = $row['Licence'];
	$licences[$n] = $licence;
	$ordrepassages[$n] = $row['OrdrePassage'];
	$query = "SELECT * FROM cneac_licences WHERE Licence='$licence'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$nomchiens[$n] = $row1['NomChien'];
	$coderace = $row1['CodeRace'];
	$conducteurs[$n] = $row1['Nom']." ".$row1['Prenom'];
	$codeclub = $row1['CodeClub'];
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
// Impression dernière page
$nb_concurrents = $n - 1;
$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
// Impression page
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	include("avantagi_passagesimp_2.php");
}
//$pdf->output();
?>