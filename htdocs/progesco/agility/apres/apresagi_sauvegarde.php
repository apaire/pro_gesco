<?php
session_start();
$titre = "<a href='apresagi.php'>Après le concours</a> &gt; <a href='apresagi_sauvegarde.php'>Sauvegarde du concours</a>";
include("../utilitaires/bandeau_agi.php");
include("../../communs/connexion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<link href="../../agility/apres/utilitaires/styles.css" rel="stylesheet" type="text/css" />
</head>
<body onload="parent.Bandeau.location.href='apres_sauvegarde_bandeau.php'">
<h3 class="center">Sauvegarde du Concours et création des fichiers pour centralisation</h3>
<?php
$date = $_SESSION['Annee'].$_SESSION['Mois'].$_SESSION['Jour'];
$fichier = "agility_".$_SESSION['CodeClub']."_".$date."_".date("MdHi");
$sauvegarde .= "../../../../CNEAC/".$fichier.".cneac";
$fp = fopen($sauvegarde, "w");
$crlf = ";".chr(13).chr(10);

// Ligne blanche
$texte = $crlf;
fputs($fp, $texte);

// Table des variables
$table = "cneac_variables";
include("../../communs/tableexport.php");

// Table des régionales
$table = "cneac_regionales";
include("../../communs/tableexport.php");

// Table des clubs
$table = "cneac_clubs";
include("../../communs/tableexport.php");

// Table des races
$table = "cneac_races";
include("../../communs/tableexport.php");

// Table des juges
$table = "cneac_juges";
include("../../communs/tableexport.php");

// Table des licences
$table = "cneac_licences";
include("../../communs/tableexport.php");

// Tables du concours
$table = "agility_epreuves";
include("../../communs/tableexport.php");

$table = "agility_resultats";
include("../../communs/tableexport.php");

$table = "agility_penalants";
include("../../communs/tableexport.php");

$table = "agility_reglescumuls";
include("../../communs/tableexport.php");

$table = "agility_resultatscumuls";
include("../../communs/tableexport.php");

fclose($fp);
$disques = explode("/",$_SERVER['DOCUMENT_ROOT']);
?>
</table>

<?php
// Création des fichiers pour Centragil
include("../utilitaires/nomvars_agi.php");
include("../../communs/connexion.php");
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
$codecluborg = $_SESSION['CodeClub'];
$cluborg = $_SESSION['Club'];
$regionaleorg = substr($codecluborg, 0, 1);
$disques = explode("/",$_SERVER['DOCUMENT_ROOT']);
$sauvegarde = "../../../../CNEAC/";
echo "<table class='general' width='80%' align='center' border='1' rules='group'>";

// Fichier AGIDKTCO
$nomfichier = $sauvegarde."AGIDKTCO.TXT";
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY Licence";
if (!($result = mysql_query($query))){echo $query." - ".mysql_error();}
$textefichier = "";
while ($row = mysql_fetch_assoc($result)){
	$licence = $row['Licence'];
	$nomchien = $row['NomChien'];
	$categorie = $nomcategories[$row['Categorie']];
	$classe = $nomclasses[$row['Classe']];
	$handi = $row['Handi'];
	$nom = $row['Nom'];
	$codeclub = $row['CodeClub'];
	if ($handi == ""){$handi = 0;}
	$query = "SELECT Club FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	if (mysql_num_rows($result1) == 0){echo "<p class='center'><span class='alert'>&nbsp;ATTENTION : le code $codeclub n'est pas dans la table des clubs&nbsp;</span></p>";}
	$row1 = mysql_fetch_assoc($result1);
	$club = $row1['Club'];
	if (strlen($licence) < 6){$licence = " ".$licence;}
	$textefichier .= utf8_decode('"'.$licence.'","'.$nomchien.'","'.$categorie.'","'.$classe.'","'.$nom.'","'.$club.'","'.$date.'",'.$handi.$crlf);
}
$textefichier .= chr(26);
$fp = fopen($nomfichier, "w");
fputs($fp, $textefichier);
fclose($fp);

// Fichier AGIDKTEP
$nomfichier = $sauvegarde."AGIDKTEP.TXT";
$query = "SELECT * FROM agility_epreuves WHERE TPS<>'0' ORDER BY Id";
if (!($result = mysql_query($query))){echo $query." - ".mysql_error();}
$textefichier = "";
while ($row = mysql_fetch_assoc($result)){
	$idepreuve = $row['Id'];
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$longueur = $row['Longueur'];
	$nbobstacles = $row['NbObstacles'];
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	$juge = $row['Juge'];
	$engages = $row['Engages'];
	include("apresagi_centralisationepreuves.php");
	if (strlen($juge) > 15){$juge = substr($juge, 0, 15);}
	$textefichier .= utf8_decode('"'.$date.'","'.$codeepreuvecentragil.'",'.$longueur.','.$nbobstacles.','.$tps.','.$tmp.',"'.$juge.'","'.$codecluborg.'","'.$cluborg.'",'.$engages.','.$engages.','.$handi.$crlf);
}
$textefichier .= chr(26);
$fp = fopen($nomfichier, "w");
fputs($fp, $textefichier);
fclose($fp);

// Fichier AGIDKTRE
$nomfichier = $sauvegarde."AGIDKTRE.TXT";
$query = "SELECT * FROM agility_resultats WHERE Classement<>'0' ORDER BY Licence";
if (!($result = mysql_query($query))){echo $query." - ".mysql_error();}
$textefichier = "";
while ($row = mysql_fetch_assoc($result)){
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$licence = $row['Licence'];
	$handi = $row['Handi'];
	$temps = $row['Temps'];
	$fautes = $row['Fautes'] + $row['Refus'];
	$penalites = $row['Total'];
	$resultat = $row['Resultat'];
	$classement = $row['Classement'];
	$brevet = $row['Brevet'];
	if ($resultat == "E"){$elimine = "O";} else {$elimine = "N";}
	if ($classement > 9990){$classement = 999;}
	include("apresagi_centralisationepreuves.php");
	if (strlen($licence) < 6){$licence = " ".$licence;}
	if ($epreuve == 1 and ($brevet == 1 or $brevet == 2 or $brevet == 3)){$brevet .= "PA";}
	$textefichier .= utf8_decode('"'.$codecluborg.'","'.$date.'","'.$codeepreuvecentragil.'","'.$licence.'",'.$temps.','.$fautes.','.$penalites.',"'.$elimine.'",'.$classement.',"'.$brevet.'"'.$crlf);
}
$textefichier .= chr(26);
$fp = fopen($nomfichier, "w");
fputs($fp, $textefichier);
fclose($fp);

// Fichier AGIDKTST
$nomfichier = $sauvegarde."AGIDKTST.TXT";
$query = "SELECT * FROM agility_resultats ORDER BY IdEpreuve";
if (!($result = mysql_query($query))){echo $query." - ".mysql_error();}
$nblignes = mysql_num_rows($result);
$textefichier = "";
// Cumuls M
$cumul1 = 0;
$cumul2 = 0;
$cumul3 = 0;
$cumul4 = 0;
$cumul5 = 0;
$cumul6 = 0;
$cumul7 = 0;
for ($e = 1; $e <= 8; $e++){
	for ($c = 1; $c <= 4; $c++){
		for ($l = 1; $l <= 3; $l++){
			$nomcategorie = $nomcategories[$c];
			$nomclasse = $nomclasses[$l];
			$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$e' AND Categorie='$c' AND Classe='$l' AND Resultat='X'";
			$result = mysql_query($query);
			$cumul1 = $cumul1 + mysql_num_rows($result);
			$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$e' AND Categorie='$c' AND Classe='$l' AND Resultat='T'";
			$result = mysql_query($query);
			$cumul2 = $cumul2 + mysql_num_rows($result);
			$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$e' AND Categorie='$c' AND Classe='$l' AND Resultat='B'";
			$result = mysql_query($query);
			$cumul3 = $cumul3 + mysql_num_rows($result);
			$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$e' AND Categorie='$c' AND Classe='$l' AND Resultat='N'";
			$result = mysql_query($query);
			$cumul4 = $cumul4 + mysql_num_rows($result);
			$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$e' AND Categorie='$c' AND Classe='$l' AND Resultat='E'";
			$result = mysql_query($query);
			$cumul5 = $cumul5 + mysql_num_rows($result);
			$query = "SELECT Id FROM agility_resultats WHERE Epreuve='$e' AND Categorie='$c' AND Classe='$l' AND Resultat='A'";
			$result = mysql_query($query);
			$cumul6 = $cumul6 + mysql_num_rows($result);
			$cumul7 = $cumul1 + $cumul2 + $cumul3 + $cumul4 + $cumul5 + $cumul6;
			if ($cumul7 > 0){
				$epreuve = $e;
				$categorie = $nomcategories[$c];
				$classe = $nomclasseabrs[$l];
				include("apresagi_centralisationepreuves.php");
				$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","M","'.$codeepreuvecentragil.'","'.$nomepreuve.'","'.$categorie.'","'.$classe.'",'.$cumul1.','.$cumul2.','.$cumul3.','.$cumul4.','.$cumul5.','.$cumul6.','.$cumul7.',""'.$crlf);
				$cumul1 = 0;
				$cumul2 = 0;
				$cumul3 = 0;
				$cumul4 = 0;
				$cumul5 = 0;
				$cumul6 = 0;
				$cumul7 = 0;
			}
		}
	}
}
// Cumuls R Z1 Races
$coderace_preced = "";
$cumul1 = 0;
$cumul2 = 0;
$cumul3 = 0;
$cumul4 = 0;
$nb_hommes = 0;
$nb_femmes = 0;
$nb_flof = 0;
$nb_fnonlof = 0;
$nb_mlof = 0;
$nb_mnonlof = 0;
$nb_catA = 0;
$nb_catB = 0;
$nb_catC = 0;
$nb_catD = 0;
$nb_races = 0;
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY CodeRace";
$result = mysql_query($query);
$nb_chiens = mysql_num_rows($result);
while ($row = mysql_fetch_assoc($result)){
	$coderace = $row['CodeRace'];
	$sexe = $row['Sexe'];
	$categorie = $row['Categorie'];
	$titre = $row['Titre'];
	$lof = $row['LOF'];
	if ($titre == "Mr"){$nb_hommes++;} else {$nb_femmes++;}
	if ($sexe == "M"){if ($lof != ""){$nb_mlof++;} else {$nb_mnonlof++;}}
	if ($sexe == "F"){if ($lof != ""){$nb_flof++;} else {$nb_fnonlof++;}}
	if ($coderace != $coderace_preced){
		if ($coderace_preced != ""){
			$query = "SELECT Race FROM cneac_races WHERE CodeRace='$coderace_preced'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$race = $row1['Race'];
			$nb_chiensrace = $cumul1 + $cumul2 + $cumul3 + $cumul4;
			$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","R","Z1","'.$race.'","","",'.$cumul1.','.$cumul2.','.$cumul3.','.$cumul4.',0,'.$nb_chiens.','.$nb_chiensrace.',""'.$crlf);
			$cumul1 = 0;
			$cumul2 = 0;
			$cumul3 = 0;
			$cumul4 = 0;
		}
		$nb_races++;
		$coderace_preced = $coderace;
	}
	if ($categorie == 1){$cumul1++; $nb_catA++;}
	if ($categorie == 2){$cumul2++; $nb_catB++;}
	if ($categorie == 3){$cumul3++; $nb_catC++;}
	if ($categorie == 4){$cumul4++; $nb_catD++;}
}
// Dernier enregistrement
$query = "SELECT Race FROM cneac_races WHERE CodeRace='$coderace'";
$result1 = mysql_query($query);
$row1 = mysql_fetch_assoc($result1);
$race = $row1['Race'];
$nb_chiensrace = $cumul1 + $cumul2 + $cumul3 + $cumul4;
$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","R","Z1","'.$race.'","","",'.$cumul1.','.$cumul2.','.$cumul3.','.$cumul4.',0,'.$nb_chiens.','.$nb_chiensrace.',""'.$crlf);
// Cumuls R Z2 Catégories
$nb_total = $nb_catA + $nb_catB + $nb_catC + $nb_catD;
$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","R","Z2","     Nb de Chiens ->","","",'.$nb_catA.','.$nb_catB.','.$nb_catC.','.$nb_catD.',,,'.$nb_total.',""'.$crlf);
// Cumuls R Z3 Races
$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","R","Z3","     Nb de Races  ->","","",,,,,,,'.$nb_races.',""'.$crlf);
// Cumuls R Z4 LOF
$nb_lof = $nb_mlof + $nb_flof;
$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","R","Z4","   LOF et non LOF ->","","",'.$nb_flof.','.$nb_mlof.','.$nb_fnonlof.','.$nb_mnonlof.',,'.$nb_lof.','.$nb_chiens.',""'.$crlf);
// Cumuls R Z5 Conducteurs
$nb_conducteurs = $nb_hommes + $nb_femmes;
$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","R","Z5","      Conducteurs ->","","",'.$nb_hommes.','.$nb_femmes.',,,,,'.$nb_conducteurs.',""'.$crlf);
// Cumuls C C1 Nb chiens
$codeclub_preced = "";
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY CodeClub";
$result = mysql_query($query);
$nb_chiens = mysql_num_rows($result);
$nb_chiensclub = 0;
while ($row = mysql_fetch_assoc($result)){
	$codeclub = $row['CodeClub'];
	if ($codeclub != $codeclub_preced){
		if ($coderace_preced != ""){
			$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$club = $row['Club'];
			$regionale = $club{0};
			$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","C","C1","'.$club.'","","",'.$nb_chiensclub.',,,,,,'.$nb_chiens.',"'.$regionale.'"'.$crlf);
			$nb_chiensclub = 0;
		}
		$codeclub_preced = $codeclub;
	}
	$nb_chiensclub++;
}
// Cumuls C C2 Nb épreuves
include("apresagi_statspassages.php");
$textefichier .= utf8_decode('"'.$codecluborg.'","'.$regionaleorg.'","'.$date.'","C","C2","Nb epreuves/passages","","",'.$nb_epreuves[1].','.$nb_epreuves[3].','.$nb_epreuves[2].','.$nb_passages.','.$nb_brevets[1].','.$nb_brevets[2].','.$nb_brevets[3].',""'.$crlf);
$textefichier .= chr(26);
$fp = fopen($nomfichier, "w");
fputs($fp, $textefichier);
fclose($fp);

############################################################################################################################
###                                    Export de la base vers fichier SQL
############################################################################################################################
include("zimmer_export.php");


mysql_close();

//**************************************************
// Création fichier zip
$date = $_SESSION['Annee'].$_SESSION['Mois'].$_SESSION['Jour'];
$club = $_SESSION['Club'];
$clubs = explode('-', $club);
$car_origine = array(" ", ".", "/", "'");
$car_remplacement = array("_", "_", "_", "_");
$ville = str_replace($car_origine, $car_remplacement, $clubs[0]);
$fichierzip = "agility_".$ville."_".$date.".zip";
$fichiersauvegardecomplet = "../../../../CNEAC/".$fichier.".cneac";
$fichierzipcomplet = "../../../../CNEAC/".$fichierzip;
if (file_exists($fichierzipcomplet)){unlink($fichierzipcomplet);}
$zip = new ZipArchive();
$zip->open($fichierzipcomplet, ZipArchive::CREATE);
$zip->addFile("../../../../CNEAC/AGIDKTCO.TXT", "AGIDKTCO.TXT");
$zip->addFile("../../../../CNEAC/AGIDKTEP.TXT", "AGIDKTEP.TXT");
$zip->addFile("../../../../CNEAC/AGIDKTRE.TXT", "AGIDKTRE.TXT");
$zip->addFile("../../../../CNEAC/AGIDKTST.TXT", "AGIDKTST.TXT");
$zip->addFile($fichiersauvegardecomplet, basename($fichiersauvegardecomplet));
$zip->addFile($fichierSQL, basename($fichierSQL));
$_SESSION['Fichierzip'] = $fichierzip;
?>

	<tr><th align="center">Les fichiers de sauvegarde ont été créés.</th></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th align='center'><span class="alert">&nbsp;Le fichier "<?php echo $disques[0].'xampplite\\CNEAC\\'.$fichierzip; ?> doit être envoyé par mail&nbsp;<br />&nbsp;au CTR ou au Délégué Informatique de votre régionale&nbsp;</span></th></tr>
	<tr><th>&nbsp;</th></tr>
</table>

<table align="center"><tr><th><div class="bouton"><a href="apresagi.php">RETOUR</a></div></th></tr></table>
</body>
</html>