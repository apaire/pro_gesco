<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_resultatsaff.php'>Affichage des résultats</a>";
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
<h3 class="center">Affichage des résultats</h3>
<table align="center">
<?php
// Connexion bdd
include("../../communs/connexion.php");
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
$epreuve_preced = $_SESSION['Epreuve'];
$categorie_preced = $_SESSION['Categorie'];
$classe_preced = $_SESSION['Classe'];
$handi_preced = $_SESSION['Handi'];
?>
<form method="post" action="pendantagi_resultatsaff_1.php" enctype="multipart/form-data">
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /><col /></colgroup>
	<tbody>
	<tr><td align="right">Epreuve : </td><td align="right"><select name="epreuve">
		<?php
		for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
			echo "<option value='$epreuve'";
			if ($epreuve == $epreuve_preced){echo " selected='selected'";}
			echo ">$nomepreuves[$epreuve]</option>";
		}
		?>
		</select></td>
	</tr>
	<tr><td align="right">Catégorie : </td><td align="right"><select name="categorie">
		<?php
		for ($categorie = "1"; $categorie <= "4"; $categorie++){
			echo "<option value='$categorie'";
			if ($categorie == $categorie_preced){echo " selected='selected'";}
			echo ">$nomcategories[$categorie]</option>";
		}
		?>
		</select></td>
	</tr>
	<?php
	if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
		echo "<tr><td align='right'>Classe : </td><td align='right'><select name='classe'>";
		for ($classe = "1"; $classe <= "3"; $classe++){
			echo "<option value='$classe'";
			if ($classe == $classe_preced){echo " selected='selected'";}
			echo ">$nomclasses[$classe]</option>";
		}
		echo "</select></td></tr>";
	}
	?>
	<tr><td align="right">Handi : </td><td align="right"><select name="handi">
		<?php
		for ($handi = "0"; $handi <= "5"; $handi++){
			echo "<option value='$handi'";
			if ($handi == $handi_preced){echo " selected='selected'";}
			echo ">$nomhandis[$handi]</option>";
		}
		?>
		</select></td>
	</tr>
	</tbody>
	<tbody>
	<tr><th class="left"><div class="bouton"><a href="pendantagi.php">RETOUR</a></div></th><td class="right"><input type="submit" name="choixepreuve" value="Valider" /></td></tr>
	</tbody>
</table>
</form>
</body>
</html>