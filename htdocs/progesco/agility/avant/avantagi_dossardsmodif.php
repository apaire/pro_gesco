<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_dossardsmodif.php'>Modification manuelle des dossards</a>";
include("../utilitaires/bandeau_agi.php");
include("../utilitaires/nomvars_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h3 class="center">Modification manuelle des numéros de dossards</h3>
<?php
// Connexion bdd
include("../../communs/connexion.php");
if (isset($_GET['ordre'])){$_SESSION['Ordre'] = $_GET['ordre'];}
$ordre = $_SESSION['Ordre'];
if (isset($_POST['valider'])){
	$query = "SELECT Id FROM cneac_licences WHERE AGI1='Y'";
	$result = mysql_query($query);
	// Création d'une colonne temporaire
	$query = "ALTER TABLE agility_resultats ADD COLUMN DossardN INTEGER AFTER Dossard";
	mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['Id'];
		$dossard = $_POST[$idlicence];
		if ($dossard <= 0 or $dossard >= 9999){
			echo "<p class='center'><span class='alert'>&nbsp;Numéro de dossard $dossard invalide&nbsp;</span></p>
			<table align='center'><tr><th><div class='bouton'><a href='avantagi_dossardsmodif.php'>RETOUR</a></div></th></tr></table>";
			exit;
		}
		$query = "UPDATE agility_resultats SET DossardN='$dossard' WHERE IdLicence='$idlicence'";
		mysql_query($query);
		// Vérification si doublon
		$query = "SELECT DossardN FROM agility_resultats WHERE IdLicence<>'$idlicence'";
		$result1 = mysql_query($query);
		while ($row1 = mysql_fetch_assoc($result1)){
			$dossardn = $row1['DossardN'];
			if ($dossard == $dossardn){ // Doublon
				$query = "ALTER TABLE agility_resultats DROP COLUMN DossardN";
				mysql_query($query);
				echo "<p class='center'><span class='alarm'>&nbsp;Le numéro de dossard $dossard a été attribué plusieurs fois&nbsp;</span></p><p class='center'>Les numéros de dossard n'ont pas été modifiés</p>
				<table align='center'><tr><th><div class='bouton'><a href='avantagi_dossardsmodif.php'>RETOUR</a></div></th></tr></table>";
				exit;
			}
		}
	}
	$query = "ALTER TABLE agility_resultats DROP COLUMN Dossard";
	mysql_query($query);
	$query = "ALTER TABLE agility_resultats CHANGE DossardN Dossard INTEGER";
	mysql_query($query);
				echo mysql_error();/////////////
	echo "<p class='center'>Les nouveaux numéros de dossard ont été attribués</p>
	<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th></tr></table>";
	$_SESSION['dossards'] = "attribues";
	include("../utilitaires/ecrit_variables_agi.php");
	mysql_close();
	exit;
}
?>
<form action='avantagi_dossardsmodif.php' method='post'>
<table class="general" width='80%' align='center' border='1' rules='groups'>
	<colgroup><col /><col /><col /><col /><col /><col /><col /></colgroup>
	<tbody><tr><th><a href='avantagi_dossardsmodif.php?ordre=Dossard'>Dossard</a></th><th><a href='avantagi_dossardsmodif.php?ordre=Licence'>Licence</a></th><th><a href='avantagi_dossardsmodif.php?ordre=NomChien'>Chien</a></th><th><a href='avantagi_dossardsmodif.php?ordre=Categorie'>Categorie</a></th><th><a href='avantagi_dossardsmodif.php?ordre=Nom'>Conducteur</a></th><th><a href='avantagi_dossardsmodif.php?ordre=Classe'>Classe</a></th><th><a href='avantagi_dossardsmodif.php?ordre=CodeClub'>Club</a></th></tr></tbody><tbody>
<?php
// Affichage des concurrents
if ($ordre == "Dossard"){
	$query = "SELECT * FROM agility_resultats ORDER BY Dossard, Licence";
	$result = mysql_query($query);
	$fond = "fonce";
	$idlicence_preced = "";
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['IdLicence'];
		if ($idlicence != $idlicence_preced){
			$dossard = $row['Dossard'];
			$licence = $row['Licence'];
			// Licence
			$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$nomchien = $row['NomChien'];
			$conducteur = $row['Nom']." ".$row['Prenom'];
			$codeclub = $row['CodeClub'];
			$categorie = $nomcategories[$row['Categorie']];
			$classe = $nomclasses[$row['Classe']];
			// Club
			$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_assoc($result1);
			$club = $row1['Club'];
			echo "<tr class=$fond><th><input type='text' name='$idlicence' value='$dossard' size='1' /></th><td class='center'>$licence</td><td class='center'>$nomchien</td><td class='center'>$categorie</td><td class='center'>$conducteur</td><td class='center'>$classe</td><td class='center'>$club</td></tr>";
			if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
			$idlicence_preced = $idlicence;
		}
	}
} else {
	$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY $ordre";
	$result = mysql_query($query);
	$fond = "fonce";
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['Id'];
		$licence = $row['Licence'];
		$nomchien = $row['NomChien'];
		$conducteur = $row['Nom']." ".$row['Prenom'];
		$codeclub = $row['CodeClub'];
		$categorie = $nomcategories[$row['Categorie']];
		$classe = $nomclasses[$row['Classe']];
		// Dossard
		$query = "SELECT Dossard FROM agility_resultats WHERE IdLicence='$idlicence' LIMIT 1";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$dossard = $row['Dossard'];
		// Club
		$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result1 = mysql_query($query);
		$row1 = mysql_fetch_assoc($result1);
		$club = $row1['Club'];
		echo "<tr class=$fond><th><input type='text' name='$idlicence' value='$dossard' size='1' /></th><td class='center'>$licence</td><td class='center'>$nomchien</td><td class='center'>$categorie</td><td class='center'>$conducteur</td><td class='center'>$classe</td><td class='center'>$club</td></tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
}
?>
	</tbody>
</table>
<table class="general" width='80%' align='center' border='1' rules='groups'>
	<colgroup><col width="50%" /><col width="*" /></colgroup>
	<tr><th class="left"><div class="bouton"><a href="avantagi.php">RETOUR</a></div></th><th class="right"><input type='submit' name='valider' value='Valider les nouveaux numéros de dossards' /></tr></th>
</table>
</form>
</body>
</html>