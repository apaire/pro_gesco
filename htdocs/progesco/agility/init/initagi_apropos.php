<?php
session_start();
$titre = "<a href='initagi_apropos.php'>A propos</a>";
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
	<table style="width: 950px; height: 184px;" align="center">
	<tbody><tr>
		<td align="left" valign="top" width="1%"><img src="../../images/SCC.jpg" width="100" /></td>
		<td width="*"><h1 class="center">PROGESCO AGILITY<br /><small><small>Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?></small></small></h1></td>
		<td align="right" valign="top" width="1%"><img src="../../images/CNEAC.jpg" width="100" /></td>
	</tr>
</tbody></table>

<p>&nbsp;</p>
<table class="general" width="80%" align="center" border="1">
	<tr><th>Ce progiciel est l'héritier de 20 ans de pratique de l'agility.<br />
	Il est mis gratuitement à la disposition des clubs affiliés à la SCC par l'intermédiaire de leur Régionale.<br />
	<br />
	Merci à tous ceux et toutes celles qui ont contribué à son élaboration, et en particulier à :<br />
	Mr Maurice Fraise<br />
	<br />
	Ce progiciel n'est pas un aboutissement mais une simple étape ... l'aventure continue, au bénéfice de nos amis à quatre pattes.
	</th></tr>
</table>
<table align="center"><tr><th class="center"><div class="bouton"><a href="../agility.php">RETOUR</a></div></th></tr></table>
</body>
</html>