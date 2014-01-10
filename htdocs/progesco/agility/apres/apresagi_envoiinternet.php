<?php
session_start();
$titre = "<a href='apresagi.php'>Après le concours</a> &gt; <a href='apresagi_envoiinternet.php'>Envoi par internet</a>";
include("../utilitaires/bandeau_agi.php");
include("../utilitaires/bandeau_logos1.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<body>
<?php
$disques = explode("/", $_SERVER['DOCUMENT_ROOT']);
$d = $disques[0]."/";
$fichier = $_SESSION['Fichierzip'];
?>
<table class="general" align="center" width="80%" border="1" rules="groups">
	<tr><th>Attention : cette fonction n'est valable que si vous avez une connexion internet et n'est pas disponible sur tous les ordinateurs.<br 
	<tr><th>&nbsp;</th></tr>
	<tr><th>Dans ce cas, envoyez le fichier zip et le fichier de résultats (.SQL) qui se trouvent dans le dossier CNEAC dès que vous retouverez une connexion internet a votre CTR.</th></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th align="center"><div class="boutonchoix"><a href="mailto:ctr_regionx@orange.fr?bcc=progesco@sportscanins.fr&subject=Fichier .zip de centralisation et fichier SQL pour l'affichage des résultats&body=ajoutez en pièce jointe le fichier agility_nom_du_club_2013moisjour.zip et le fichier de ce format agility_MFA_20121111_Nov131048.sql qui se trouvent dans le dossier CNEAC merci !<?php echo $msg; ?>">ENVOI des fichiers centralisation (fichier zip) et resultats (fichier SQL)</a></div></th></tr>
	<tr><th>&nbsp;</th></tr>
   </table>
<table align="center"><tr><th><div class="bouton"><a href="apresagi.php">RETOUR</a></div></th></tr></table>
</body>
</html>
