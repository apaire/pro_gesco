<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
// Initialisation des variables pour les bases de données
include("../utilitaires/nomvars_agi.php");
// Enregistrement des données entrées
if (isset($_POST['valider'])){
	$jour = $_POST['jour'];
	$mois = $_POST['mois'];
	$annee = $_POST['annee'];
	if (strlen($jour) == 1){$jour = "0".$jour;}
	if (strlen($mois) == 1){$mois = "0".$mois;}
	$_SESSION['Jour'] = $jour;
	$_SESSION['Mois'] = $mois;
	$_SESSION['Annee'] = $annee;
	include("../utilitaires/ecrit_variables_agi.php");
	include("initagi.php");
	exit;
}

$titre = "<a href='initagi.php'>Initialisation du concours</a> &gt; <a href='initagi_date.php'>Modification de la date</a>";
include("../utilitaires/bandeau_agi.php");
?>
<table class="general" align="center" width="80%" border="1"><tr><th>
<form action='initagi_date.php' method='post' enctype="multipart/form-data">
<h3 class="center">Modification de la date du Concours</h3>
<p class="center">Date du concours&nbsp;: <select name="jour">
	<?php
	for ($n = 1; $n <= 31; $n++){
		echo "<option value=$n";
		if ($_SESSION['Jour'] == $n){echo " selected='selected'";}
		echo ">$n</option>";
	}
	?>
	</select>
	<select name="mois">
	<?php
	for ($n = 1; $n <= 12; $n++){
		if (strlen($n) == 1){$n = "0".$n;}
		echo "<option value=$n";
		if ($_SESSION['Mois'] == $n){echo " selected='selected'";}
		echo ">$nommoiss[$n]</option>";
	}
	?>
	</select>
	<select name="annee">
	<?php
	$an = date("Y");
	for ($n = $an; $n <= $an+1; $n++){
		echo "<option value=$n";
		if ($_SESSION['Annee'] == $n){echo " selected='selected'";}
		echo ">$n</option>";
	}
	?>
	</select></p>
</th></tr></table>
<table class="general" align="center" width="80%" border="1" rules="groups">
	<tr><th class="left"><div class="bouton"><a href="initagi.php">RETOUR</a></div></th><td class="right"><input type="submit" name="valider" value="Valider" /></td></tr>
</table>
</form>
</body>
</html>