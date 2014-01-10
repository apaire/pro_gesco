<?php
session_start();
$titre = "<a href='".$_SESSION["RetourRegionalesModif"]."'>".$_SESSION['Programme']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_clubsmodif.php'>Modification d'un Club</a>";
include("bandeau_bao.php");
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
<h3 class="center">Modification d'un Club</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_POST['supprimer'])){
	$idclub = $_SESSION['idclub'];
	$query = "DELETE FROM cneac_clubs WHERE Id='$idclub'";
	if (!mysql_query($query)){echo mysql_error();}
	else {echo "<p class='center'>Le Club a été supprimé de la table</p>
	<table align='center'><tr><th><div class='bouton'><a href='maj_clubsmodif.php'>RETOUR</a></div></th></tr></table>";}
	mysql_close();
	exit;
}

if (isset($_POST['valider'])){
	$idclub = $_SESSION['idclub'];
	$club = $_POST['club'];
	$nomcomplet = $_POST['nomcomplet'];
	$codeclub = $_POST['codeclub'];
	$coderegionale = $_POST['coderegionale'];
	$adresse1 = $_POST['adresse1'];
	$adresse2 = $_POST['adresse2'];
	$ville = $_POST['ville'];
	$telephone = $_POST['telephone'];
	$equipe = $_POST['equipe'];
	$_SESSION['club'] = $club;
	$_SESSION['nomcomplet'] = $nomcomplet;
	$_SESSION['codeclub'] = $codeclub;
	$_SESSION['coderegionale'] = $coderegionale;
	$_SESSION['adresse1'] = $adresse1;
	$_SESSION['adresse2'] = $adresse2;
	$_SESSION['ville'] = $ville;
	$_SESSION['telephone'] = $telephone;
	$_SESSION['equipe'] = $equipe;
	if (($club == "") or ($codeclub == "") or ($coderegionale == "")){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez obligatoirement entrer le Nom abrégé, le Code régionale et le Code du Club&nbsp;</span></p>";
	} else {
		$query = "UPDATE cneac_clubs SET Club='$club', NomComplet='$nomcomplet', CodeClub='$codeclub', Adresse1='$adresse1', Adresse2='$adresse2', Ville='$ville', Telephone='$telephone', Equipe='$equipe' WHERE Id='$idclub'";
		if (mysql_query($query)){echo "<p class='center'>Le club $club a été enregistré</p>";}
		else {echo mysql_error();}
	}
	echo "<table align='center'><tr><th><div class='bouton'><a href='maj_clubsmodif.php'>RETOUR</a></div></th></tr></table>";
	mysql_close();
	exit;
}
if (isset($_GET['idclub'])){
	$idclub = $_GET['idclub'];
	$_SESSION['idclub'] = $idclub;
	$query = "SELECT * FROM cneac_clubs WHERE Id='$idclub'";
	if (!$result = mysql_query($query)){echo mysql_error();}
	$row = mysql_fetch_assoc($result);
	$club = $row['Club'];
	$nomcomplet = $row['NomComplet'];
	$codeclub = $row['CodeClub'];
	$coderegionale = $row['CodeRegionale'];
	$adresse1 = $row['Adresse1'];
	$adresse2 = $row['Adresse2'];
	$ville = $row['Ville'];
	$telephone = $row['Telephone'];
	$equipe = $row['Equipe'];
	?>
	<form action='maj_clubsmodif.php' method='post' enctype='multipart/form-data'>
	<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
	<table class='general' width='80%' align='center' border='1' rules='groups'>
		<colgroup><col width='50%' /><col width='*' /></colgroup>
		<tbody>
		<tr>
			<td class='right'>Nom abrégé du Club&nbsp;:</td>
			<td><input type='text' name='club' value='<?php echo $club; ?>' /> <span class='red'>*</span></td>
		</tr>
		<tr>
			<td class='right'>Nom complet du Club&nbsp;:</td>
			<td><input type='text' name='nomcomplet' value="<?php echo $nomcomplet; ?>" size="50" /></td>
		</tr>
		<tr>
			<td class='right'>Code Club&nbsp;:</td>
			<td><input type='text' name='codeclub' value="<?php echo $codeclub; ?>" size='10' /> <span class='red'>*</span></td>
		</tr>
		<tr>
			<td class='right'>Code Régionale&nbsp;:</td>
			<td><input type='text' name='coderegionale' value='<?php echo $coderegionale; ?>' size='1' /> <span class='red'>*</span></td>
		</tr>
		<tr>
			<td class='right'>Adresse 1&nbsp;:</td>
			<td><input type='text' name='adresse1' value="<?php echo $adresse1; ?>" /></td>
		</tr>
		<tr>
			<td class='right'>Adresse 2&nbsp;:</td>
			<td><input type='text' name='adresse2' value="<?php echo $adresse2; ?>" /></td>
		</tr>
		<tr>
			<td class='right'>Ville&nbsp;:</td>
			<td><input type='text' name='ville' value="<?php echo $ville; ?>" size='10' /></td>
		</tr>
		<tr>
			<td class='right'>Téléphone&nbsp;:</td>
			<td><input type='text' name='telephone' value='<?php echo $telephone; ?>' size='10' /></td>
		</tr>
		<tr>
			<td class='right'>Nom de l'Equipe de Flyball&nbsp;:</td>
			<td><input type='text' name='equipe' value="<?php echo $equipe; ?>" />
			</td>
		</tr>
		</tbody>
		<tbody>
		<tr>
			<td class='left'><input type='submit' name='supprimer' value='Supprimer ce Club' /></td><td class='right'><input type='submit' name='valider' value='Valider' /></td>
		</tr>
		</tbody>
	</table>
	</form>
	<table align='center'><tr><td class='center'><div class='bouton'><a href='maj_clubsmodif.php'>RETOUR</a></div></td></tr></table>
	<?php
	mysql_close();
	exit;
}
?>
<table align='center'><tr><td class='center'><div class='bouton'><a href='boiteaoutils.php'>RETOUR</a></div></td></tr></table>
<p class="center">(cliquer sur le Code en début de ligne)</p>
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /></colgroup><colgroup><col /><col /><col /></colgroup>
	<thead><tr><th><a href="maj_clubsmodif.php?ordre=CodeClub">Code Club</a></th><th align="left"><a href="maj_clubsmodif.php?ordre=Club">Nom brégé</a></th><th><a href="maj_clubsmodif.php?ordre=NomComplet">Nom complet</a></th><th></tr></thead>
	<tbody>
	<?php
	if (isset($_GET['ordre'])){$ordre = $_GET['ordre'];} else {$ordre = "CodeClub";}
	$fond = "clair";
	$query = "SELECT * FROM cneac_clubs ORDER BY $ordre";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$club = $row['Club'];
		$nomcomplet = $row['NomComplet'];
		$codeclub = $row['CodeClub'];
		echo "<tr class='$fond'><th><a href='maj_clubsmodif.php?idclub=$id'>$codeclub</a></th></td><td>$club</td><td>$nomcomplet</td></tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
	?>
	</tbody>
</table>

<table align="center"><tr><th><div class="bouton"><a href="boiteaoutils.php">RETOUR</a></div></th></tr></table>

</body>
</html>