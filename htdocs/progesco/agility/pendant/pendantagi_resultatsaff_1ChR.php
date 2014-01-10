<?php
session_start();
?>
<a id="debut"></a>
<?php
// Connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
// Epreuve à afficher
$epreuve = $_SESSION['Epreuve'];
$categorie = $_SESSION['Categorie'];
$classe = $_SESSION['Classe'];
$handi = $_SESSION['Handi'];

echo "<h3 class='center'>Affichage des Résultats </h3>
<p class='center'><b>$nomepreuves[$epreuve] - Catégorie $nomcategories[$categorie]";
if ($_SESSION['TypeConcours'] != "ChF"){echo " - Classe $nomclasses[$classe]";}
if ($handi > 0){echo " - Handi : $nomhandis[$handi]";}
echo "</b></p>";

$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'F' ORDER BY Classement, Penalites, Temps";
$result = mysql_query($query);
if (mysql_num_rows($result) == 0){
	echo "<p class='center'><span class='alert'>&nbsp;Aucun résultat n'est enregistré pour cette épreuve&nbsp;</span></p>
	<table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultatsaff.php'>RETOUR</a></div></th></tr></table>";
	exit;
}
if ($epreuve == 11 or $epreuve == 15){$col = 4; $coltot = 12;} else {$col = 3; $coltot = 11;}
?>
<table align="center"><tr><th><div class="bouton"><a href="pendantagi_resultatsaff.php">RETOUR</a></div></th></tr></table>
<table class="general" width="100%" align="center" border="1" rules="groups">
	<colgroup><col /><col /></colgroup><colgroup><col /><col /><col /><col /></colgroup><colgroup><col /><col /><col /><col/><col /><col /><col /></colgroup>
	<tbody>
	<tr class='$fond' align='center'><th rowspan='2'>Clas<sup>t</sup></th><th rowspan='2'>Dossard</th><th colspan='2'>Chien</th><th rowspan='2'>Conducteur</th><th rowspan='2'>Club</th><th>Temps</th><th colspan='<?php echo $col; ?>'>Pénalités</th><th rowspan='2'>Qualif.</th></tr>
	<tr class='$fond' align='center'><th>Nom</th><th>Race</th><th>sec</th>
	<?php if($epreuve == 11 or $epreuve == 15){echo "<th>Ant.</th>";} ?>
	<th>Parc.</th><th>&gt; TPS</th><th>Total</th></tr></tbody>
	<tbody>
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
	$penalitesant = $row['PenalitesAnt'];
	$total = $row['Total'];
	$classement = $row['Classement'];
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
	echo "<tr class='$fond' align='center'><td>$classement</td><td>$dossard</td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club</td><td>$temps</td>";
	if ($epreuve == 11 or $epreuve == 15){echo "<td>$penalitesant</td>";}
	echo "<td>$penalites</td><td>$depastemps</td>
	<td>$total</td><td>$nomresultat</td></tr>";
}
echo "</tbody>";
if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
echo "<tr class='$fond'><th align='right' colspan='$coltot'><a href='#debut'>Retour en haut de page</a></th></tr>";
?>
<table align="center"><tr><th><div class="bouton"><a href="pendantagi_resultatsaff.php">RETOUR</a></div></th></tr></table>
</body>
</html>