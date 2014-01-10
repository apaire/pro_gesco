<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
// Référence nouvelle version
@$fichier = file("http://sportscanins.fr/progesco/telechargements/version.csv");
if ($fichier != ""){
	$ligne = explode(":", $fichier[0]);
	$version = $ligne[1];
} else {
	echo "<h3 class='center'>Désolé, la mise à jour est momentanément inaccessible<br />
		Merci de réessayer plus tard</h3>
		<table align='center' width='100%'><tr><th><div class='boutonchoix'><a href='../progesco.php'>RETOUR</a></div></h1></th></tr></table>";
	exit;
}
if (isset($_GET['lancer'])){
	$version = str_replace(".", "-", $version);
	$fichierzip = "../../progesco_".$version.".zip";
	$fichierzipcomplet = "http://sportscanins.fr/progesco/telechargements/progesco_".$version.".zip";
	copy($fichierzipcomplet, $fichierzip); // Téléchargement de la mise à jour
	$zip = new ZipArchive();
	$zip->open($fichierzip);
	$zip->extractTo('../../');
	$zip->close();
	?>
	<h4 class="center">La mise à jour de Progesco est faite</h4>
	<p>&nbsp;</p>
	<table align='center' width='100%'><tr align="center"><th><div class='bouton'><a href='../progesco.php'>RETOUR</a></div></h1></th></tr></table>
	<?php
	exit;
}
?>

<h3 class="center">MISE A JOUR DE PROGESCO</h3>
<table class="center" width="100%">
	<tr>
		<th align="center"><div class="boutonchoix"><h3><a href="miseajourprogesco.php?lancer=Y">LANCER LA MISE A JOUR</a></h3></div></th>
	</tr>
</table>
<p>&nbsp;</p>
<table align='center' width='100%'><tr align="center"><th><div class='boutonchoix'><a href='http://sportscanins.fr/progesco/telechargements/historique.php' target="_blank">Historique des mises à jour</a></div></h1></th></tr></table>
<p>&nbsp;</p>
<table align='center' width='100%'><tr align="center"><th><div class='bouton'><a href='../progesco.php'>RETOUR</a></div></h1></th></tr></table>

</body>
</html>
