<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_resultatsaff.php'>Envoi des résultats sur Internet</a>";
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
<h3 class="center">Envoi des résultats sur le site Internet de la C.N.E.A.</h3>
<table align="center">
<?php
// Initialisation variables
include("../utilitaires/nomvars_agi.php");
// Connexion bdd
include("../../communs/connexion.php");
?>
<table class="general" align="center" border="1" rules="groups">
	<?php
	for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
		echo "<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww_1.php?epreuve=$epreuve'>$nomepreuveabrs[$epreuve]</a></div></th></tr>";
	}
	?>
	<tr><td>&nbsp;</td></tr>
	<?php
	if ($_SESSION['TypeConcours'] == "ChF"){
		echo "<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww_2.php?epreuve=51'>Championnat de France 2ème degré</a></div></th></tr>
		<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww_2.php?epreuve=52'>Championnat de France 3ème degré</a></div></th></tr>
		<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww_2.php?epreuve=53'>Coupe de France 2ème degré</a></div></th></tr>
		<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww_2.php?epreuve=54'>Coupe de France 3ème degré</a></div></th></tr>";
	}
	if ($_SESSION['TypeConcours'] == "GPF"){
		echo "<tr><th><div class='boutonchoixwww'><a href='pendantagi_resultatswww_2.php?epreuve=55'>Grand Prix de France</a></div></th></tr>";
	}
	?>
	<tr><td>&nbsp;</td></tr>
	<tr><th align="center"><div class="bouton"><a href="pendantagi.php">RETOUR</a></div></th></tr>
</table>

</body>
</html>