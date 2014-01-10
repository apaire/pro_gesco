<?php
session_start();
$_SESSION['RetourClubsAjout'] = "../agility/init/initagi_club.php";
$_SESSION['Flag_AppelProgramme'] = "Y";
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
// Connexion bdd
include("../../communs/connexion.php");
// Enregistrement des données entrées
if (isset($_POST['valider'])){
	$codeclub = $_POST['codeclub'];
	$_SESSION['CodeClub'] = $codeclub;
	$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$_SESSION['Club'] = $row['Club'];
	$_SESSION['NomComplet'] = $row['NomComplet'];
	$coderegionale = $row['CodeRegionale'];
	$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$_SESSION['Regionale'] = $row['Regionale'];
	include("../../communs/ecrit_variables_genes.php");
	include("initagi.php");
	exit;
}
$codeclub = $_SESSION['CodeClub'];
$club = $_SESSION['Club'];
$nomcomplet = $_SESSION['NomComplet'];
// Liste des clubs
$query = "SELECT * FROM cneac_clubs ORDER BY CodeClub";
$result = mysql_query($query);
//**************************************************
$titre = "<a href='initagi.php'>Initialisation du concours</a> &gt; <a href='initagi_club.php'>Modification du Club Organisateur</a>";
include("../utilitaires/bandeau_agi.php");
//**************************************************
?>
<h3 class="center">Modification du Club organisateur du Concours</h3>
<form action='initagi_club.php' method='post' enctype="multipart/form-data">
<table class="general" align="center" width="80%" border="1"><tr><td>
<p class="center">Nom du club&nbsp;: <?php echo "$nomcomplet ($club)"; ?></p>
<p class="center"><select name="codeclub">
	<?php
	while ($row = mysql_fetch_assoc($result)){
		$idclub_liste = $row['Id'];
		$codeclub_liste = $row['CodeClub'];
		$club_liste = $row['Club'];
		echo "<option value='".$codeclub_liste."'";
		if ($codeclub_liste == $codeclub){echo " selected='selected'";}
		echo " >".$codeclub_liste." / ".$club_liste."</option>";
	}
	?>
	</select></p>
<p class="center"><a href="../../boiteaoutils/maj_clubsajout.php">Si le club n'est pas dans la liste, cliquez ICI.</a></p>
</td></tr></table>
<table class="general" align="center" width="80%" border="1" rules="groups">
	<tr><th class="left"><div class="bouton"><a href="initagi.php">RETOUR</a></div></th><td class="right"><input type="submit" name="valider" value="Valider" /></td></tr>
</table>
</form>
</body>
</html>