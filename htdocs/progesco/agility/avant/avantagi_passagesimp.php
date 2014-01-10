<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_passagesimp.php'>Impression des ordres de passage</a>";
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
<h3 class="center">Impression des ordres de passage</h3>
<table class="general" align='center'>
	<tr><th>Par ordre de passage</th><th>Par numéro de Dossard</th></tr>
	<tr>
		<th><div class='boutonimp'><a href='avantagi_passagesimp_3.php' target='_blank'>LISTE ABR&Eacute;G&Eacute;E</a></div></th>
		<th>&nbsp;</th>
	</tr>
	<tr><th></th></tr>	
	<tr>
		<th><div class='boutonimp'><a href='avantagi_passagesimp_0.php?ordre=OrdrePassage' target='_blank'>TOUTES LES EPREUVES</a></div></th>
		<th><div class='boutonimp'><a href='avantagi_passagesimp_0.php?ordre=Dossard' target='_blank'>TOUTES LES EPREUVES</a></div></th>
	</tr>
	<tr><th></th></tr>	
	<?php
	include("../utilitaires/nomvars_agi.php");
	for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
		if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
			echo "<tr><th><div class='boutonimp'><a href='avantagi_passagesimp_1.php?ordre=OrdrePassage&epreuve=$epreuve' target='_blank'>$nomepreuves[$epreuve]</a></div></th>
			<th><div class='boutonimp'><a href='avantagi_passagesimp_1.php?ordre=Dossard&epreuve=$epreuve' target='_blank'>$nomepreuves[$epreuve]</a></div></th></tr>";
		}
	}
	?>
	<tr><td></td></tr>
	<tr><th align="center" colspan="2"><div class="bouton"><a href="avantagi.php">RETOUR</a></div></th></tr>
</table>
</body>
</html>