<?php
session_start();
include("../utilitaires/nomvars_agi.php");
// connexion bdd
include("../../communs/connexion.php");
// Choix de l'épreuve
if (isset($_POST['choixepreuve'])){
	$epreuve = $_POST['epreuve'];
	$categorie = $_POST['categorie'];
	$classe = $_POST['classe'];
	$handi = $_POST['handi'];
	if ($classe == ""){$classe = 1;}
	$_SESSION['Epreuve'] = $epreuve;
	$_SESSION['Categorie'] = $categorie;
	$_SESSION['Classe'] = $classe;
	$_SESSION['Handi'] = $handi;
	$query = "SELECT * FROM agility_epreuves WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi'";
	if (!($result = mysql_query($query))){echo mysql_error();}
	$row = mysql_fetch_assoc($result);
	$idepreuve = $row['Id'];
	$nbobstacles = $row['NbObstacles'];
	$longueur = $row['Longueur'];
	$vitesse = $row['Vitesse'];
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	$juge = $row['Juge'];
}
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
// Nombre de Concurrents par page
if ($epreuve == 11 or $epreuve == 12 or $epreuve == 15 or $epreuve == 16 or $epreuve == 19){$concurrentsparpage = 9;} else {$concurrentsparpage = 30;}
// Liste des concurrents
$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$idepreuve' AND Classement>'0' AND Resultat<>'P' AND Resultat<>'F' AND Resultat<>'' ORDER BY Classement";
$result = mysql_query($query);
$nb_resultats = mysql_num_rows($result);
if ($nb_resultats == 0){
	echo "<link href='../../communs/styles.css' rel='stylesheet' type='text/css' />
		<p class='center'><br /><br /><span class='alert'>&nbsp;Aucun résultat n'est enregistré pour cette épreuve&nbsp;</span><br />&nbsp;$nomepreuves[$epreuve] &ndash; Catégorie $nomcategories[$categorie] &ndash; $nomclasses[$classe]";
	if ($handi > 0){echo " &ndash; Handi $handi&nbsp;";}
	echo "</p>";
	exit;
}
for ($n = 1; $n <= 6; $n++){$nbresultats[$n] = "0";}
$n = 1;
include("../../communs/imp_init_l.php");
while ($row = mysql_fetch_assoc($result)){
	$classements[$n] = $row['Classement'];
	$idlicence = $row['IdLicence'];
	$licence = $row['Licence'];
	$licences[$n] = $licence;
	$dossards[$n] = $row['Dossard'];
	$tempss[$n] = $row['Temps'];
	$penalitess[$n] = $row['Penalites'];
	$depastempss[$n] = $row['Depastemps'];
	$totals[$n] = $row['Total'];
	$penalitesants[$n] = $row['PenalitesAnt'];
	$resultats[$n] = $coderesultats[$row['Resultat']];
	$brevets[$n] = $nombrevets[$row['Brevet']];
	if ($tempss[$n] > 0){$vitevs[$n] = number_format($longueur / $tempss[$n], 2);}
	$nbresultats[$resultats[$n]]++;
	if ($classements[$n] >= 9995){$classements[$n] = " ";}
	// Chien
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$nomchiens[$n] = $row1['NomChien'];
	$coderace = $row1['CodeRace'];
	$coderacevariete = $row1['CodeRaceVariete'];
	$coderace = $row1['CodeRace'];
	$noms[$n] = $row1['Nom']." ".$row1['Prenom'];
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
	$coderegionale = $row1['CodeRegionale'];
	// Décodage Régionale
	$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$clubs[$n] .= " / ".$row1['Regionale'];
	$n++;
}
// Impression
$nb_concurrents = $n - 1;
$nb_pages = ceil($nb_concurrents / $concurrentsparpage);
if ($nb_concurrents == $nb_pages * $concurrentsparpage){$nb_pages++;}
$nb_pagestotal = $nb_pages;
if ((($nb_pages * $concurrentsparpage) - $nb_concurrents) < 5){$nb_pagestotal++;}
// Impression page
for ($num_page = 1; $num_page <= $nb_pages; $num_page++){
	if ($epreuve == 11 or $epreuve == 12 or $epreuve == 15 or $epreuve == 16 or $epreuve == 19){
		include("pendantagi_resultatsimp_2_ChR.php");
	} else {
		include("pendantagi_resultatsimp_2.php");
	}
}

// Statistiques
if ($num_page == $nb_pagestotal){
	// Nouvelle page
	include("../utilitaires/imp_titre_l.php");
	// En-tête des pages
	$pdf->setfont("Arial", "B", 14);
	$pdf->setxy(10, 25);
	if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
		$texte = utf8_decode("RESULTATS - ".$nomepreuves[$epreuve]." - Catégorie ".$nomcategories[$categorie]." - Classe ".$nomclasses[$classe]);
		if ($handi > 0){$texte .= " - Handi ".$handi;}
		$pdf->cell(0, 10, $texte, 0, 0, "C");
	}
	$pdf->setfont("helvetica", "B", 10);
	$posy = 37;
	// Copyright
	include("../utilitaires/imp_copyright_l.php");
}
$pdf->setfont("helvetica", "B", 10);
$y = $posy + 10;
$pdf->setxy(10, $y);
$pdf->cell(46.16, 7, "Excellents", 1, 0, "C");
$pdf->cell(46.16, 7, utf8_decode("Très bons"), 1, 0,"C");
$pdf->cell(46.16, 7, "Bons", 1, 0,"C");
$pdf->cell(46.16, 7, utf8_decode("Non classés"), 1, 0,"C");
$pdf->cell(46.16, 7, utf8_decode("Eliminés"), 1, 0,"C");
$pdf->cell(46.16, 7, "Abandons", 1, 0,"C");
$y = $y + 7;
$pdf->setxy(10, $y);
for ($n = 1; $n <= 6; $n++){
	$pc = round($nbresultats[$n] / $nb_resultats * 10000) / 100;
	$pdf->cell(46.16, 7, $nbresultats[$n]." (".$pc." %)", 1, 0,"C");
}

$pdf->output();
?>