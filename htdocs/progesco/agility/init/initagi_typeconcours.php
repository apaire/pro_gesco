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
include("../utilitaires/lect_variables_agi.php");
if (isset($_POST['valider'])){
	//Connexion bdd
	$typeconcours = $_POST['typeconcours'];
	$_SESSION['TypeConcours'] = $typeconcours;
	include("../../communs/connexion.php");
	include("../utilitaires/nomvars_agi.php");
	$query = "TRUNCATE TABLE agility_epreuves"; // Effacement table des épreuves
	mysql_query($query);
	for ($handi = 0; $handi <= 5; $handi++){ // Remplissage table des épreuves
		for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
			for ($categorie = 1; $categorie <= 4; $categorie++){
				if ($epreuve == 3 or $epreuve == 5 or $epreuve == 8 or ($epreuve >= 13 and $epreuve <= 16)){
					$query = "INSERT INTO agility_epreuves SET Epreuve='$epreuve', Categorie='$categorie', Classe='1', Handi='$handi'";
					if (!mysql_query($query)){echo $query."<br />".mysql_error();}
				} else {
					for ($classe = 1; $classe <= 3; $classe++){
						$query = "INSERT INTO agility_epreuves SET Epreuve='$epreuve', Categorie='$categorie', Classe='$classe', Handi='$handi'";
						if (!mysql_query($query)){echo $query."<br />".mysql_error();}
					}
				}
			}
		}
	}
	// Efacement des pénalités antérieurs
	$query = "TRUNCATE TABLE agility_penalants";
	if (!mysql_query($query)){echo $query."<br />".mysql_error();}
	// Effacement concurrents
	$query = "UPDATE cneac_licences SET AGI1='N'";
	if (!mysql_query($query)){echo $query."<br />".mysql_error();}
	$query = "TRUNCATE TABLE agility_resultats";
	if (!mysql_query($query)){echo $query."<br />".mysql_error();}
	$query = "TRUNCATE TABLE agility_reglescumuls";
	if (!mysql_query($query)){echo $query."<br />".mysql_error();}
	$query = "TRUNCATE TABLE agility_resultatscumuls";
	if (!mysql_query($query)){echo $query."<br />".mysql_error();}
	$_SESSION['Concurrents'] = "";
	$_SESSION['Dossards'] = "";
	$_SESSION['OrdresPassage'] = "";
	include("../utilitaires/ecrit_variables_agi.php");
	include("initagi.php");
	exit;
}

$titre = "<a href='initagi.php'>Initialisation du concours</a> &gt; <a href='initagi_typeconcours.php'>Modification du Type de concours</a>";
include("../utilitaires/bandeau_agi.php");
// Concurrents déjà entrés
if ($_SESSION['Concurrents'] == "entres"){
	echo "<p class='center'><span class='alert'>&nbsp;ATTENTION&nbsp;: des concurrents ont été enregistrés. Si vous modifiez le type de concours, ces concurrents seront effacés&nbsp;</span></p>";
}
include("../utilitaires/lect_variables_agi.php");
?>
<h3 class="center">Modification du type de concours</h3>
<form action='initagi_typeconcours.php' method='post' enctype="multipart/form-data">
<table class="general" align="center" width="80%" border="0">
	<tr><th><h3 class='center'><span class='alarm'>&nbsp;ATTENTION&nbsp;: en cliquant sur "Valider" vous effacerez les concurrents&nbsp;<br />&nbsp;et les résultats enregistrés précédemment&nbsp;<br />&nbsp; cette validation est cependant nécessaire pour un nouveau concours ce qui permet de vider les tables de la base de donnée, ce qui n'est pas réalisé en cliquant juste sur retour&nbsp;</span></h3></th></tr>
</table>
<table class="general" align="center" width="80%" border="1" rules="groups">
	<colgroup><col /><col /></colgroup><col />
	<tbody><tr><th colspan="2">Type de concours</th><th>Epreuves</th></tr></tbody>
	<tbody>
<?php
if ($_SESSION['Finale'] != "Y"){
	echo "<tr><th align='right'>Concours Classique :</th><th><input type='radio' name='typeconcours' value='CC'";
	if ($_SESSION['TypeConcours'] == "CC"){echo " checked='checked'";}
	echo " /></th><td>1er, 2ème, 3ème degré, Open, Open +, Grand Prix de France, Jumping, Jumping +</td></tr><tr><th align='right'>Championnat Régional :</th><th><input type='radio' name='typeconcours' value='ChR'";
	if ($_SESSION['TypeConcours'] == "ChR"){echo " checked='checked'";}
	echo " /></th><td valign='absmiddle'>Championnat Régional et Coupe Régionale 2ème et 3ème degré, Manches 1 & 2</td></tr><tr><th align='right'>Sélectif GPF :</th><th><input type='radio' name='typeconcours' value='SGPF'";
	if ($_SESSION['TypeConcours'] == "SGPF"){echo " checked='checked'";}
	echo " /></th><td valign='absmiddle'>Sélectif au Grand Prix de France, Manches 1 & 2</td></tr><tr><th align='right'>Championnat Régional + Sélectif GPF :</th><th><input type='radio' name='typeconcours' value='ChRSGPF'";
	if ($_SESSION['TypeConcours'] == "ChRSGPF"){echo " checked='checked'";}
	echo " /></th><td>Epreuves du Championnat Régional et du Sélectif GPF</td></tr><tr><th align='right'>Concours Complet :</th><th><input type='radio' name='typeconcours' value='Comp'";
	if ($_SESSION['TypeConcours'] == "Comp"){echo " checked='checked'";}
	echo " /></th><td>Toutes les épreuves ci-dessus</tr>";
} else {
	echo "<tr><th align='right'>Championnat de France :</th><th><input type='radio' name='typeconcours' value='ChF'";
	if ($_SESSION['TypeConcours'] == "ChF"){echo " checked='checked'";}
	echo " /></th></tr><tr><th align='right'>Grand Prix de France :</th><th><input type='radio' name='typeconcours' value='GPF'";
	if ($_SESSION['TypeConcours'] == "GPF"){echo " checked='checked'";}
	echo " /></th></tr>";
}
?>
</table>
<table class="general" align="center" width="80%" border="1" rules="groups">
<table align="center"><tr><th class"center"><div class="bouton"><input type="submit" name="valider" value="Valider" /></td>
	</tr>
	<tr>
		<th class="center"><div class="bouton"><a href="initagi_avert.php">RETOUR</a></div></th>
	</tr>
</table>
</form>
</body>
</html>