<?php
session_start();
//$retour = $_SESSION['RetourRegionalesAjout'];
$titre = "<a href='".$_SESSION['RetourRegionalesAjout']."'>".$_SESSION['Programme']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_regionalesajout.php'>Ajout d'une Régionale</a>";
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
<h3 class="center">Ajout d'une Régionale</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_POST['validerregionale'])){
	$regionale = $_POST['regionale'];
	$coderegionale = $_POST['coderegionale'];
	$_SESSION['regionale'] = $regionale;
	$_SESSION['coderegionale'] = $coderegionale;
	if ((strlen($regionale) < 3) or ($coderegionale == "")){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez obligatoirement entrer le Nom et le Code de la Régionale&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_regionalesajout.php'>RETOUR</a></div></th></tr></table>";
	} else {
		$query = "SELECT Id FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			echo "<p class='center'><span class='alert'>&nbsp;ATTENTION : une Régionale est déjà enregistrée avec le code $coderegionale&nbsp;</span></p>
			<table align='center'><tr><th><div class='bouton'><a href='maj_regionalesajout.php'>RETOUR</a></div></th></tr></table>";			
		} else {
			$query = "INSERT INTO cneac_regionales SET Regionale='$regionale', CodeRegionale='$coderegionale'";
			if (!mysql_query($query)){
				echo $query."<br />".mysql_error();
			} else {
				echo "<p class='center'>La Régionale $regionale a été enregistrée</p>
				<table align='center'><tr><th><div class='bouton'><a href='".$_SESSION['RetourRegionalesAjout']."'>RETOUR</a></div></th></tr></table>";
				$_SESSION['regionale'] = "";
			}
		}
	}
	mysql_close();
	exit;
}
$regionale = $_SESSION['regionale'];
$coderegionale = $_SESSION['coderegionale'];
?>
<form action='maj_regionalesajout.php' method='post' enctype='multipart/form-data'>
<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
<table class='general' width='80%' align='center' border='1' rules='groups'>
	<colgroup><col width='50%' /><col width='*' /></colgroup>
	<tbody>
	<tr>
		<td class='right'>Nom de la Régionale&nbsp;:</td>
		<td><input type='text' name='regionale' value='<?php echo $nom; ?>' /> <span class='red'>*</span></td>
	</tr>
	<tr>
		<td class='right'>Code Régionale&nbsp;:</td>
		<td><input type='text' name='coderegionale' value='<?php echo $coderegionale; ?>' size='10' /></td>
	</tr>
	</tbody>
</table>
<table class="general" align="center" width="80%" border="1" rules="groups">
	<tr><th class="left"><div class="bouton"><a href="<?php echo $_SESSION['RetourRegionalesAjout']; ?>">RETOUR</a></div></th><td class="right"><input type="submit" name="validerregionale" value="Valider" /></td></tr>
</table>
</form>
</body>
</html>