<?php
session_start();
$titre = "<a href='boiteaoutils.php'>Boite A Outils</a> &gt; <a href='maj_tableinternet.php'>Mise à jour des tables sur internet</a>";
include("bandeau_bao.php");
include("../communs/connexion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$msg = "";
// Définition table
$table = "cneac_".$_GET['table'];
if ($table == "cneac_licences"){
	// Sauvegarde de la table pour les adresses
	$query = "DROP TABLE cneac_licences_old";
	mysql_query($query);
	$query = "RENAME TABLE cneac_licences TO cneac_licences_old";
	mysql_query($query);
}
// Création nouvelle table
//$table ="cneac_licences";
include("maj_internet_1.php");
	// Récupération des adresses des licences
//	$query = "SELECT * FROM cneac_licences_old WHERE Adresse1<>''";
//	$result = mysql_query($query);
//	while ($row = mysql_fetch_assoc($result)){
//		$query = "SELECT Id FROM cneac_licences WHERE Licence='".$row['Licence']."' AND Nom='".$row['Nom']."' AND Prenom='".$row['Prenom']."'";
//		$result1 = mysql_query($query);
//		$row1 = mysql_fetch_assoc($result1);
//		$query = "UPDATE cneac_licences SET Adresse1='".mysql_real_escape_string($row['Adresse1'])."', Adresse2='".mysql_real_escape_string($row['Adresse2'])."', CP='".$row['CP']."', Ville='".mysql_real_escape_string($row['Ville'])."', Email='".$row['Email']."', Telephone='".$row['Telephone']."' WHERE Id='".$row1['Id']."'";
//		mysql_query($query);
//		$query = "DROP TABLE cneac_licences_old";
//		mysql_query($query);
//	}
//}
// Affichage messages
echo $msg;
?>
<table align='center'><tr><th><div class='bouton'><?php if ($_SESSION['Flag_AppelProgramme'] == "Y"){echo "<a href='".$_SESSION['RetourInternet']."'>RETOUR ".$_SESSION['Activite']."</a>";} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>"; } ?></div></th></tr></table>
</body>
</html>