<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript1.2" src="../../communs/programmes.js"></script>
</head>
<body onload="donner_focus('1')">
<h3 class="center">Entrée des Concurrents</h3>
<?php
$_SESSION['RetourConcurrents1'] = "avantagi_concurrents.php";
if ($_SESSION['Message'] != ""){
	echo $_SESSION['Message'];
	$_SESSION['Message'] = "";
}
?>

<form method="post" action="avantagi_concurrents_1.php" enctype="multipart/form-data">
<table class="general" align="center" width="80%" cellpadding="10" border="1" rules="groups">
	<tbody>
	<tr>
		<td class="center">N° de licence à entrer&nbsp;: <input id="1" tabindex="1" type="text" name="licence" /></td>
	</tr>
	</tbody>
</table>
<table class="general" align='center' width="80%" border="1" rules="groups">
	<tr>
		<th class='left'><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th>
		<td align="right"><input tabindex="2" type="submit" name="validlicence" value="Valider N° de licence" /></td>
	</tr>
</table>
</form>

<?php
// Effacelent des données entrées
$_SESSION['IdLicence'] = "";
$_SESSION['Licence'] = "";
$_SESSION['NomChien'] = "";
$_SESSION['Affixe'] = "";
$_SESSION['CodeRace'] = "";
$_SESSION['LOF'] = "";
$_SESSION['Sexe'] = "";
$_SESSION['Toise'] = "";
$_SESSION['Categorie'] = "";
$_SESSION['Classe'] = "";
$_SESSION['Tatouage'] = "";
$_SESSION['Puce'] = "";
$_SESSION['Titre'] = "";
$_SESSION['Nom'] = "";
$_SESSION['Prenom'] = "";
$_SESSION['Handi'] = "";
$_SESSION['Adresse1'] = "";
$_SESSION['Adresse2'] = "";
$_SESSION['CP'] = "";
$_SESSION['Ville'] = "";
$_SESSION['Email'] = "";
$_SESSION['Telephone'] = "";
$_SESSION['CodeClub'] = "";
// Connexion bdd
include("../../communs/connexion.php");
include("../utilitaires/nomvars_agi.php");
// Classement
if (isset($_GET['ordre'])){$ordre = $_GET['ordre'];} else {$ordre = "Licence";}
$query = "SELECT * FROM cneac_licences WHERE AGI1='Y' ORDER BY $ordre"; // Recherche concurrents
$result = mysql_query($query);
$nb_concurrents = mysql_num_rows($result);
if ($nb_concurrents == 0){ // Aucun concurrent enregistré
	echo "<p class='center'>Aucun concurrent n'est encore entré pour ce concours</p>
	<table align='center'><tr><th class='center'><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th></tr></table>";
	mysql_close();
	exit;
} else {
	echo "<p class='center'>$nb_concurrents concurrent";
	if ($nb_concurrents == 1){echo " est enregistré</p>";} else {echo "s sont enregistrés</p>";}
	echo "<p class='center'>Pour modifier les données d'un concurrent, cliquez sur son numéro de licence</p>";
}
?>
<table align="center">
	<tr><th><a href="avantagi_concurrents.php?ordre=Licence">Licence</th><th>Dossard</th><th><a href="avantagi_concurrents.php?ordre=NomChien">Chien</a></th><th>Race</th><th>LOF</th><th><a href="avantagi_concurrents.php?ordre=Categorie">Catégorie</a></th><th><a href="avantagi_concurrents.php?ordre=Classe">Classe</a></th><th><a href="avantagi_concurrents.php?ordre=Handi">Handi</a></th><th><a href="avantagi_concurrents.php?ordre=Nom">Conducteur</a></th><th><a href="avantagi_concurrents.php?ordre=CodeClub">Club</a></th><?php if ($_SESSION['TypeConcours'] == "ChF"){echo "<th>Pen.Ant</th>";} ?></tr>
<?php
$fond = "clair";
while ($row = mysql_fetch_assoc($result)){
	$idlicence = $row['Id'];
	$licence = $row['Licence'];
	$nomchien = $row['NomChien'];
	$affixe = $row['Affixe'];
	$coderace = $row['CodeRace'];
	$lof = $row['LOF'];
	$sexe = $row['Sexe'];
	$toise = $row['Toise'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$conducteur = $row['Nom']." ".$row['Prenom'];
	$codeclub = $row['CodeClub'];
	// Dossard
	$query = "SELECT * FROM agility_resultats WHERE IdLicence='$idlicence'";
	$result1 = mysql_query($query);
	$row = mysql_fetch_assoc($result1);
	$dossard = $row['Dossard'];
	if ($dossard == 0){$dossard = "";}
	$penalitesant = $row['PenalitesAnt'];
	// Décodage race
	$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$race = $row1['Race'];
	// Décodage Club
	$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$club = $row1['Club'];
	$nomcategorie = $nomcategories[$categorie];
	$nomclasse = $nomclasses[$classe];
	$nomhandi = $nomhandis[$handi];
	echo "<tr class='$fond' align='center'><td><a href='avantagi_concurrents_1.php?idlicence=$idlicence'>$licence</a></td><td>$dossard</td><td>$nomchien</td><td>$race</td><td>$lof</td><td>$nomcategorie</td><td>$nomclasse</td><td>$nomhandi</td><td>$conducteur</td><td>$club</td>";
	if ($_SESSION['TypeConcours'] == "ChF"){echo "<td>$penalitesant</td>";}
	echo "</tr>";
	if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
}
mysql_close();
?>
</table>
<table align="center"><tr><th class="center"><div class="bouton"><a href="avantagi.php">RETOUR</a></div></th></tr></table>
</body>
</html>