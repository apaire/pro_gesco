<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_passages.php'>Attribution des ordres de passage</a>";
include("../utilitaires/bandeau_agi.php");
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
<h3 class="center">Attribution des ordres de passage</h3>
<?php
// Connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");

// Annulation ordres de passage
if (isset($_POST['annulerordres'])){
	$_SESSION['OrdresPassage'] = "";
	include("../utilitaires/ecrit_variables_agi.php");
	$query = "UPDATE agility_resultats SET OrdrePassage='0'";
	if (!mysql_query($query)){echo "<p class='center'>".mysql_error();}
	else {
		?>
		<p class='center'>Les ordres de passage ont été annulés</p>
		<p class='center'><a href='avantagi_passages.php'>Vous pouvez relancer l'attribution des ordres de passage en cliquant ICI</a></p>
		<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th></tr></table>
		<?php
		$_SESSION['OrdresPassage'] = "";
		include("../utilitaires/ecrit_variables_agi.php");
	}
	exit;
}

// Ordres de passage déjà attribués
if ($_SESSION['OrdresPassage'] == "attribues"){
	?>
	<p class='center'><span class='alert'>&nbsp;Les ordres de passage ont déjà été attribués&nbsp;</span></p>
	<p class='center'>Si vous voulez relancer l'attribution, vous devez d'abord annuler l'attribution précédente</p>
	<form method='post' action='avantagi_passages.php' enctype="multipart/form-data">
	<table class="general" align="center" border="1" rules="groups" width="80%">
		<colgroup><col width="50%" /><col width="*" /></colgroup>
		<tr><th class="left"><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th><th class="right"><input type='submit' name='annulerordres' value='Annuler ordres de passage' /></th></tr>
	</table>
	</form>
	<?php
	exit;
}

// Attribution ordres de passage
$query = "SELECT * FROM agility_epreuves ORDER BY Epreuve, Categorie, Classe, Handi";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$idepreuve = $row['Id'];
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$query = "SELECT Id FROM agility_resultats WHERE IdEpreuve='$idepreuve' ORDER BY RAND()";
	$result1 = mysql_query($query);
	$ordrepassage = 1;
	while ($row1 = mysql_fetch_assoc($result1)){
		$id = $row1['Id'];
		$query = "UPDATE agility_resultats SET OrdrePassage='$ordrepassage' WHERE Id='$id'";
		if (!mysql_query($query)){echo mysql_error()."<br />";}
		$ordrepassage++;
	}
}
?>
<p class='center'>Les ordres de passage ont été attribués</p>
<p class='center'>Pour les nouveaux concurrents enregistrés, un ordre de passage sera attribué automatiquement.</p>
<p class='center'>Les ordres de passage peuvent être changés en cliquant sur l'option <a href='avantagi_passagesmodif.php?ordre=Epreuve'>Modification manuelle des ordres de passage</a></p>
<table align='center'><tr><th><div class='bouton'><a href='avantagi.php'>RETOUR</a></div></th></tr></table>
<?php
$_SESSION['OrdresPassage'] = "attribues";
include("../utilitaires/ecrit_variables_agi.php");
mysql_close();
?>
</body>
</html>