<?php
session_start(); 
// Nombre de Concurrents par page
$concurrentsparpage = 6;
// connexion bdd
include("../../communs/connexion.php");
include("../../communs/imp_init_p.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
include("../utilitaires/nomvars_agi.php");
// Liste des concurrents
for ($epreuve = 11; $epreuve <= 15; $epreuve = $epreuve + 4){
	$nomepreuve = $nomepreuves[$epreuve];
	for ($handi = 0; $handi <= 5; $handi++){
		$nomhandi = $nomhandis[$handi];
		for ($categorie = 1; $categorie <= 4; $categorie++){
			$nomcategorie = $nomcategories[$categorie];
			for ($classe = 1; $classe <= 3; $classe++){
				$num = 1;
				$nomclasse = $nomclasses[$classe];
				$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' ORDER BY Licence";
				$result = mysql_query($query);
				$nb_concurrents = mysql_num_rows($result);
				if ($nb_concurrents == 0){continue;}
				$num_page_preced = 1;
				$titre = "LISTE DES PENALITES ANTERIEURES SAISIES";
				$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
				include("avantagi_penalantsimp_1.php");
				$posy = 70;
				while ($row = mysql_fetch_assoc($result)){
					$idlicence = $row['IdLicence'];
					$licence = $row['Licence'];
					// Lecture chien
					$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
					$result1 = mysql_query($query);
					$row = mysql_fetch_assoc($result1);
					$nomchien = $row['NomChien'];
					$conducteur = $row['Titre']." ".$row['Nom']." ".$row['Prenom'];
					$totalpenalites = "0.00";
					// Lecture pénalites
					$query = "SELECT * FROM agility_penalants WHERE IdLicence='$idlicence'ORDER BY Date";
					$result1 = mysql_query($query);
					$n = 1;
					while ($row = mysql_fetch_assoc($result1)){
						$date = $row['Date'];
						$juges[$n] = $row['Juge'];
						$penalites[$n] = $row['Penalites'];
						$tempos = explode("-", $date);
						$dates[$n] = $tempos[2]."/".$tempos[1]."/".$tempos[0];
						$n++;
					} 
					// Lecture pénalités totales
					$query = "SELECT PenalitesAnt FROM agility_resultats WHERE IdLicence='$idlicence'";
					$result1 = mysql_query($query);
					$row = mysql_fetch_assoc($result1);
					$totalpenalites = $row['PenalitesAnt'];
					include("avantagi_penalantsimp_2.php");
					$num++;
				}
				if ($nb_concurrents > 0){
					$num_page = $num_page_preced;
					include("../utilitaires/imp_copyright_p.php");
				}
			}
		}
	}
}
$pdf->output()
?>