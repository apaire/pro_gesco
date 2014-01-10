<?php
session_start();
$titre = "<a href='initagi_avert.php'>AVERTISSEMENT</a>";
include("../utilitaires/bandeau_agi.php");
?>
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
<h3 class="center">PROGESCO AGILITY</h3>
<h4 class="center">Version <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></h4>

<p>&nbsp;</p>
<table class="general" width="80%" align="center" border="1">
	<tr><th>Attention,pour que le logiciel fonctionne correctement il est obligatoire de validez l'initialisation du concours dans l'écran suivant,
		ceci aura pour conséquence  d'effacer les concurrents inscrits ainsi que les résultats déja enregistrés.
	</th></tr>
</table>
<table align="center"><tr><th class="center"><div class="bouton"><a href="initagi_typeconcours1.php">CONTINUER</a></div></th></tr></table>
<table align="center"><tr><th class="center"><div class="bouton"><a href="../agility.php">RETOUR</a></div></th></tr></table>
</body>
</html>