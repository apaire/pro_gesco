<?php
session_start();
$titre = "<a href='".$_SESSION["RetourJugesAjout"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_jugesajout.php'>Ajout d'un Juge</a>";
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
<h3 class="center">Ajout d'un Juge</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_POST['valider'])){
	$civilite = $_POST['civilite'];
	$nom = mb_strtoupper($_POST['nom'], "UTF-8");
	$prenom = $_POST['prenom'];
	$_SESSION['civilite'] = $civilite;
	$_SESSION['nom'] = $nom;
	$_SESSION['prenom'] = $prenom;
	if (($nom == "") or ($prenom == "")){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez obligatoirement entrer le Nom et le Prénom du Juge&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_jugesajout.php'>RETOUR</a></div></th></tr></table>";
		mysql_close();
		exit;
	} else {
		$nom = mysql_real_escape_string($nom);
		$prenom = mysql_real_escape_string($prenom);
		$query = "INSERT INTO cneac_juges SET Titre='$civilite', Nom='$nom', Prenom='$prenom'";
		if (!mysql_query($query)){echo $query."<br />".mysql_error();} else {echo "<p class='center'>Le juge $nom $prenom a été enregistré</p>";}
		$_SESSION['civilite'] = "";
		$_SESSION['nom'] = "";
		$_SESSION['prenom'] = "";
		echo "<table align='center'><tr><th><div class='bouton'><a href='";
		if ($_SESSION['Flag_AppelProgramme'] == "Y"){echo $_SESSION['RetourJugesAjout']."'>RETOUR ".$_SESSION['Activite'];} else {echo "boiteaoutils.php'>RETOUR Boîte à Outils"; }
		echo "</a></th></tr></table>";
		exit;
	}
}
$civilite = $_SESSION['civilite'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
mysql_close();
?>
<form action="maj_jugesajout.php" method="post" enctype="multipart/form-data">
<p class="center">(<span class="red">*</span> = paramètre obligatoire)</p>
<table class="general" width="80%" align="center" border="1" rules="groups">
	<colgroup><col width="50%" /><col width="*" /></colgroup>
	<tbody>
	<tr>
		<td class="right">Titre&nbsp;:</td>
		<td>Mr <input type="radio" name="civilite" value="M" <?php if ($civilite == "M"){echo "checked";} ?> /> /
		Mme <input type="radio" name="civilite" value="Mme" <?php if ($civilite == "Mme"){echo "checked";} ?> /> /
		Mlle <input type="radio" name="civilite" value="Mlle" <?php if ($civilite == "Mlle"){echo "checked";} ?> /></td>
	</tr>
	<tr>
		<td class="right">Nom du Juge&nbsp;:</td>
		<td><input type="text" name="nom" value="<?php echo $nom; ?>" size="40" /> <span class="red">*</span></td>
	</tr>
	<tr>
		<td class="right">Prénom du Juge&nbsp;:</td>
		<td><input type="text" name="prenom" value="<?php echo $prenom; ?>" size="40" /> <span class="red">*</span></td>
	</tr>
	</tbody>
	<tbody>
	<tr>
		<td class="right" colspan="2"><input type="submit" name="valider" value="Valider" /></td>
	</tr>
	</tbody>
</table>
</form>

<table align='center'><tr><th><div class='bouton'><a href='
<?php if ($_SESSION['Flag_AppelProgramme'] == "Y"){echo $_SESSION['RetourJugesAjout']."'>RETOUR ".$_SESSION['Activite'];} else {echo "boiteaoutils.php'>RETOUR Boîte à Outils"; } ?>
</a></th></tr></table>

</body>
</html>