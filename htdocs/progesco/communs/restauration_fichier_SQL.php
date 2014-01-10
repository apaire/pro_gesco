<?php
session_start();
$retourprogramme = "../".$_SESSION['Programme']."/".$_SESSION['Programme'].".php";
$titre = "<a href='../".$_SESSION['Programme']."/".$_SESSION['Programme'].".php'>".$_SESSION['Activite']."</a>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="version" content="01.02.06" />
<meta name="author" content="GT info" />
<meta name="copyright" content="J.P Tourrès" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
include("bandeau_gene.php");
include("connexion.php");

// Chemin du fichier
$nomfichier = $_GET['concours'];
$fichier = "../../../CNEAC/".$nomfichier;

// Importer le fichier SQL dans la base
function importerSQL($fichier)
{
	  $file = file_get_contents($fichier);
	  if($file === false){
		die('<br>Erreur lors de l importation des tables dans la base de donnee !');
	  }
	 
	  $requetes = explode(';'.chr(10), $file); // découpe à chaque ; suivit d'un retour chariot
	  array_pop($requetes); // supprimer le dernier élément du tableau qui est vide 
	
	  foreach($requetes as $requete){
		mysql_query($requete.';');
		echo mysql_error();
	  }
}
importerSQL($fichier);
?>



<p class='center'>Les tables du <?php if ($_SESSION['Activite'] == "Agility"){echo "concours";} else {echo "tournoi";} ?> ont été restaurées</p>
<table align="center">
	<tr><th><table align="center"><tr><th class="center"><div class="bouton"><a href="<?php echo $retourprogramme; ?>" target="_top">RETOUR</a></div></th></tr></table></th></tr>
</table>
</body>
</html>
