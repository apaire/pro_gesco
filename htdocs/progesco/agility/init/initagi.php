<?php
session_start();
$titre = "<a href='initagi.php'>Initialisation du concours</a>";
include("../utilitaires/bandeau_agi.php");
include("../utilitaires/nomvars_agi.php");
include("../../communs/connexion.php");
$_SESSION['RetourInternet'] = "../agility/init/initagi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="version" content="01.02.06" />
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<table style="width: 950px; height: 184px;" align="center">
	<tbody><tr>
		<td align="left" valign="top" width="1%"><img src="../../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td align="right" valign="top" width="1%"><img src="../../images/CNEAC.jpg" width="100" /></td>
	</tr>
</tbody></table>
<h3 class="center">INITIALISATION DU CONCOURS</h3>
<p>&nbsp;</p>
<table class="general" width="80%" align="center" border="1">
	<?php
	// Lecture fichier test
	@$fichier = file("http://sportscanins.fr/progesco/telechargements/version.csv");
	if ($fichier != ""){
		echo "<tr>
			<th>Mise à jour automatique des tables<br />Votre ordinateur doit être connecté à internet
			<table align='center'><tr><th><div class='boutonchoix'><a href='../../boiteaoutils/maj_internet.php'>MISE A JOUR DES TABLES SUR INTERNET</a></div></th></tr></table>
			</th>
		</tr>";
	}
	?>
	<tr>
		<th>Club organisateur: <?php echo $_SESSION['NomComplet']." (".$_SESSION['Club'].")"; ?>
			<table align="center"><tr><th><div class="boutonchoix"><a href="initagi_club.php">MODIFICATION DU CLUB ORGANISATEUR</a></div></th></tr></table>
		</th>
	</tr>
	<tr>
		<th>Date du concours&nbsp;: <?php echo $_SESSION['Jour']." / ".$_SESSION['Mois']." / ".$_SESSION['Annee']; ?>
			<table align="center"><tr><th><div class="boutonchoix"><a href="initagi_date.php">MODIFICATION DE LA DATE DU CONCOURS</a></div></th></tr></table>
		</th>
	</tr>
	<tr>
		<th>Type de concours&nbsp;: <?php echo $nomtypeconcourss[$_SESSION['TypeConcours']]; ?><br />
			<table align="center"><tr><th><div class="boutonchoix"><a href="initagi_typeconcours1.php">INITIALISATION DU TYPE DE CONCOURS</a></div></th></tr></table>
		</th>
	</tr>
	<tr>
		<th>Effacement de tous les concurrents déjà entrés,<br /> sans modification des informations sur le concours
			<table align="center"><tr><th><div class="boutonchoix"><a href="initagi_effacement.php">EFFACEMENT DES CONCURRENTS ENTRES</a></div></th></tr></table>
		</th>
	</tr>
</table>
<table align="center"><tr><th class="center"><div class="bouton"><a href="../agility.php">RETOUR</a></div></th></tr></table>
</body>
</html>