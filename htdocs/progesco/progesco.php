<?php 
session_start();
session_unset();
include("communs/connexion.php"); // Connexion base de données locale
if (mysql_num_rows(mysql_query("SHOW DATABASES LIKE '$bdd'")) == 0){
	// Création de la base de données
	include("communs/creation_db.php");
}
include("communs/declaration_variables.php");
include("communs/lect_variables_genes.php");
$versioncomplete = "01.02.06";
$_SESSION['Version'] = substr($versioncomplete, 0, 2); // Version en cours
$_SESSION['SousVersion'] = substr($versioncomplete, 3, 5);
include("communs/ecrit_variables_genes.php");
$_SESSION['Finale'] = "N";
$_SESSION['Local'] = "Y";
if (!$dossier = @dir("CNEAC")){mkdir("CNEAC");} // Création du dossier CNEAC s'il n'existe pas
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>PROGESCO</title>
<link href="communs/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<table style="width: 950px; height: 174px;" align="center">
	<tbody><tr>
		<td rowspan="2" align="left" valign="top" width="1%"><img src="images/SCC.jpg" width="100"></td>
		
		<td valign="middle" width="*">
			<h1 class="center"><br>
<span class=""></span></h1>
      <h1 style="font-family: Optima;" class="center"><span class="">SOCIÉTÉ CENTRALE CANINE </span></h1>

			<h2 class="center"><span class="">Commission Nationale Education et Activités Cynophiles</span></h2>
		</td>
		<td align="right" valign="top" width="1%"><img src="images/CNEAC.jpg" width="100"></td>
	</tr>
</tbody></table>
<table style="width: 964px; height: 586px;" align="center">
	<tbody><tr><td><h1 class="center"><a href="agility/agility.php"><img style="border: 0px solid ; width: 950px; height: 550px;" alt="fond" src="images/ProgescoAgility1.jpg"></a></h1></td></tr>
</tbody></table>
<table class="general" align="center" border="2" rules="groups" width="950">
	<colgroup><col width="20"><col width="1*"><col width="20"></colgroup>
	<tbody><tr><td><br>
</td>
		<th>
			<h4 class="center">Application mise à la disposition de tous les <br>Organisateurs d'un Concours d'Agility de la CNEAC</h4>
		</th>
	</tr>
</tbody></table>
<table class="general" align="center" border="2" rules="groups" width="950">
	<colgroup><col width="20"><col width="1*"><col width="20"></colgroup>
	<tbody><tr><td><br>
</td>
		<th>
			<h3 class="center">Progiciel réalisé par Jean-Pierre Tourrès et modifié en 2012 par le GT informatique</h3>
			<h4 class="center">Version : <?php echo $_SESSION['Version'].".".$_SESSION['SousVersion']; ?>   concours classiques uniquement</h4>
			<p class="center">Remerciements
à toutes les personnes qui ont œuvré jusqu'à maintenant au développement des logiciels de gestion de l'Agility.<br> Ce progiciel est leur héritier.</p>
		</th>
		<td><br>
</td>
	</tr>
</tbody></table>
<?php // Vérification si dernière version
if ($_GET['maj'] != "n"){
	@$fichier = file("http://sportscanins.fr/progesco/telechargements/version.csv");
	if ($fichier != ""){
		$ligne = explode(":", $fichier[0]);
		$version = $ligne[1];
		if ($version > $versioncomplete){ // Nouvelle version disponible
			?>
			<table align="center" width="100%">
				<tbody><tr><th><h1 align="center">Une Mise à jour de Progesco est disponible</h1></th></tr>
				<tr><th align="center"><h3><div class="boutonchoix"><a href="communs/miseajourprogesco.php">INSTALLER LA MISE A JOUR</a></div></h3></th></tr>
			</tbody></table>
			<?php }
		}
	}