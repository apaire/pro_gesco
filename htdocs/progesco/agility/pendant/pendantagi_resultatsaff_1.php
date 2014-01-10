<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pandantagi_resultatsaff.php'>Affichage des résultats</a>";
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
// Connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
// Epreuve à afficher
$epreuve = $_POST['epreuve'];
$categorie = $_POST['categorie'];
$classe = $_POST['classe'];
$handi = $_POST['handi'];
if ($classe == ""){$classe = 1;}
$_SESSION['Epreuve'] = $epreuve;
$_SESSION['Categorie'] = $categorie;
$_SESSION['Classe'] = $classe;
$_SESSION['Handi'] = $handi;
if ($epreuve == 11 or $epreuve == 12 or $epreuve == 15 or $epreuve == 16 or $epreuve == 19){
	include("pendantagi_resultatsaff_1ChR.php");
	exit;
}
// Paramètres de l'épreuve
$query = "SELECT * FROM agility_epreuves WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$idepreuve = $row['Id'];
$nbobstacles = $row['NbObstacles'];
$longueur = $row['Longueur'];
$vitesse = $row['Vitesse'];
$tps = $row['TPS'];
$tmp = $row['TMP'];
$juge = $row['Juge'];
echo "<h3 class='center'>Affichage des Résultats</h3>
<p class='center'><b>$nomepreuves[$epreuve] - Catégorie $nomcategories[$categorie]";
if ($_SESSION['TypeConcours'] != "ChF"){echo " - Classe $nomclasses[$classe]";}
if ($handi > 0){echo " - Handi : $nomhandis[$handi]";}
echo "</b></p>";

$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$idepreuve' AND Classement>'0' ORDER BY Classement, Penalites, Temps";
$result = mysql_query($query);
if (mysql_num_rows($result) == 0){
	echo "<p class='center'><span class='alert'>&nbsp;Aucun résultat n'est enregistré pour cette épreuve&nbsp;</span></p>
	<table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultatsaff.php'>RETOUR</a></div></th></tr></table>";
	exit;
}

echo "<p class='center'>Juge&nbsp;: $juge - $nbobstacles obstacles - Longueur&nbsp;: $longueur&nbsp;m - Vitesse d'évolution&nbsp;: $vitesse&nbsp;m/s - TPS&nbsp;: $tps&nbsp;sec - TMP&nbsp;: $tmp&nbsp;sec</p>";
?>
<table align="center"><tr><th><div class="bouton"><a href="pendantagi_resultatsaff.php">RETOUR</a></div></th></tr></table>
<table class="general" width="100%" align="center" border="1" rules="groups">
	<tr class='$fond' align='center'><th rowspan='2'>Clas<sup>t</sup><th rowspan='2'>Dossard</th><th colspan='2'>Chien</th><th rowspan='2'>Conducteur</th><th rowspan='2'>Club</th><th>Temps</th><th>Vit.Ev.</th><th colspan='3'>Pénalités</th><th rowspan='2'>Qualif.</th>
	<?php if($epreuve == 1 and $classe == 1){echo "<th rowspan='2'>Brevet</th>";} ?></tr>
	<tr class='$fond' align='center'><th>Nom</th><th>Race</th><th>sec</th><th>m/sec</th>
	<th>Parc.</th><th>&gt; TPS</th>
	<th>Total</th></tr>
<?php
$drapeauhaut = 0;
$fond = "clair";
while ($row = mysql_fetch_assoc($result)){
	$resultat = $row['Resultat'];
	$idlicence = $row['IdLicence'];
	$dossard = $row['Dossard'];
	$penalites = $row['Penalites'];
	$depastemps = $row['Depastemps'];
	$temps = $row['Temps'];
	$total = $row['Total'];
	$classement = $row['Classement'];
	$brevet = $nombrevets[$row['Brevet']];
	$nomresultat = $nomresultats[$resultat];
	if ($temps > 0){
		$vitev = number_format($longueur / $temps, 2);
	} else {
		$vitev = "";
		$temps = "";
	}
	if ($classement == 9995){$classement = "NC";}
	if ($classement > 9995){$classement = "";}
	// Infos licence
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result1 = mysql_query($query);
	$row = mysql_fetch_assoc($result1);
	$licence = $row['Licence'];
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
	echo "<tr class='$fond' align='center'><td>$classement</td><td>$dossard</td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club</td><td>$temps</td><td>$vitev</td><td>$penalites</td><td>$depastemps</td>
	<td>$total</td><td>$nomresultat</td>";
	if ($epreuve == 1 and $classe == 1){echo "<td>$brevet</td";}
	echo "</tr>";
}
if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
echo "<tr class='$fond'><th align='right' colspan='13'><a href='#debut'>Retour en haut de page</a></th></tr>";
?>
<table align="center"><tr><th><div class="bouton"><a href="pendantagi_resultatsaff.php">RETOUR</a></div></th></tr></table>
</body>
</html>