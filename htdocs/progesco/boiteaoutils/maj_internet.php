<?php
session_start();
$titre = "<a href='".$_SESSION['RetourInternet']."'>".$_SESSION['Activite']."</a> &gt; <a href='maj_internet.php'>Mise à jour des tables sur internet</a>";
include("bandeau_bao.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if ($_GET['valider'] == "valider"){
	$msg = "";
	// Définition table
	$table = "cneac_clubs";
	include("maj_internet_1.php");
	
	$table = "cneac_regionales";
	include("maj_internet_1.php");
	
	// Sauvegarde de la table pour les adresses
	$query = "RENAME TABLE cneac_licences TO cneac_licences_old";
	mysql_query($query);
	// Création nouvelle table
	$table = "cneac_licences";
	include("maj_internet_1.php");
	// Récupération des adresses des licences
	//$query = "SELECT * FROM cneac_licences_old WHERE Adresse1<>''";
	//$result = mysql_query($query);
	//while (@$row = mysql_fetch_assoc($result)){
		//$query = "SELECT Id FROM cneac_licences WHERE Licence='".$row['Licence']."' AND Nom='".$row['Nom']."' AND Prenom='".$row['Prenom']."'";
		//$result1 = mysql_query($query);
		//if (mysql_num_rows($result1) > 0){
		//	$row1 = mysql_fetch_assoc($result1);
		//	$query = "UPDATE cneac_licences SET Adresse1='".mysql_real_escape_string($row['Adresse1'])."', Adresse2='".mysql_real_escape_string($row['Adresse2'])."', CP='".$row['CP']."', Ville='".mysql_real_escape_string($row['Ville'])."', Email='".$row['Email']."', Telephone='".$row['Telephone']."' WHERE Id='".$row1['Id']."'";
		//	mysql_query($query);
		//}
	//}
	$query = "DROP TABLE cneac_licences_old";
	mysql_query($query);

	$table = "cneac_juges";
	include("maj_internet_1.php");
	
	$table = "cneac_races";
	include("maj_internet_1.php");
	
	$table = "cneac_variables";
	include("maj_internet_1.php");
	include("../communs/ecrit_variables_genes.php");
	
	// Effacement des tables Agility et Flyball
	$tables = array("logifly_brassage", "logifly_resbrassage", "logifly_tournoi", "agility_epreuves", "agility_penalants", "agility_reglescumuls", "agility_resultats", "agility_resultatscumuls");
	foreach($tables as $table){
		$query = "TRUNCATE TABLE $table";
		mysql_query($query);
	}
	
	// Affichage messages
	echo $msg."<table align='center'><tr><th><div class='bouton'><a href='".$_SESSION['RetourInternet']."'>RETOUR</a></div></th></tr></table>";
	exit;
}?>
<h3 class="center">Mise à jour des tables sur Internet</h3>
<p class="center">Cette opération permet d'avoir les tables à la dernière version enregistrée sur le site de la C.N.E.A.C.</p>
<h3 class="center"><span class="alarm">&nbsp;ATTENTION&nbsp;: cette mise à jour effacera de façon irréversible les concurrents déjà enregistrés&nbsp;<br />&nbsp;TOUTES DISCIPLINES CONFONDUES&nbsp;</span></h3>
<table class="general" align="center">
	<tr><th><div class="boutonchoix"><a href="maj_internet.php?valider=valider">LANCER LA MISE A JOUR</a></div></th></tr>
	<tr><th align="center"><div class="bouton"><a href="<?php echo $_SESSION['RetourInternet']; ?>">RETOUR</a></div></th></tr>
</table>
<?php $_SESSION['Connecte'] = "YES"; ?>
</body>
</html>