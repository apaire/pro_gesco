<?php
session_start();
// connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
include("../../communs/imp_init_p.php");
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
$basdepage = 270;
// Statistique des clubs
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY CodeClub";
$result = mysql_query($query);
$codeclub_preced = "";
$n = 0;
$nb_chien = 0;
$nb_chienstotal = 0;
while ($row = mysql_fetch_assoc($result)){
	$codeclub = $row['CodeClub'];
	if ($codeclub <> $codeclub_preced){
		if (codeclub_preced <> ""){
			$nb_chiens[$n] = $nb_chien;
			$nb_chienstotal = $nb_chienstotal + $nb_chien;
			$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub_preced'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$clubs[$n] = $row1['Club'];
			$coderegionale = $row1['CodeRegionale'];
			$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$regionales[$n] = $row1['Regionale'];
			$nb_chien = 0;
			$n++;
		}
		$codeclub_preced = $codeclub;
	}
	$licence = $row['Licence'];
	$query = "SELECT Id FROM agility_resultats WHERE Licence='$licence' AND Resultat<>''";
	$result1 = mysql_query($query);
	if (mysql_num_rows($result1) > 0){$nb_chien++;}
}
// Dernier club
$nb_chiens[$n] = $nb_chien;
$nb_chienstotal = $nb_chienstotal + $nb_chien;
$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub_preced'";
$result1 = mysql_query($query);
$row1 = mysql_fetch_assoc($result1);
$clubs[$n] = $row1['Club'];
$coderegionale = $row1['CodeRegionale'];
$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
$result1 = mysql_query($query);
$row1 = mysql_fetch_assoc($result1);
$regionales[$n] = $row1['Regionale'];
$nb_clubs = $n;
// Impression page
$titre = "LISTE DES CLUBS REPRESENTES";
include("../utilitaires/agi_imp_titrestats.php");
// Entête tableau
$pdf->setxy(10, $y);
$pdf->cell(70, 7, "Nom du Club", 1, 0, "C");
$pdf->cell(70, 7, utf8_decode("Régionale"), 1, 0, "C");
$pdf->cell(25, 7, "Nb de chiens", 1, 0, "C");
$pdf->cell(0, 7, "%", 1, 1, "C");
// Lignes tableau
for ($n = 1; $n <= $nb_clubs; $n++){
	$pdf->cell(70, 5, $clubs[$n], "L", 0);
	$pdf->cell(70, 5, $regionales[$n], 0, 0);
	$pdf->cell(25, 5, $nb_chiens[$n], 0, 0, "C");
	$pc = round($nb_chiens[$n] / $nb_chienstotal * 10000) / 100;
	$pdf->cell(0, 5, $pc, "R", 1, "C");
}
$y = $pdf->gety();
$pdf->line(10, $y, 200, $y);
// Suite
$y = $y + 5;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(70, 7, utf8_decode("Nombre de chiens présents :"), 0, 0);
$pdf->cell(5, 7, $nb_chienstotal, 0, 1, "R");
include("apresagi_statspassages.php");
$y = $y + 10;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(70, 7, utf8_decode("Nombre d'épreuves :"), 0, 0);
for ($c = 1; $c <= 3; $c++){
	$pdf->cell(5, 5, $nb_epreuves[$c], 0, 0, "R");
	$nomclasse = $nomclasses[$c];
	if ($nb_epreuves[$c] > 1){$nomclasse .= "s";}
	$pdf->cell(10, 5, $nomclasse, 0, 0, "L");
	$y = $y + 5;
	$pdf->setxy(80, $y);
}
// Passages
$y = $y + 5;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(70, 7, "Nombre de passages :", 0, 0);
$pdf->cell(5, 7, $nb_passages, 0, 0, "R");
// Brevets
$y = $y + 10;
$pdf->setxy(10, $y);
$pdf->cell(30, 7, "Brevets :", 0, 0);
$pdf->cell(40, 7, utf8_decode("1ère partie :"), 0, 0);
$pdf->cell(5, 7, $nb_brevets[1], 0, 0, "R");
$y = $y + $hligne;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(40, $y);
$pdf->cell(40, 7, utf8_decode("2ème partie :"), 0, 0);
$pdf->cell(5, 7, $nb_brevets[2], 0, 0, "R");
$y = $y + $hligne;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(40, $y);
$pdf->cell(40, 7, utf8_decode("3ème partie :"), 0, 0);
$pdf->cell(5, 7, $nb_brevets[3], 0, 0, "R");
// Liste des brevets
$query = "SELECT * FROM agility_resultats WHERE Epreuve='1' AND Brevet='3'";
$result = mysql_query($query);
$nb_brevets = mysql_num_rows($result);
if ($nb_brevets > 0){
	$y = $y + 5;
	if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
	$pdf->setxy(40, $y);
	$pdf->cell(20, 7, "Licence", 0, 0);
	$pdf->cell(60, 7, "Chien", 0, 0);
	$pdf->cell(30, 7, utf8_decode("Catégorie"), 0, 0, "C");
	$pdf->cell(40, 7, "Conducteur", 0, 0);
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['IdLicence'];
		$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
		$result1 = mysql_query($query);
		$row1 = mysql_fetch_assoc($result1);
		$licence = $row1['Licence'];
		$nomchien = $row1['NomChien'];
		$nomcategorie = $nomcategories[$row['Categorie']];
		$conducteur = $row1['Prenom']." ".$row1['Nom'];
		$y = $y + $hligne;
		if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
		$pdf->setxy(40, $y);
		$pdf->cell(20, 7, $licence, 0, 0);
		$pdf->cell(60, 7, utf8_decode($nomchien), 0, 0);
		$pdf->cell(30, 7, utf8_decode($nomcategorie), 0, 0, "C");
		$pdf->cell(20, 7, utf8_decode($conducteur), 0, 0);
	}
}
// Copyright
include("../../communs/imp_copyright_p.php");

