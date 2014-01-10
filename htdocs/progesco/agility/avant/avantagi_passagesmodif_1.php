<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_passagesmodif.php'>Modification des ordres de passage</a>";
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
<h3 class="center">Modification manuelle des ordres de passage</h3>
<?php
// Connexion bdd
include("../utilitaires/nomvars_agi.php");
include("../../communs/connexion.php");
if (isset($_POST['choixepreuve'])){
	$epreuve = $_POST['epreuve'];
	$categorie = $_POST['categorie'];
	$classe = $_POST['classe'];
	$handi = $_POST['handi'];
	$nomepreuve = $nomepreuves[$epreuve];
	$nomcategorie = $nomcategories[$categorie];
	$nomclasse = $nomclasses[$classe];
	$query = "SELECT Id FROM agility_epreuves WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$idepreuve = $row['Id'];
	$_SESSION['nomepreuve'] = $nomepreuve;
	$_SESSION['nomcategorie'] = $nomcategorie;
	$_SESSION['nomclasse'] = $nomclasse;
	$_SESSION['idepreuve'] = $idepreuve;
	$_SESSION['Epreuve'] = $epreuve;
	$_SESSION['Categorie'] = $categorie;
	$_SESSION['Classe'] = $classe;
	$_SESSION['Handi'] = $handi;
} else {
	$idepreuve = $_SESSION['idepreuve'];
	$nomepreuve = $_SESSION['nomepreuve'];
	$nomcategorie = $_SESSION['nomcategorie'];
	$nomclasse = $_SESSION['nomclasse'];
}

// Validation des modifications
if (isset($_POST['valider'])){
	$query = "SELECT Id FROM agility_resultats WHERE IdEpreuve='$idepreuve'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$ordrepassage = $_POST[$id];
		$query = "UPDATE agility_resultats SET OrdrePassage='$ordrepassage' WHERE Id='$id'";
		mysql_query($query);
	}
	echo "<p class='center'><span class='alert'>&nbsp;Les nouveaux ordres de passage ont été enregistrés&nbsp;</span></p>
	<table align='center'><tr><th><div class='bouton'><a href='avantagi_passagesmodif.php'>RETOUR</a></div></th></tr></table>";
	$_SESSION['ordrespassage'] = "attribues";
	include("../utilitaires/ecrit_variables_agi.php");
	mysql_close();
	exit;
}
?>
<p class="center"><span class="alert">&nbsp;ATTENTION : Aucun contrôle n'est fait sur les ordres de passage entrés manuellement&nbsp;</span></p>
<?php
echo "<p class='center'>Epreuve <b>$nomepreuve</b> - Categorie <b>$nomcategorie</b> - Classe <b>$nomclasse</b></p>";
if (isset($_GET['ordre'])){$ordre = $_GET['ordre'];} else {$ordre = "OrdrePassage";}
$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$idepreuve' ORDER BY $ordre";
$result = mysql_query($query);
if (mysql_num_rows($result) == 0){
	echo "<p class='center'>Il n'y a aucun concurrent inscrit à cette épreuve</p>
	<table align='center'><tr><th><div class='bouton'><a href='avantagi_passagesmodif.php'>RETOUR</a></div></th></tr></table>";
	exit;
}
?>
<form action="avantagi_passagesmodif_1.php" method="post" enctype="multipart/form-data">
<table align='center' width="80%" border="1" rules="groups">
	<colgroup><col /><col /><col /><col /><col /><col /><col /></colgroup>
	<thead>
	<tr><th><a href='avantagi_passagesmodif_1.php?ordre=OrdrePassage'>Ordre&nbsp;de&nbsp;passage</a></th><th><a href='avantagi_passagesmodif_1.php?ordre=Dossard'>Dossard</a></th><th><a href='avantagi_passagesmodif_1.php?ordre=Licence'>Licence</a></th><th>Chien</th><th>Race</th><th>Conducteur</th><th>Club</th></tr>
	</thead>
	<tbody>
<?php
// Affichage liste des classements
$fond = "clair";
while ($row = mysql_fetch_assoc($result)){
	$id = $row['Id'];
	$ordrepassage = $row['OrdrePassage'];
	$licence = $row['Licence'];
	$idlicence = $row['IdLicence'];
	$dossard = $row['Dossard'];
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$nomchien = $row1['NomChien'];
	$nom = $row1['Nom']." ".$row1['Prenom'];
	$coderace = $row1['CodeRace'];
	$codeclub = $row1['CodeClub'];
	$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$club = $row1['Club'];
	$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$race = $row1['Race'];
	echo "<tr class='$fond' align='center'>
		<td><input type='text' name='$id' value='$ordrepassage' size='1' /></td><td>$dossard</td><td>$licence</td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club</td></tr>";
	if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
}
?>
	</tbody>
	<tbody>
	<tr><th class="left" colspan="3"><div class="bouton"><a href="avantagi_passagesmodif.php">RETOUR</a></div></th><th></th><th class="right" colspan="4"><input type='submit' name='valider' value='Valider les nouveaux ordres de passage' /></th></tr>
	</tbody>
</table>
</form>
</body>
</html>