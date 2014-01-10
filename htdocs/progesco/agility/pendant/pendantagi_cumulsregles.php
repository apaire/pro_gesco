<?php
session_start();
include("../../communs/connexion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript1.2" src="../../communs/programmes.js"></script>
</head>
<body onload="donner_focus('1')">
<?php
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
if (isset($_GET['id'])){$_SESSION['IdCumul'] = $_GET['id'];}
$idcumul = $_SESSION['IdCumul'];
// Supprimer le cumul
if (isset($_POST['supprimer'])){
	$query = "DELETE FROM agility_reglescumuls WHERE Id='$idcumul'";
	mysql_query($query);
}
// Enregistrer le cumul
if (isset($_POST['choixepreuves']) and $_SESSION['Flag_Local'] == "Y"){
	$nomcumulaff = $_POST['nomcumul'];
	$nomcumul = mysql_real_escape_string($nomcumulaff);
	if ($nomcumul == ""){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez entrer un nom pour le cumul&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='pendantagi_cumulsregles.php'>RETOUR</a></div></th></tr></table>";
		exit;
	}
	$epreuves = "NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN";
	for ($n = $epreuvedeb; $n <= $epreuvefin; $n++){if (isset($_POST[$n])){$epreuves{$n} = "Y";}}
	if ($_POST['sanscat'] == "Y"){$epreuves{49} = "Y";}
	// Vérification nom déjà existant
	$query = "SELECT NomCumul FROM agility_reglescumuls WHERE NomCumul='$nomcumul'";
	$result = mysql_query($query);
	$nb = mysql_num_rows($result);
	if ($nb > 0){
		$query = "UPDATE agility_reglescumuls SET Epreuves='$epreuves' WHERE NomCumul='$nomcumul'";
		mysql_query($query);
	} else {
		// Calcul Epreuve
		$query = "SELECT Epreuve FROM agility_reglescumuls ORDER BY Epreuve DESC";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$epreuvecumul = $row['Epreuve'] + 1;
		if ($epreuvecumul < 20){$epreuvecumul = 71;}
		$query = "INSERT INTO agility_reglescumuls SET Epreuve='$epreuvecumul', NomCumul='$nomcumul', Epreuves='$epreuves'";
		mysql_query($query);
	}
	$nomcumul = "";
	$_SESSION['Flag_Local'] = "N";
	$_SESSION['IdCumul'] = "";
	$epreuves = "";
	include("pendantagi_cumulsregles.php");
	exit;
}
$_SESSION['Flag_Local'] = "Y";
if ($idcumul > 0){
	$query = "SELECT * FROM agility_reglescumuls WHERE Id='$idcumul'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$nomcumul = $row['NomCumul'];
	$epreuves = $row['Epreuves'];
}
//**************************************************
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_cumulsregles.php'>Entrée des règles de cumuls</a>";
include("../utilitaires/bandeau_agi.php");
//**************************************************
?>
<h3 class="center">Entrée des règles de cumul</h3>
<h4 class="center">Sélectionnez les épreuves à cumuler</h4>
<form action="pendantagi_cumulsregles.php" method="post" enctype="multipart/form-data">
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /><col /></colgroup>
	<tbody>
	<tr><th class="right">Nom du cumul : </th><td><input id="1" type="text" name="nomcumul" value="<?php echo $nomcumul; ?>" size="40" /></td></tr>
	</tbody>
	<tbody>
		<?php
		for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
			$selectee = $epreuves{$epreuve};
			echo "<tr><td class='right'>$nomepreuves[$epreuve]</td>
			<td><input type='checkbox' name='$epreuve' value='Y'";
			if ($selectee == "Y"){echo " checked='checked'";}
			echo " /></td></tr>";
		}
		echo "<tr><td class='right'>Toutes catégories confondues</td>
		<td><input type='checkbox' name='sanscat' value='Y'";
		if ($epreuves{49} == "Y"){echo " checked='checked'";}
		echo " /></td></tr>";
		?>
	</tbody>
	<tbody>
	<tr><th class="left"><div class="bouton"><a href="pendantagi.php">RETOUR</a></div></th><td class="right">
	<?php
	if ($nomcumul != ""){echo "<input type='submit' name='supprimer' value='Supprimer ce cumul' />";}
	?>
	<input type="submit" name="choixepreuves" value="Valider" /></td></tr>
	</tbody>
</table>
</form>
<?php
$query = "SELECT * FROM agility_reglescumuls ORDER BY NomCumul";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0){
	echo "<h3 class='center'>Règles de cumuls déjà enregistrées</h3>
	<table align='center'>";
	while ($row = mysql_fetch_assoc($result)){
		$idcumul = $row['Id'];
		$nomcumul = $row['NomCumul'];
		$epreuve = $row['Epreuve'];
		echo "<tr><th>";
		if ($epreuve > 65){echo "<a href='pendantagi_cumulsregles.php?id=$idcumul'>$nomcumul</a>";} else {echo $nomcumul;}
		echo "</th></tr>";
	}
	echo "</table>";
}
?>
</body>
</html>