//**************************************************
// Statistiques des races
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY CodeRace";
$result = mysql_query($query);
$coderace_preced = "";
$n = 0;
$nb_chien = 0;
$nb_categories = array();
$nb_catraces = array(array());
for ($c = 1; $c <= 4; $c++){
	$nb_parcat[$c] = 0;
}
$nb_males = 0;
$nb_femelles = 0;
$nb_maleslof = 0;
$nb_femelleslof = 0;
$nb_malesnonlof = 0;
$nb_femellesnonlog = 0;
$nb_conducteurs = 0;
$nb_conductrices = 0;
$nb_chienstotal = 0;
while ($row = mysql_fetch_assoc($result)){
	$coderace = $row['CodeRace'];
	if ($coderace == ""){$coderace = "X";}
	if ($coderace <> $coderace_preced){
		if (coderace_preced <> ""){
			$nb_chiens[$n] = $nb_chien;
			$nb_chienstotal = $nb_chienstotal + $nb_chien;
			for ($c = 1; $c <= 4; $c++){
				$nb_catraces[$n][$c] = $nb_categories[$c];
				$nb_parcat[$c] = $nb_parcat[$c] + $nb_categories[$c];
				$nb_categories[$c] = 0;
			}
			$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace_preced'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$races[$n] = $row1['Race'];
			$nb_chien = 0;
		}
		$coderace_preced = $coderace;
		$n++;
	}
	$licence = $row['Licence'];
	$query = "SELECT Id FROM agility_resultats WHERE Licence='$licence' AND Resultat<>'' AND Resultat<>'F' LIMIT 1";
	$result1 = mysql_query($query);
	if (mysql_num_rows($result1) > 0){
		$nb_chien++;
		$categorie = $row['Categorie'];
		$nb_categories[$categorie]++;
		$sexe = $row['Sexe'];
		$lof = $row['LOF'];
		if ($lof != ""){
			if ($sexe == "M"){$nb_maleslof++;} else {$nb_femelleslof++;}
		} else {
			if ($sexe == "M"){$nb_malesnonlof++;} else {$nb_femellesnonlof++;}
		}
		$titre = $row['Titre'];
		if ($titre == "Mr"){$nb_conducteurs++;} else {$nb_conductrices++;}
	}
}
// Dernier chien
$nb_chiens[$n] = $nb_chien;
$nb_chienstotal = $nb_chienstotal + $nb_chien;
for ($c = 1; $c <= 4; $c++){
	$nb_catraces[$n][$c] = $nb_categories[$c];
	$nb_parcat[$c] = $nb_parcat[$c] + $nb_categories[$c];
}
$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace_preced'";
$result1 = mysql_query($query);
$row1 = mysql_fetch_assoc($result1);
$races[$n] = $row1['Race'];
$nb_chien = 0;
$nb_races = $n;
// Calculs globaux
$nb_lof = $nb_maleslof + $nb_femelleslof;
$nb_nonlof = $nb_malesnonlof + $nb_femellesnonlof;
$pc_lof = round($nb_lof / $nb_chienstotal * 10000) / 100;
$pc_nonlof = round($nb_nonlof / $nb_chienstotal * 10000) / 100;
$nb_males = $nb_maleslof + $nb_malesnonlof;
$nb_femelles = $nb_femelleslof + $nb_femellesnonlof;
$pc_males = round($nb_males / $nb_chienstotal * 10000) / 100;
$pc_femelles = round($nb_femelles / $nb_chienstotal * 10000) / 100;
$nb_conducstotal = $nb_conducteurs + $nb_conductrices;
$pc_conducteurs = round($nb_conducteurs / $nb_conducstotal * 10000) / 100;
$pc_conductrices = round($nb_conductrices / $nb_conducstotal * 10000) / 100;
// Impression page
$titre = "LISTE DES RACES REPRESENTEES";
include("../utilitaires/agi_imp_titrestats.php");
// Entête tableau
$pdf->setxy(10, $y);
$pdf->cell(70, 7, "Race", 1, 0, "C");
$pdf->cell(20, 7, "Nb Chiens", 1, 0, "C");
$pdf->cell(20, 7, "%", 1, 0, "C");
$pdf->cell(20, 7, "A", 1, 0, "C");
$pdf->cell(20, 7, "B", 1, 0, "C");
$pdf->cell(20, 7, "C", 1, 0, "C");
$pdf->cell(20, 7, "D", 1, 1, "C");
// Lignes tableau
for ($n = 1; $n <= $nb_races; $n++){
	$pdf->cell(70, 5, utf8_decode($races[$n]), "L", 0);
	$pdf->cell(20, 5, $nb_chiens[$n], 0, 0, "C");
	$pc = round($nb_chiens[$n] / $nb_chienstotal * 10000) / 100;
	$pdf->cell(20, 5, $pc, "R", 0, "C");
	for ($c = 1; $c <= 4; $c++){$pdf->cell(20, 5, $nb_catraces[$n][$c], "R", 0, "C");}
	$pdf->cell(0, 5, "", "R", 1);
}
$y = $pdf->gety();
$pdf->line(10, $y, 200, $y);
// Total
$pdf->setxy(10, $y);
$pdf->cell(110, 7, utf8_decode("TOTAL par catégorie"), 1, 0, "R");
for ($c = 1; $c <= 4; $c++){
	$pdf->cell(20, 7, $nb_parcat[$c], 1, 0, "C");
}
$y = $y + 7;
$pdf->line(10, $y, 200, $y);

