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
</head>
<body>
<?php
$retour = $_SESSION['retour'];
$idlicence = $_SESSION['IdLicence'];
$licence = $_SESSION['Licence'];
$nbexc = $_SESSION['nbexc'];
if (isset($_POST['coupe'])){
	$query = "DELETE FROM agility_resultats WHERE IdLicence='$idlicence' AND (Epreuve='11' OR Epreuve='15')";
	mysql_query($query);
	$query = "DELETE FROM agility_penalants WHERE IdLicence='$idlicence'";
	mysql_query($query);
	include ("avantagi_concurrents.php");
	exit;
}
if (isset($_POST['valider'])){
	$query = "DELETE FROM agility_penalants WHERE IdLicence='$idlicence'";
	mysql_query($query);
	$penalitesant = 0;
	$_SESSION['Championnat'] = "Y";
	for ($n = 1; $n <= $nbexc; $n++){
		$jours = "jour".$n;
		$moiss = "mois".$n;
		$annees = "annee".$n;
		$juges = "juge".$n;
		$penalitess = "penalites".$n;
		$date = $_POST[$annees]."-".$_POST[$moiss]."-".$_POST[$jours];
		$juge = mysql_real_escape_string($_POST[$juges]);
		$penalites = str_replace(",", ".", $_POST[$penalitess]);
		$penalitesant = $penalitesant + $penalites;
		$query = "INSERT INTO agility_penalants SET IdLicence='$idlicence', Date='$date', Juge='$juge', Penalites='$penalites'";
		$result = mysql_query($query);
		if ($juge == ""){$_SESSION['Championnat'] = "N";}
	}
	$query = "UPDATE agility_resultats SET PenalitesAnt='$penalitesant' WHERE IdLicence='$idlicence'";
	mysql_query($query);
	// Contrôle des résultats
	$query = "SELECT Id FROM agility_penalants WHERE IdLicence='$idlicence' AND Date<>'0000-00-00' AND Juge<>''";
	if (mysql_num_rows(mysql_query($query)) < $nbexc){
		//**************************************************
		$titre = "<a href='avant.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a>";
		include("../utilitaires/bandeau_agi.php");
		//**************************************************
		echo "<h3 class='center'>Entrée des résultats antérieurs</h3>
		<p class='center'><span class='alert'>&nbsp;Attention&nbsp;: des champs n'ont pas été remplis&nbsp;</span><br />";
//		Si vous voulez les remplir plus tard, cliquez deux fois sur \"RETOUR\".</p>
		echo "<table align='center'><tr><th><div class='bouton'><a href='avantagi_concurrents_4.php'>RETOUR</a></div></th></tr></table>";
		//$query = "DELETE FROM agility_resultats WHERE IdLicence='$idlicence' AND (Epreuve='11' OR Epreuve='15')";
//		mysql_query($query);
		exit;
	}
	include ("avantagi_concurrents.php");
	exit;
}
if ($_SESSION['AfficheTitre'] != "N"){
	//**************************************************
	$titre = "<a href='avant.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a>";
	include("../utilitaires/bandeau_agi.php");
	//**************************************************
}
$_SESSION['Championnat'] = "N";
$juge1 = "";
$juge2 = "";
$juge3 = "";
$juge4 = "";
$juge5 = "";
for ($n = 1; $n <= 5; $n++){$juges[$n] = "";}
?>
<h3 class="center">Entrée des résultats antérieurs</h3>
<h4 class="center">Si les résultats antérieurs ne sont pas entrés, le concurrents ne sera inscrit qu'à la Coupe Régionale</h4>
<form action="avantagi_concurrents_4.php" method="post" enctype="multipart/form-data">
<?php
echo "<h4 class='center'>Licence n° ".$_SESSION['Licence']." ($nbexc Excellents)</h4>";
$query = "SELECT * FROM agility_penalants WHERE IdLicence='$idlicence' ORDER BY Date";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0){
	$n = 1;
	while ($row = mysql_fetch_assoc($result)){
		$ids[$n] = $row['Id'];
		$dates = explode("-",$row['Date']);
		$juges[$n] = $row['Juge'];
		$penalitess[$n] = $row['Penalites'];
		$jours[$n] = $dates[2];
		$moiss[$n] = $dates[1];
		$annees[$n] = $dates[0];
		$n++;
	}
} else {
	for ($n = 1; $n <= $nbexc; $n++){
		$juges[$n] = "";
		$penalitess[$n] = "";
		$jours[$n] = "";
		$moiss[$n] = "";
		$annees[$n] = "";
	}
}
?>
<table class="general" align="center" border="1" rules="groups" width="60%">
	<colgroup><col /></colgroup><colgroup><col /></colgroup><colgroup><col /></colgroup><colgroup><col /></colgroup>
	<tbody>
	<tr><th rowspan="2"></th><th>Date</th><th rowspan="2">Juge</th><th rowspan="2">Pénalités</th></tr>
	<tr><th>Jour - Mois - Année</th>
	</tbody>
	<tbody>
<?php
for ($n = 1; $n <= $nbexc; $n++){
	$jour = "jour".$n;
	$mois = "mois".$n;
	$annee = "annee".$n;
	$juge = "juge".$n;
	$penalites = "penalites".$n;
	?>
	<tr><th><?php echo $n; ?></th>
		<td class="center"><input type="text" name="<?php echo $jour; ?>" value="<?php echo $jours[$n]; ?>" size="2" /> - 
			<input type="text" name="<?php echo $mois; ?>" value="<?php echo $moiss[$n]; ?>" size="2" /> - 
			<input type="text" name="<?php echo $annee; ?>" value="<?php echo $annees[$n]; ?>" size="4" />
		</td>
		<td class="center"><input type="text" name="<?php echo $juge; ?>" value="<?php echo $juges[$n]; ?>" /></td>
		<td class="center"><input type="text" name="<?php echo $penalites; ?>" value="<?php echo $penalitess[$n]; ?>" size="4" /></td>
	</tr>
	<?php
}
?>
	</tbody>
</table>
<table class="general" align="center" border="1" rules="groups" width="60%">
	<tr>
		<!--th class="left"><div class="bouton"><a href="avantagi_concurrents.php">RETOUR</a></div></th-->
		<th class="left"><input type="submit" name="coupe" value="Inscrire uniquement à la Coupe Régionale" /></th>
		<th class="right"><input type="submit" name="valider" value="Valider Résultats Antérieurs" /></th>
	</tr>
</table>
</form>
</body>
</html>