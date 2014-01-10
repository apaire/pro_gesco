<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pandantagi_resultatsaff.php'>Envoi des résultats sur Internet</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<body>
<center>
<a id="debut"></a>
<?php
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
// Epreuve à afficher
$epreuve = $_GET['epreuve'];
$nomepreuve = $nomepreuves[$epreuve];
// Connexion bdd
include("../../communs/connexion.php");

// En-tête de la page HTML
$page = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<title>PROGESCO</title>
	<link href='../../../cneac.css' rel='stylesheet' type='text/css'></head>
	<body>
	<center>
	<a id='debut /'><table class='tableausoustitre' align='center'>
	<tbody>
	<tr>
		<th><h4 class='center'>$nomepreuve</h4>
		<p class='center'>Afficher les résultats des catégories
		<a href='#A'>&nbsp;A&nbsp;</a>
		<a href='#B'>&nbsp;B&nbsp;</a>
		<a href='#C'>&nbsp;C&nbsp;</a>
		<a href='#D'>&nbsp;D&nbsp;</a></p></th>
	</tr>
	</tbody>
	</table>
	<table class='tableauTextelpetit' align='center'>";
// Résultats de l'épreuve
for ($handi = 0; $handi <= 5; $handi++){
	for ($categorie = 1; $categorie <= 4; $categorie++){
		// Lecture résultats de la catégorie
		$query = "SELECT * FROM agility_resultatscumuls WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Handi='$handi' AND Classement>'0' ORDER BY Classement, Penalites, Temps";
		$result = mysql_query($query);
		if (mysql_num_rows($result) == 0){continue;}
		// Ecriture en-tête catégorie
		if ($categorie > 1){$page .= "<tr colspan='11'><td align='right'><a href='#debut'>Retour en haut de page</a></td></tr>";}
		$page .= "<tbody><tr class='clair'><th colspan='11' align='center'><a id='A' />$nomepreuves[$epreuve] – Catégorie $nomcategories[$categorie]</th></tr>";
		$page .= "<tr class='clair' align='center'>
				<th rowspan='2'>Clas<sup>t</sup></th>
				<th rowspan='2'>Dossard</th>
				<th colspan='2'>Chien</th>
				<th rowspan='2'>Conducteur</th>
				<th rowspan='2'>Club</th>
				<th rowspan='2'>Temps</th>";
		if ($epreuve == "51" or $epreuve == "52"){$page .= "<th colspan='4'>Pénalités</th>";} else {$page .= "<th colspan='3'>Pénalités</th>";}
		$page .=	"</tr>
			<tr class='clair' align='center'>
				<th>Nom</th>
				<th>Race</th>";
		if ($epreuve == "51" or $epreuve == "52"){$page .= "<th>Ant.</th>";}
		$page .= "<th>Parc.</th>
				<th>&gt; TPS</th>
				<th>Total</th>
			</tr>";
		$fond = "clair";
		while ($row = mysql_fetch_assoc($result)){
			$licence = $row['Licence'];
			$dossard = $row['Dossard'];
			$penalites = $row['Penalites'];
			$depastemps = $row['Depastemps'];
			$temps = $row['Temps'];
			$penalitesant = $row['PenalitesAnt'];
			$total = $row['Total'];
			$resultat = $row['Resultat'];
			$classement = $row['Classement'];
			$brevet = $nombrevets[$row['Brevet']];
			$nomresultat = $nomresultats[$resultat];
			if ($classement == 9995){$classement = "NC";}
			if ($classement > 9995){$classement = "";}
			// Infos licence
			$query = "SELECT * FROM cneac_licences WHERE Licence='$licence'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$nomchien = $row['NomChien'];
			$coderace = $row['CodeRace'];
			$sexe = $row['Sexe'];
			$nom = $row['Nom']." ".$row['Prenom'];
			$codeclub = $row['CodeClub'];
			// Race
			$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$race = $row['Race'];
			// Club
			$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$club = $row['Club'];
			$coderegionale = $row['CodeRegionale'];
			$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
			$result1 = mysql_query($query);
			$row = mysql_fetch_assoc($result1);
			$club .= " (".$row['Regionale'].")";
			if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
			$page .= "<tr class='$fond' align='center'><td>$classement</td><td>$dossard</td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club</td>	<td>$temps</td>";
			if ($epreuve == "51" or $epreuve == "52"){$page .= "<td>$penalant</td>";}
			$page .= "<td>$penalites</td><td>$depastemps</td><td>$total</td></tr>";
		}
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
}
mysql_close();
$nomfichier = "c:\\".$nomepreuvewwws[$epreuve].".html";
$fp = fopen($nomfichier, "w");
fputs($fp, $page);
fclose($fp);
echo "<p class='center'>Le fichier ".$nomfichier." a été créé</p>";
?>

<table align="center"><tr><th><div class="bouton"><a href="pendantagi_resultatswww.php">RETOUR</a></div></th></tr></table>
</body>
</html>