// Suite
$y = $y + 15;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(10, 7, $nb_lof, 0, 0, "R");
$pdf->cell(65, 7, "chiens inscrits au LOF (".$pc_lof." %)", 0, 0);
$pdf->cell(0, 7, "dont ".$nb_maleslof." males et ".$nb_femelleslof." femelles", 0, 0);
$y = $y + $hligne;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(10, 7, $nb_nonlof, 0, 0, "R");
$pdf->cell(65, 7, "chiens non inscrits au LOF (".$pc_nonlof." %)", 0, 0);
$pdf->cell(0, 7, "dont ".$nb_malesnonlof." males et ".$nb_femellesnonlof." femelles", 0, 0);
$y = $y + 10;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(10, 7, $nb_conducteurs, 0, 0, "R");
$pdf->cell(60, 7, "Conducteurs (".$pc_conducteurs." % du total des concurrents) ", 0, 0);
$y = $y + $hligne;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
$pdf->cell(10, 7, $nb_conductrices, 0, 0, "R");
$pdf->cell(60, 7, "Conductrices (".$pc_conductrices." % du total des concurrents) ", 0, 0);
// Copyright
include("../../communs/imp_copyright_p.php");

//**************************************************
// Statistiques des épreuves
$epreuvesparpage = 40;
$query = "SELECT * FROM agility_epreuves WHERE Engages>'0' ORDER BY Epreuve, Categorie, Classe, Handi";
$result = mysql_query($query);
$titre = "NOMBRE DE CONCURRENTS AYANT PARTICIPE AUX EPREUVES";
$pdf->SetAutoPagebreak(True);
// Impression titre page
include("../utilitaires/agi_imp_titrestats.php");
// En-tête de la page
$pdf->setxy(10, 40);
$pdf->cell(100, 7, "EPREUVE", 1, 0);
$pdf->cell(22, 7, "CATEGORIE", 1, 0, "C");
$pdf->cell(22, 7, "CLASSE", 1, 0, "C");
$pdf->cell(22, 7, "HANDI", 1, 0, "C");
$pdf->cell(0, 7, "NB CONCUR.", 1, 0, "C");
// Impression Ligne
$hauteur = 5; // Hauteur d'un enregistrement (1 ligne)
$y = 47;
while ($row = mysql_fetch_assoc($result)){
	$idepreuve = $row['Id'];
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$query = "SELECT Id FROM agility_resultats WHERE IdEpreuve='$idepreuve' AND Resultat<>'' AND Resultat<>'F'";
	$result1 = mysql_query($query);
	$concurrents = mysql_num_rows($result1);
	if ($concurrents > 0){
		$nomepreuve = $nomepreuves[$epreuve];
		$nomcategorie = $nomcategories[$categorie];
		$nomclasse = $nomclasses[$classe];
		$nomhandi = $nomhandis[$handi];
		$pdf->setxy(10, $y);
		$pdf->setfont("", "", 10);
		$pdf->cell(100, 5, utf8_decode($nomepreuve), 0, 0);
		$pdf->cell(22, 5, $nomcategorie, 0, 0, "C");
		$pdf->cell(22, 5, $nomclasse, 0, 0, "C");
		$pdf->cell(22, 5, $nomhandi, 0, 0, "C");
		$pdf->cell(0, 5, $concurrents, 0, 0, "C");
		// Cadre
		$pdf->setxy(10, $y);
		$pdf->cell(0, 5, "", 1, 0);
		// Suite
		$y = $y + $hauteur;
		if ($y > $basdepage){
			include("../utilitaires/agi_imp_sautdepagestats.php");
			$pdf->setxy(10, $y);
		}
	}
}
// Copyright
include("../../communs/imp_copyright_p.php");

