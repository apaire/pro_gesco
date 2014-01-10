<?php session_start(); ?>
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
// Enregistrement des données entrées
if (isset($_POST['effacer'])){
	// Connexion bdd
	include("../../communs/connexion.php");
	$query = "UPDATE cneac_licences SET AGI1='N' WHERE AGI1='Y'";
	mysql_query($query);
	$query = "TRUNCATE TABLE agility_resultats";
	mysql_query($query);
	$query = "TRUNCATE TABLE agility_penalants";
	mysql_query($query);
	$_SESSION['Concurrents'] = "";
	$_SESSION['Dossards'] = "";
	$_SESSION['OrdresPassage'] = "";
	include("../utilitaires/ecrit_variables_agi.php");
	include("initagi.php");
	exit;
}

$titre = "<a href='initagi.php'>Initialisation du concours</a> &gt; <a href='initagi_effacement.php'>Effacement des concurrents</a>";
include("../utilitaires/bandeau_agi.php");
?>
<h3 class="center">Effacement des concurrents déjà enregistrés</h3>
<form action='initagi_effacement.php' method='post' enctype='multipart/form-data'>
<table class="general" align='center' width='80%' border='1'>
	<tr>
		<th>
			<h2 class='center'><span class='alarm'>&nbsp;ATTENTION&nbsp;: cette opération est irréversible&nbsp;</span></h2>
			<p class='center'>Toutes les données d'un concours précédent seront effacées (liste des concurrents, résultats,...).<br />
			Le club organisateur, la date et le type de concours ne seront pas modifiés.</p>
		</th>
	</tr>
</table>
<table class="general" align='center' width='80%' border='1' rules="groups">
	<tr><th class="left"><div class="bouton"><a href="initagi.php">RETOUR sans effacer</a></div></th><td class="right"><input type='submit' name='effacer' value='Confirmez l&acute;effacement des concurrents déjà enregistrés' /></td></tr>
</table>
</form>
</body>
</html>