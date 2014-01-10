<?php
session_start();
$retourprogramme = "../".$_SESSION['Programme']."/".$_SESSION['Programme'].".php";
$titre = "<a href='../".$_SESSION['Programme']."/".$_SESSION['Programme'].".php'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a>";
include("bandeau_bao.php");
include("../communs/connexion.php");
include("../communs/lect_variables_genes.php");
$_SESSION['Flag_AppelProgramme'] = "N";
$_SESSION['drapeau_retour'] = "";
// Initialisation des variables
$_SESSION['Civilite'] = "";
$_SESSION['IdLicence'] = "";
$_SESSION['Licence'] = "";
$_SESSION['Nom'] = "";
$_SESSION['Prenom'] = "";
$_SESSION['Club'] = "";
$_SESSION['NomComplet'] = "";
$_SESSION['CodeClub'] = "";
$_SESSION['CodeRegionale'] = "";
$_SESSION['Adresse1'] = "";
$_SESSION['Adresse2'] = "";
$_SESSION['Ville'] = "";
$_SESSION['Telephone'] = "";
$_SESSION['Equipe'] = "";
$_SESSION['CodeRace'] = "";
$_SESSION['Race'] = "";
// Variables de retour
$_SESSION['RetourClubsAjout'] = "../".$_SESSION['Programme']."/".$_SESSION['Programme'].".php";
$_SESSION['RetourClubsModif'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourJugesAjout'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourJugesModif'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourLicencesAjout'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourLicencesModif'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourRacesAjout'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourRacesModif'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourRegionalesAjout'] = $_SESSION['RetourClubsAjout'];
$_SESSION['RetourRegionalesModif'] = $_SESSION['RetourClubsAjout'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo "<title>";
if ($_SESSION['Programme'] == "agility"){echo "PROGAGIL ".$_SESSION['version'];}
if ($_SESSION['Programme'] == "flyball"){ echo "FLYBALL ".$_SESSION['version'];}
echo "</title>";
?>
<meta name="version" content="01.02.06" />
<meta name="author" content="GT info" />
<meta name="copiryght" content="J.P Tourrès" />
<link href="../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<table style="width: 950px; height: 184px;" align="center">
	<tbody><tr>
		<td align="left" valign="top" width="1%"><img src="../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td align="right" valign="top" width="1%"><img src="../images/CNEAC.jpg" width="100" /></td>
	</tr>
</tbody></table>
<body onload="parent.Bandeau.location.href='boiteaoutils_bandeau.php'">
<table class="general" width="950" align="center" border="1" rules="groups">
	<colgroup><col /><col /><col /><col /></colgroup>
	<tbody>
	<tr><th rowspan="2">TABLE DES JUGES</th>
		<th><div class="boutonchoixetroit"><a href="maj_jugesmodif.php">Modification d'un Juge</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_jugesajout.php">Ajout d'un Juge</a></div></th>
		<th rowspan="2"><div class="boutonchoixetroit"><a href="maj_tableinternet.php?table=juges">Mise à jour sur Internet</a></div></th>
	</tr>
	<tr><th><div class="boutonchoixetroit"><a href="maj_tableexport.php?table=juges">Exportation de la table</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_tableimport.php?table=juges">Importation d'une table</a></div></th>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="2">TABLE DES CLUBS</th>
		<th><div class="boutonchoixetroit"><a href="maj_clubsmodif.php">Modification d'un Club</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_clubsajout.php">Ajout d'un Club</a></div></th>
		<th rowspan="2"><div class="boutonchoixetroit"><a href="maj_tableinternet.php?table=clubs">Mise à jour sur Internet</a></div></th>
	</tr>
	<tr><th><div class="boutonchoixetroit"><a href="maj_tableexport.php?table=clubs">Exportation de la table</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_tableimport.php?table=clubs">Importation d'une table</a></div></th>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="3">TABLE DES LICENCES</th>
		<th colspan="3"><span class="alarm">&nbsp;Attention, la mise à jour de la table sur internet effacera les concurrents déjà enregistrés&nbsp;<br /> TOUTES DISCIPLINES CONFONDUES</span></th>
	</tr>
	<tr>
		<th><div class="boutonchoixetroit"><a href="maj_licencesmodif.php">Modification Licence</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_licencesajout.php">Ajout d'une Licence</a></div></th>
		<th rowspan="2"><div class="boutonchoixetroit"><a href="maj_tableinternet.php?table=licences">Mise à jour sur Internet</a></div></th>
	</tr>
	<tr><th><div class="boutonchoixetroit"><a href="maj_tableexport.php?table=licences">Exportation de la table</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_tableimport.php?table=licences">Importation d'une table</a></div></th>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="2">TABLE DES RACES</th>
		<th><div class="boutonchoixetroit"><a href="maj_racesmodif.php">Modification d'une Race</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_racesajout.php">Ajout d'une Race</a></div></th>
		<th rowspan="2"><div class="boutonchoixetroit"><a href="maj_tableinternet.php?table=races">Mise à jour sur Internet</a></div></th></tr>
		<tr><th><div class="boutonchoixetroit"><a href="maj_tableexport.php?table=races">Exportation de la table</a></div></th>
		<th><div class="boutonchoixetroit"><a href="maj_tableimport.php?table=races">Importation d'une table</a></div></th>
	</tr>
	</tbody>
</table>
<br />
<table align="center">
	<tr><th><table align="center"><tr><th class="center"><div class="bouton"><a href="<?php echo $retourprogramme; ?>" target="_top">RETOUR</a></div></th></tr></table></th></tr>
</table>

</body>
</html>