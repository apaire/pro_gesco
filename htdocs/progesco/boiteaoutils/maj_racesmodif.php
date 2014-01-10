<?php
session_start();
$titre = "<a href='".$_SESSION["RetourRacesModif"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_racesmodif.php'>Modification d'une Race</a>";
include("bandeau_bao.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<body>
<h3 class="center">Modification d'une Race</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_GET['idrace'])){
	$idrace = $_GET['idrace'];
	$_SESSION['idrace'] = $idrace;
} else {$idrace = $_SESSION['idrace'];}

if (isset($_POST['supprimer'])){
	$idrace = $_SESSION['idrace'];
	$query = "DELETE FROM cneac_races WHERE Id='$idrace'";
	if (!mysql_query($query)){echo mysql_error();}
	else {echo "<p class='center'>La Race a été supprimée de la table</p>
	<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR Boîte à Outils</a></div></th></tr></table>";}
	mysql_close();
	exit;
}

if (isset($_POST['valider'])){
	$coderace = $_POST['coderace'];
	$race = $_POST['race'];
	$_SESSION['coderace'] = $coderace;
	$_SESSION['race'] = $race;
	$race = mysql_real_escape_string($race);
	if (($coderace == "") or ($race == "")){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez obligatoirement entrer le Code Race et la Race&nbsp;</span></p>";
		$retour = "ent_race.php";
	} else {
		$query = "UPDATE cneac_races SET CodeRace='$coderace', Race='$race' WHERE Id='$idrace'";
		if (!mysql_query($query)){echo mysql_error();}
		else {echo "<p class='center'>La race ".stripslashes($race)." a été enregistrée</p>";}
	}
	echo "<table align='center'><tr><th><div class='bouton'><a href='maj_racesmodif.php'>RETOUR</a></div></th></tr></table>";
	mysql_close();
	exit;
}

if (isset($_GET['idrace'])){
	$idrace = $_GET['idrace'];
	$_SESSION['idrace'] = $idrace;
	$query = "SELECT * FROM cneac_races WHERE Id='$idrace'";
	if (!$result = mysql_query($query)){echo mysql_error();}
	$row = mysql_fetch_assoc($result);
	$coderace = $row['CodeRace'];
	$race = $row['Race'];
	?>
	<form method='post' action='maj_racesmodif.php' enctype='multipart/form-data'>
	<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
	<table class='general' width='80%' align='center' border='1' rules='groups'>
		<colgroup><col width='50%' /><col width='*' /></colgroup>
		<tbody>
		<tr>
			<td class='right'>Code Race&nbsp;:</td>
			<td><input type='text' name='coderace' value="<?php echo $coderace; ?>" size='40' /> <span class='red'>*</span></td>
		</tr>
		<tr>
			<td class='right'>Race&nbsp;:</td>
			<td><input type='text' name='race' value="<?php echo $race; ?>" size='40' /> <span class='red'>*</span></td>
		</tr>
		</tbody>
		<tbody>
		<tr>
			<td class='left'><input type='submit' name='supprimer' value='Supprimer cette Race' /></td><td class='right'><input type='submit' name='valider' value='Valider' /></td>
		</tr>
		</tbody>
	</table>
	</form>
	<table align='center'><tr><th class='center'><div class='bouton'><a href='maj_racesmodif.php'>RETOUR</a></div></th></tr></table>
	<?php
	mysql_close();
	exit;
}
?>
<table align="center"><tr><td class="center"><div class="bouton"><a href="boiteaoutils.php">RETOUR</a></div></td></tr></table>
<p class="center">(cliquer sur le code de la race en début de ligne)</p>
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /><col /><col /></colgroup>
	<thead><tr><th align="left"><a href="maj_racesmodif.php?ordre=coderace">Code Race</a></th><th><a href="maj_racesmodif.php?ordre=race">Race</a></th></tr></thead>
	<tbody>
	<?php
	$fond = "clair";
	$ordre = $_GET['ordre'];
	if ($ordre != ""){$_SESSION['Ordre'] = $ordre;}
	else if ($_SESSION['Ordre'] == ""){$_SESSION['Ordre'] = "CodeRace";}
	$query = "SELECT * FROM cneac_races ORDER BY ".$_SESSION['Ordre'];
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$coderace = $row['CodeRace'];
		$race = $row['Race'];
		echo "<tr class='$fond'><td><a href='maj_racesmodif.php?idrace=$id'>$coderace</a></td><td>$race</td></tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
	?>
	</tbody>
</table>
<table align="center"><tr><th><div class="bouton"><a href="boiteaoutils.php">RETOUR Boîte à Outils</a></div></th></tr></table>

</body>
</html>