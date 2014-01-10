<?php
session_start();
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
// Connexion bdd
include("../../communs/connexion.php");
// Chargement Cumul
$idcumul = $_GET['idcumul'];
// Calculs du cumul
include("pendantagi_cumulscalcul.php");

// Impression
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
// Nombre de Concurrents par page
$concurrentsparpage = 30;
// Initialisation impression
include("../../communs/imp_init_l.php");
// Liste des concurrents
for ($handi = 0; $handi <= 5; $handi++){
	for ($classe = 1; $classe <= 3; $classe++){
		if ($epreuves{49} == "N"){ // Catégories séparées
			for ($categorie = 1; $categorie <= 4; $categorie++){
				$query = "SELECT * FROM agility_resultatscumuls WHERE Idcumul='$idcumul' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Classement";
				$result = mysql_query($query);
				$nb_concurrents = mysql_num_rows($result);
				if ($nb_concurrents == 0){continue;}
				for ($n = 1; $n <= $nb_concurrents; $n++){
					$row = mysql_fetch_assoc($result);
					$licences[$n] = $row['Licence'];
					$idlicence = $row['IdLicence'];
					$dossards[$n] = $row['Dossard'];
					$tempss[$n] = $row['Temps'];
					$fautess[$n] = $row['Fautes'];
					$refuss[$n] = $row['Refus'];
					$penalitess[$n] = $row['Penalites'];
					$depastempss[$n] = $row['Depastemps'];
					$totals[$n] = $row['Total'];
					$classements[$n] = $row['Classement'];
					$resultats[$n] = $row['Resultat'];
					$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$nomchiens[$n] = $row1['NomChien'];
					$coderace = $row1['CodeRace'];
					$noms[$n] = $row1['Nom']." ".$row1['Prenom'];
					$codeclub = $row1['CodeClub'];
					$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$races[$n] = $row1['Race'];
					$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$clubs[$n] = $row1['Club'];
					$coderegionale = $row1['CodeRegionale'];
					$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$clubs[$n] .= " / ".$row1['Regionale'];
				}
				$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
				// Impression page
				for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
					include("pendantagi_cumulsimp_2.php");
				}
			}
		} else { // Toutes catégories confondues
			$query = "SELECT * FROM agility_resultatscumuls WHERE Idcumul='$idcumul' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Classement";
			$result = mysql_query($query);
			$nb_concurrents = mysql_num_rows($result);
			if ($nb_concurrents == 0){continue;}
			for ($n = 1; $n <= $nb_concurrents; $n++){
				$row = mysql_fetch_assoc($result);
				$licences[$n] = $row['Licence'];
				$idlicence = $row['IdLicence'];
				$dossards[$n] = $row['Dossard'];
				$tempss[$n] = $row['Temps'];
				$fautess[$n] = $row['Fautes'];
				$refuss[$n] = $row['Refus'];
				$penalitess[$n] = $row['Penalites'];
				$depastempss[$n] = $row['Depastemps'];
				$totals[$n] = $row['Total'];
				$classements[$n] = $row['Classement'];
				$resultats[$n] = $row['Resultat'];
				$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$nomchiens[$n] = $row1['NomChien'];
				$coderace = $row1['CodeRace'];
				$noms[$n] = $row1['Nom']." ".$row1['Prenom'];
				$codeclub = $row1['CodeClub'];
				$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$races[$n] = $row1['Race'];
				$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$clubs[$n] = $row1['Club'];
				$coderegionale = $row1['CodeRegionale'];
				$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$clubs[$n] .= " / ".$row1['Regionale'];
			}
			$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
			// Impression page
			for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
				include("pendantagi_cumulsimp_2.php");
			}
		}
	}
}
$pdf->output();
mysql_close();
?>