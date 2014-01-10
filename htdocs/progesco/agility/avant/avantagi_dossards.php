<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_dossards.php'>Attribution des dossards</a>";
include("../utilitaires/bandeau_agi.php");
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
<h3 class="center">Attribution des dossards</h3>
<?php
// Connexion bdd
include("../../communs/connexion.php");
if (isset($_POST['annulerconfirm'])){
	$query = "UPDATE agility_resultats SET Dossard='0'";
	if (!mysql_query($query)){echo mysql_error();}
	else {
		?>
		<p class='center'>Les numéros de dossards ont été effacés</p><p class='center'><a href='avantagi_dossards.php'>Vous pouvez relancer l'attribution des numéros de dossards en cliquant ICI</a></p>
		<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th></tr></table>
		<?php
		$_SESSION['Dossards'] = "";
	}
	include("../utilitaires/ecrit_variables_agi.php");
	mysql_close();
	exit;
}
if (isset($_POST['annuler'])){
	?>
	<form method="post" enctype="multipart/form-data" action="avantagi_dossards.php">
	<h2 class="center"><span class="alarm">&nbsp;Etes-vous sûr(e) de vouloir supprimer tous les numéros de dossards ?&nbsp;</span></h2>
	<p class="center"><input type="submit" name="annulerconfirm" value="Confirmer l'annulation" /></p>
	<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR Sans annuler</a></div></th></tr></table>
	<?php
	exit;
}
if (isset($_POST['valider'])){
	$dossard = $_POST['depart'];
	if ($dossard < 1){$dossard = 1;}
	$ordre = $_POST['ordre'];
	$query = "SELECT Id FROM cneac_licences WHERE AGI1='Y' ORDER BY ";
	if ($ordre == 1){$query .= "CodeClub, Licence";}
	if ($ordre == 2){$query .= "Categorie, CodeClub, Licence";}
	if ($ordre == 3){$query .= "Classe, CodeClub, Licence";}
	if ($ordre == 4){$query .= "NomChien";}
	if ($ordre == 5){$query .= "Licence";}
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['Id'];
		$query = "UPDATE agility_resultats SET Dossard='$dossard' WHERE IdLicence='$idlicence'";
		mysql_query($query);
		$dossard++;
	}
	?>
	<p class='center'>Les numéros de dossard ont été attribués</p>
	<p class='center'>Pour les futurs concurrents enregistrés, un numéro de dossard à partir de <?php echo $dossard; ?> sera attribué automatiquement.</p>
	<p class='center'>Les numéros de dossard peuvent être changés en cliquant sur l'option <a href='avantagi_dossardsmodif.php?ordre=Dossard'>Modification manuelle des numéros de dossart</a></p>
	<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th></tr></table>
	<?php
	$_SESSION['Dossards'] = $ordre;
	include("../utilitaires/ecrit_variables_agi.php");
	mysql_close();
	exit;
}
if ($_SESSION['Dossards'] != ""){
	?>
	<p class='center'><span class='alert'>&nbsp;Les numéros de dossards ont déjà été attribués par 
	<?php
	if ($_SESSION['Dossards'] == 1){echo "Club";}
	if ($_SESSION['Dossards'] == 2){echo "Catégorie";}
	if ($_SESSION['Dossards'] == 3){echo "Classe";}
	if ($_SESSION['Dossards'] == 4){echo "Nom du Chien";}
	if ($_SESSION['Dossards'] == 5){echo "N° de Licence";}
	?>
	&nbsp;</span></p>
	<p class='center'>Si vous voulez relancer l'attribution, vous devez d'abord annuler l'attribution précédente</p>
	<form method='post' action='avantagi_dossards.php' enctype="multipart/form-data">
	<table class="general" align="center" border="1" rules="groups" width="80%">
		<colgroup><col width="50%" /><col width="*" /></colgroup>
		<tr><th class="left"><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th><th class="right"><input type='submit' name='annuler' value='Annuler attribution des dossards' /></th></tr>
	</table>
	</form>
	<?php
	mysql_close();
	exit;
}
?>
<form action="avantagi_dossards.php" method="post" enctype="multipart/form-data">
<table class="general" align="center" border="1" rules="groups" width="80%">
	<col width="50%" /><col width="*" />
	<tbody>
	<tr>
		<td align="right">Entrer le numéro de départ des dossards :</td><td><input id="1" type="text" name="depart" size="17" /></td>
	</tr>
	<tr>
		<td align="right">Choisissez l'ordre d'attribution des dossards : </td><td><select name="ordre" size="5">
			<option value="1" selected="selected">par club</option>
			<option value="2">par catégorie</option>
			<option value="2">par classe</option>
			<option value="4">par nom du chien</option>
			<option value="5">par n° de licence</option>
		</select>
		</td>
	</tr>
	</tbody>
</table>
<table class="general" align="center" border="1" rules="groups" width="80%">
	<colgroup><col width="50%" /><col width="*" /></colgroup>
	<tbody><tr><th class="left"><div class="bouton"><a href="avantagi.php">RETOUR</a></div></th><th class="right"><input type="submit" name="valider" value="Valider" /></th></tr></tbody>
</table>
</form>
</body>
</html>