//**************************************************
// Statistiques des mentions
$nb_mentions = array();
$nb_mentionstotals = array();

// Impression titre page
$titre = "LISTE DES MENTIONS OBTENUES";
include("../utilitaires/agi_imp_titrestats.php");
// Entête tableau
$y = $pdf->gety() + 7;
$pdf->setxy(10, $y);
$pdf->cell(85, 7, "Epreuves", 1, 0, "C");
$pdf->cell(15, 7, "EXC", 1, 0, "C");
$pdf->cell(15, 7, "TBON", 1, 0, "C");
$pdf->cell(15, 7, "BON", 1, 0, "C");
$pdf->cell(15, 7, "NCL", 1, 0, "C");
$pdf->cell(15, 7, "ELI", 1, 0, "C");
$pdf->cell(15, 7, "ABAN", 1, 0, "C");
$pdf->cell(15, 7, "Total", 1, 1, "C");
$hauteur = 5;
$y = 47;
// Lignes tableau
$query = "SELECT * FROM agility_resultats WHERE Resultat<>'F' AND Resultat<>'' AND Resultat<>'' ORDER BY Classe, Epreuve, Categorie";
$result = mysql_query($query);
$classe_preced = "";
$epreuve_preced = "";
$categorie_preced = "";
for ($m = 0; $m < 7; $m++){$nb_mentions[$m] = "0";}
for ($m = 0; $m < 7; $m++){$nb_mentionstotals[$m] = "0";}
while ($row = mysql_fetch_assoc($result)){
	$classe = $row['Classe'];
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	if ($classe <> $classe_preced){
		if ($classe_preced <> ""){
			$pdf->setxy(10, $y);
			include("apresagi_statsmentionsimp_ligne.php");
			$y = $y + $hauteur;
			if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
			$pdf->setxy(10, $y);
			include("apresagi_statsmentionsimp_lignetotal.php");
//			$y = $y + $hauteur;
	//		if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
		//	$pdf->setxy(10, $y);
		}
		// Titre classe
		$pdf->cell(0, 7, "***** ".$nomclasses[$classe]." *****", "LR", 1);
		$y = $y + $hauteur;
		if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
		$pdf->setxy(10, $y);
		$classe_preced = $classe;
		$epreuve_preced = $epreuve;
		$categorie_preced = $categorie;
	}
	if ($epreuve <> $epreuve_preced or $categorie <> $categorie_preced){
		if ($epreuve_preced <> ""){
//			$y = $y + 5;
			if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
			$pdf->setxy(10, $y);
			include("apresagi_statsmentionsimp_ligne.php");
			$y = $y + 5;
			if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
			$pdf->setxy(10, $y);
		}
		$epreuve_preced = $epreuve;
		$categorie_preced = $categorie;
	}
	$resultat = $row['Resultat'];
	if ($resultat == "X"){$nb_mentions[0]++; $nb_mentionstotals[0]++; $nb_mentions[6]++; $nb_mentionstotals[6]++;}
	if ($resultat == "T"){$nb_mentions[1]++; $nb_mentionstotals[1]++; $nb_mentions[6]++; $nb_mentionstotals[6]++;}
	if ($resultat == "B"){$nb_mentions[2]++; $nb_mentionstotals[2]++; $nb_mentions[6]++; $nb_mentionstotals[6]++;}
	if ($resultat == "N"){$nb_mentions[3]++; $nb_mentionstotals[3]++; $nb_mentions[6]++; $nb_mentionstotals[6]++;}
	if ($resultat == "E"){$nb_mentions[4]++; $nb_mentionstotals[4]++; $nb_mentions[6]++; $nb_mentionstotals[6]++;}
	if ($resultat == "A"){$nb_mentions[5]++; $nb_mentionstotals[5]++; $nb_mentions[6]++; $nb_mentionstotals[6]++;}
}
// Dernière ligne
$epreuve_preced = $epreuve;
$categorie_preced = $categorie;
include("apresagi_statsmentionsimp_ligne.php");
$y = $y + 5;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
include("apresagi_statsmentionsimp_lignetotal.php");
$y = $y + 5;
if ($y > $basdepage){include("../utilitaires/agi_imp_sautdepagestats.php");}
$pdf->setxy(10, $y);
// Copyright
include("../../communs/imp_copyright_p.php");

$pdf->output();
?>
</body>
</html>
