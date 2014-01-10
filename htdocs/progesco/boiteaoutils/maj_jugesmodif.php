<?php
session_start();
$titre = "<a href='".$_SESSION["RetourJugesModif"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_jugesmodif.php'>Ajout d'un Juge</a>";
include("bandeau_bao.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
</head>
<body>
<h3 class="center">Modification d'un Juge</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Traitement
if (isset($_POST['supprimer'])){
	$idjuge = $_SESSION['idjuge'];
	$query = "SELECT * FROM cneac_juges WHERE Id='$idjuge'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$juge = $row['Nom']." ".$row['Prenom'];
	$query = "DELETE FROM cneac_juges WHERE Id='$idjuge'";
	if (!mysql_query($query)){
		echo mysql_error();
	} else {
		echo "<p class='center'>Le Juge $juge a été retiré de la table</p>
			<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR</a></div></th></tr></table>";
	}
	mysql_close();
	exit;
}

if (isset($_POST['valider'])){
	$titre = $_POST['titre'];
	$nom = mb_strtoupper($_POST['nom'], "UTF-8");
	$prenom = $_POST['prenom'];
	$idjuge = $_SESSION['idjuge'];
	$_SESSION['titre'] = $titre;
	$_SESSION['nom'] = $nom;
	$_SESSION['prenom'] = $prenom;
	if (($nom == "") or ($prenom == "")){
		echo "<p class='center'><span class='alert'>&nbsp;Vous devez obligatoirement entrer le Nom et le Prénom du Juge&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_jugesmodif.php'>RETOUR</a></div></th></tr></table>";
		exit;
	} else {
		echo "<p class='center'>Le juge $nom $prenom a été enregistré</p>";
		$nom = mysql_real_escape_string($nom);
		$prenom = mysql_real_escape_string($prenom);
		$query = "UPDATE cneac_juges SET Titre='$titre', Nom='$nom', Prenom='$prenom' WHERE Id='$idjuge'";
		mysql_query($query);
	}
	?>
	<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR Boîte à Outils</a></div></th></tr></table>
	<?php
	exit;
}

if (isset($_GET['idjuge'])){
	$idjuge = $_GET['idjuge'];
	$_SESSION['idjuge'] = $idjuge;
	$query = "SELECT * FROM cneac_juges WHERE Id='$idjuge'";
	if (!$result = mysql_query($query)){echo mysql_error();}
	$row = mysql_fetch_assoc($result);
	$titre = $row['Titre'];
	$nom = $row['Nom'];
	$prenom = $row['Prenom'];
	?>
	<form method='post' action='maj_jugesmodif.php' enctype='multipart/form-data'>
	<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
	<table class='general' width='80%' align='center' border='1' rules='groups'>
		<colgroup><col width='50%' /><col width='*' /></colgroup>
		<tbody>
		<tr>
			<td class='right'>Titre&nbsp;:</td>
			<td>M <input type='radio' name='titre' value='M'<?php if ($titre == 'M'){echo " checked='checked'";}?>  /> /
				Mme <input type='radio' name='titre' value='Mme'<?php if ($titre == 'Mme'){echo " checked='checked'";}?> /> /
				Mlle <input type='radio' name='titre' value='Mlle'<?php if ($titre == 'Mlle'){echo " checked='checked'";}?> />
			</td>
		</tr>
		<tr>
			<td class='right'>Nom du Juge&nbsp;:</td>
			<td><input type='text' name='nom' value="<?php echo $nom; ?>" size='40' /> <span class='red'>*</span></td>
		</tr>
		<tr>
			<td class='right'>Prénom du Juge&nbsp;:</td>
			<td><input type='text' name='prenom' value="<?php echo $prenom; ?>" size='40' /> <span class='red'>*</span></td>
		</tr>
		</tbody>
		<tbody>
		<tr>
			<td class='left'><input type='submit' name='supprimer' value='Retirer ce Juge' /></td><td class='right'><input type='submit' name='valider' value='Valider' /></td>
		</tr>
		</tbody>
	</table>
	</form>
	<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR Boîte à Outils</a></div></th></tr></table>
	<?php
	exit;
}
?>
<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR Boîte à Outils</a></div></th></tr></table>
<p class="center">(Pour modifier un Juge, cliquer sur son nom)</p>
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /><col /></colgroup>
	<thead><tr><th align="left">Nom et Prénom</th></tr></thead>
	<tbody>
	<?php
	$fond = "clair";
	$query = "SELECT * FROM cneac_juges ORDER BY Nom, Prenom";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$titre = $row['Titre'];
		$nom = $row['Titre']." ".$row['Nom']." ".$row['Prenom'];
		echo "<tr class='$fond'><td><a href='maj_jugesmodif.php?idjuge=$id'>$nom</a></td></tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
	?>
	</tbody>
</table>

<table align='center'><tr><th><div class='bouton'><a href='boiteaoutils.php'>RETOUR Boîte à Outils</a></div></th></tr></table>

</body>
</html>