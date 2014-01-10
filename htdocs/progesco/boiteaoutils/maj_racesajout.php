<?php
session_start();
$titre = "<a href='".$_SESSION["RetourRacesAjout"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_racesajout.php'>Ajout d'une Race</a>";
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
<h3 class="center">Ajout d'une Race</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_POST['valider'])){
	$coderace = $_POST['coderace'];
	$race = $_POST['race'];
	$_SESSION['coderace'] = $coderace;
	$_SESSION['race'] = $race;
	$race = mysql_real_escape_string($race);
	if (($coderace == "") or ($race == "")){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez obligatoirement entrer le Code Race et la Race&nbsp;</span></p>";
	} else {
		$query = "INSERT INTO cneac_races SET CodeRace='$coderace', Race='$race'";
		if (!mysql_query($query)){echo mysql_error();}
		else {echo "<p class='center'>La race ".stripslashes($race)." a été enregistrée</p>";
			$_SESSION['coderace'] = "";
			$_SESSION['race'] = "";
		}
	}
	echo "<table align='center'><tr><th><div class='bouton'><a href='maj_racesajout.php'>RETOUR</a></div></th></tr></table>";
	mysql_close();
	exit;
}
$coderace = $_SESSION['coderace'];
$race = $_SESSION['race'];
mysql_close();
?>

<form action="maj_racesajout.php" method="post" enctype="multipart/form-data">
<p class="center">(<span class="red">*</span> = paramètre obligatoire)</p>
<table class="general" width="80%" align="center" border="1" rules="groups">
	<colgroup><col width="50%" /><col width="*" /></colgroup>
	<tbody>
	<tr>
		<td class="right">Code race&nbsp;:</td>
		<td><input type="text" name="coderace" value="<?php echo $coderace; ?>" size="40" /> <span class="red">*</span></td>
	</tr>
	<tr>
		<td class="right">Race&nbsp;:</td>
		<td><input type="text" name="race" value="<?php echo $race; ?>" size="40" /> <span class="red">*</span></td>
	</tr>
	</tbody>
	<tbody>
	<tr>
		<th><div class='bouton'>
			<?php if ($_SESSION['Flag_AppelProgramme'] == "Y"){echo "<a href='".$_SESSION['RetourRacesAjout']."'>RETOUR ".$_SESSION['Activite']."</a>";} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>"; } ?>
			</div>
		</th>
		<td class="right"><input type="submit" name="valider" value="Valider" /></td>
	</tr>
</table>
</form>

</body>
</html>