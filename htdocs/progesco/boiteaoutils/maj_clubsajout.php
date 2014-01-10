<?php
session_start();
$titre = "<a href='".$_SESSION["RetourClubsAjout"]."'>".$_SESSION["Activite"]."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_clubsajout.php'>Ajout d'un Club</a>";
include("bandeau_bao.php");
$_SESSION["RetourRegionalesAjout"] = "maj_clubsajout.php";
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
<h3 class="center">Ajout d'un Club</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_POST['valider'])){
	$club = utf8_encode(strtoupper(utf8_decode($_POST['club'])));
	$nomcomplet = $_POST['nomcomplet'];
	$codeclub = $_POST['codeclub'];
	$coderegionale = $_POST['coderegionale'];
	$adresse1 = $_POST['adresse1'];
	$adresse2 = $_POST['adresse2'];
	$ville = utf8_encode(strtoupper(utf8_decode($_POST['ville'])));
	$telephone = $_POST['telephone'];
	$equipe = utf8_encode(strtoupper(utf8_decode($_POST['equipe'])));
	$_SESSION['club'] = $club;
	$_SESSION['nomcomplet'] = $nomcomplet;
	$_SESSION['codeclub'] = $codeclub;
	$_SESSION['coderegionale'] = $coderegionale;
	$_SESSION['adresse1'] = $adresse1;
	$_SESSION['adresse2'] = $adresse2;
	$_SESSION['ville'] = $ville;
	$_SESSION['telephone'] = $telephone;
	$_SESSION['equipe'] = $equipe;
	$club = mysql_real_escape_string($club);
	$nomcomplet = mysql_real_escape_string($nomcomplet);
	$adresse1 = mysql_real_escape_string($adresse1);
	$adresse2 = mysql_real_escape_string($adresse2);
	$ville = mysql_real_escape_string($ville);
	$equipe = mysql_real_escape_string($equipe);
	$msg = "";
	if ($club == ""){$msg .= "Nom abrégé du Club";}
	if ($codeclub == ""){$msg .= "<br />Code du Club";}
	if ($coderegionale == ""){$msg .= "<br />Code de la Régionale";}
	if ($msg != ""){
		echo "<p class='center'><span class='alert'>&nbsp;Un paramètre obligatoire n'a pas été renseigné&nbsp;</span></p>
		<p class='center'>$msg</p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_clubsajout.php'>RETOUR</a></div></th></tr></table>";
	} else {
		$query = "SELECT Id FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			echo "<p class='center'><span class='alert'>&nbsp;ATTENTION : un club est déjà enregistré avec le code $codeclub&nbsp;</span></p>
			<table align='center'><tr><th><div class='bouton'><a href='maj_clubsajout.php'>RETOUR</a></div></th></tr></table>";
		} else {
			$query = "INSERT INTO cneac_clubs SET Club='$club', NomComplet='$nomcomplet', CodeClub='$codeclub', CodeRegionale='$coderegionale', Adresse1='$adresse1', Adresse2='$adresse2', Ville='$ville', Telephone='$telephone', Equipe='$equipe'";
			if(mysql_query($query)){echo "<p class='center'>Le club ".stripslashes($club)." a été enregistré</p>";
				// Effacement des variables
				$_SESSION['club'] = "";
				$_SESSION['nomcomplet'] = "";
				$_SESSION['codeclub'] = "";
				$_SESSION['coderegionale'] = "";
				$_SESSION['adresse1'] = "";
				$_SESSION['adresse2'] = "";
				$_SESSION['ville'] = "";
				$_SESSION['telephone'] = "";
				$_SESSION['equipe'] = "";
				$_SESSION['IdClub'] = mysql_insert_id();
			} else {echo "<p class='center'>Le club ".stripslashes($club)." n'a pas pu être enregistré<br />".mysql_error();}
			echo "<table align='center'><tr><th><div class='bouton'><a href='".$_SESSION["RetourClub"]."'>RETOUR</a></div></th></tr></table>";
		}
	}
	mysql_close();
	exit;
}
$club = $_SESSION['club'];
$nomcomplet = $_SESSION['nomcomplet'];
$codeclub = $_SESSION['codeclub'];
$coderegionale = $_SESSION['coderegionale'];
$adresse1 = $_SESSION['adresse1'];
$adresse2 = $_SESSION['adresse2'];
$ville = $_SESSION['ville'];
$telephone = $_SESSION['telephone'];
$equipe = $_SESSION['equipe'];
?>
<form action='maj_clubsajout.php' method='post' enctype='multipart/form-data'>
<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
<table class='general' width='80%' align='center' border='1' rules='groups'>
	<colgroup><col width='50%' /><col width='*' /></colgroup>
	<tbody>
	<tr>
		<td class='right'>Nom abrégé du Club&nbsp;:</td>
		<td><input type='text' name='club' value='<?php echo $club; ?>' /> <span class='red'>*</span>(Tel qu'il apparaît sur la licence)</td>
	</tr>
	<tr>
		<td class='right'>Nom complet du Club&nbsp;:</td>
		<td><input type='text' name='nomcomplet' value='<?php echo $nomcomplet; ?>' size="50" /></td>
	</tr>
	<tr>
		<td class='right'>Code Club&nbsp;:</td>
		<td><input type='text' name='codeclub' value='<?php echo $codeclub; ?>' size='10' /> <span class='red'>*</span></td>
	</tr>
	<tr>
		<td class='right'>Régionale&nbsp;:</td>
		<td><select name="coderegionale">
			<?php
			$query = "SELECT * FROM cneac_regionales ORDER BY Regionale";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)){
				$coderegionales = $row['CodeRegionale'];
				$regionales = $row['Regionale'];
				echo "<option value='$coderegionales'";
				if ($coderegionale == $coderegionales){echo " selected";}
				echo ">$regionales / $coderegionales</option>";
			}
			?>
			</select> <span class='red'>*</span></td>
	</tr>
	<tr>
		<td></td>
		<td><a href="maj_regionalesajout.php">Si la régionale n'est pas dans la liste, cliquez ici</a></td>
	</tr>
	<tr>
		<td class='right'>Adresse 1&nbsp;:</td>
		<td><input type='text' name='adresse1' value='<?php echo $adresse1; ?>' /></td>
	</tr>
	<tr>
		<td class='right'>Adresse 2&nbsp;:</td>
		<td><input type='text' name='adresse2' value='<?php echo $adresse2; ?>' /></td>
	</tr>
	<tr>
		<td class='right'>Ville&nbsp;:</td>
		<td><input type='text' name='ville' value='<?php echo $ville; ?>' size='10' /></td>
	</tr>
	<tr>
		<td class='right'>Téléphone&nbsp;:</td>
		<td><input type='text' name='telephone' value='<?php echo $telephone; ?>' size='10' /></td>
	</tr>
	<?php
	if ($programme == "Logifly"){
		echo "<tr>
			<td class='right'>Nom de l'Equipe de Flyball&nbsp;:</td>
			<td><input type='text' name='equipe' value='<?php echo $equipe; ?>' />
			</td>
		</tr>";
	}
	?>
	</tbody>
</table>
<table class="general" border="1" rules="groups" width="80%" align="center">
<colgroup><col /><col /></colgroup>
	<tbody>
	<tr><th><div class='bouton'>
		<?php if ($_SESSION['Flag_AppelProgramme'] == "Y"){echo "<a href='".$_SESSION['RetourClubsAjout']."'>RETOUR ".$_SESSION['Activite']."</a>";} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>"; } ?>
		</th>
		<th align="right"><input type="submit" name="valider" value="Valider" /></th></tr>
	</tbody>
</table>
</form>
</body>
</html>