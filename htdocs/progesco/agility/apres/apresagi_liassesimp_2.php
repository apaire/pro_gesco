<?php
session_start();
// connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
// Choix des liasses à imprimer
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y'";
if (isset($_GET['categorie'])){
	$categorie = $_GET['categorie'];
	$nomcategorie = $nomcategories[$categorie];
	$query .= " AND Categorie='$categorie'";
}
$query .= " ORDER BY CodeClub, Categorie, Classe, Handi";
if (!($result = mysql_query($query))){echo mysql_error();}
if (mysql_num_rows($result) == 0){
	echo "<link href='../../communs/styles.css' rel='stylesheet' type='text/css' />
		<p class='center'><br /><br /><span class='alert'>".utf8_decode("&nbsp;Il n'y a aucun concurrent pour la catégorie $nomcategories[$categorie]&nbsp;")."</p>";
	mysql_close();
	exit;
}
include("../../communs/imp_init_p.php");
$num_chien = 1;
while ($row = mysql_fetch_assoc($result)){
	$textebrevet = "";
	$idlicence = $row['Id'];
	$licence = $row['Licence'];
	$nomchien = $row['NomChien'];
	$coderace = $row['CodeRace'];
	$sexe = $row['Sexe'];
	$nom = $row['Nom']." ".$row['Prenom'];
	$codeclub = $row['CodeClub'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$nomhandi = $nomhandis[$handi];
	$nomcategorie = $nomcategories[$categorie];
	// Décodage Race
	$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$race = $row1['Race']." ".$row1['RaceVariete'];
	// Décodage Club
	$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$club = $row1['Club'];
	$coderegionale = $row1['CodeRegionale'];
	// Décodage Régionale
	$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$regionale = $row1['Regionale'];

	$query = "SELECT * FROM agility_resultats WHERE IdLicence='$idlicence' AND Resultat<>'F' AND Resultat<>'' ORDER BY Epreuve";
	if (!($result1 = mysql_query($query))){
		echo mysql_error();
		exit;
	}
	$nb_epreuves = mysql_num_rows($result1);
	if ($nb_epreuves > 0){
		$n = 1;
		while ($row = mysql_fetch_assoc($result1)){
			$idepreuve = $row['IdEpreuve'];
			$classements[$n] = $row['Classement'];
			$dossard = $row['Dossard'];
			$tempss[$n] = $row['Temps'];
			$penalitess[$n] = $row['Penalites'];
			$depastempss[$n] = $row['Depastemps'];
			$totals[$n] = $row['Total'];
			$penalitesants[$n] = $row['PenalitesAnt'];
			$resultat = $row['Resultat'];
			$brevet = $row['Brevet'];
			if ($classements[$n] == 0){$classements[$n] = "";}
			if ($classements[$n] == 9995){$classements[$n] = "NC";}
			if ($classements[$n] > 9995){$classements[$n] = "";}
			if ($resultat == "P"){
				if ($totals[$n] < 6){$resultat = "X";}
				else if ($totals[$n] < 16){$resultat = "T";}
				else if ($totals[$n] < 26){$resultat = "B";}
			}
			$qualificatifs[$n] = $nomresultatabrs[$resultat];
			// Caractéristiques de l'épreuve
			$query = "SELECT * FROM agility_epreuves WHERE Id='$idepreuve'";
			$resultepreuve = mysql_query($query);
			$row = mysql_fetch_assoc($resultepreuve);
			$epreuve = $row['Epreuve'];
			$engagess[$n] = $row['Engages'];
			$juges[$n] = $row['Juge'];
			$nbobstacless[$n] = $row['NbObstacles'];
			$longueurs[$n] = $row['Longueur'];
			$vitesses[$n] = $row['Vitesse'];
			$tpss[$n] = $row['TPS'];
			$tmps[$n]= $row['TMP'];
			$epreuves[$n] = $nomepreuves[$epreuve];
			if ($epreuve == 1 and $resultat == "X" and $totals[$n] == "0"){
				if ($brevet == 1 or $brevet == 2){$textebrevet = "Brevet partie $brevet obtenue";} else {$textebrevet = "Brevet obtenu";}
				$textebrevet .= " ce jour $date. Signature du Juge :";
			}
			if ($tempss[$n] > 0){$vitevs[$n] = number_format($longueurs[$n] / $tempss[$n], 2);} else {$vitevs[$n] = 0;}
			$n++;
		}
		// Position d'impression
		if ($num_chien == 1){ // Premier chien de la page
			// initialisation page
			$pdf->addpage();
			$pdf->line(0, 148.5, 10, 148.5);
			$pdf->line(200, 148.5, 210, 148.5);
			$ydeb = 12;
			$yfin = 138.5;
			$ybrevet = 135;
			$num_chien = 2;
		} else { // Deuxième chien de la page
			$ydeb = 156.5;
			$yfin = 287;
			$ybrevet = 280;
			$num_chien = 1;
		}
		include("apresagi_liassesimp_3.php");
	}
}
$pdf->output();
?>