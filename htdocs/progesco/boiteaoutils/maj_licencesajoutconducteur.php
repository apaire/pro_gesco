<?php
session_start();
$titre = "<a href='".$_SESSION["RetourLicencesModif"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_licencesajoutconducteur.php'>Ajout d'un conducteur</a>";
include("bandeau_bao.php");
$_SESSION['RetourClubsAjout'] = "maj_licencesajoutconducteur.php";
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
<h3 class="center">Ajout d'un conducteur à une Licence</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Nom variables
include("../agility/utilitaires/nomvars_agi.php");
include("../flyball/utilitaires/nomvars_fly.php");
// Traitement
if (isset($_GET['idlicence'])){$_SESSION['IdLicence'] = $_GET['idlicence'];}
$idlicence = $_SESSION['IdLicence'];
if (isset($_POST['valider'])){
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$licence = $row['Licence'];
	$nomchien = $row['NomChien'];
	$affixe = $row['Affixe'];
	$coderace = $row['CodeRace'];
	$lof = $row['LOF'];
	$sexe = $row['Sexe'];
	$toise = $row['Toise'];
	$categorie = $row['Categorie'];
	$tatouage = $row['Tatouage'];
	$puce = $row['Puce'];
	$codeclub = $row['CodeClub'];
	$titre = $_POST['titre'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$classe = $_POST['classe'];
	$handi = $_POST['handi'];
	$adresse1 = $_POST['adresse1'];
	$adresse2 = $_POST['adresse2'];
	$cp = $_POST['cp'];
	$ville = mb_strtoupper($_POST['ville'], "UTF-8");
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	if ($classe == ""){$classe = 1;}
	if ($handi == ""){$handi = 0;}
	// Sauvegarde des entrées
	$_SESSION['Classe'] = $classe;
	$_SESSION['Titre'] = $titre;
	$_SESSION['Nom'] = $nom;
	$_SESSION['Prenom'] = $prenom;
	$_SESSION['Handi'] = $handi;
	$_SESSION['Adresse1'] = $adresse1;
	$_SESSION['Adresse2'] = $adresse2;
	$_SESSION['CP'] = $cp;
	$_SESSION['Ville'] = $ville;
	$_SESSION['EMail'] = $email;
	$_SESSION['Telephone'] = $telephone;
	$_SESSION['FlagEntrees'] = "Y";
	// Contrôle des entrées
	$msg = "";
	if ($codeclub == ""){$msg .= "Code du Club<br />";}
	if ($nom == ""){$msg .= "Nom du conducteur<br />";}
	if ($prenom == ""){$msg .= "Prenom du conducteur<br />";}
	if ($classe == ""){$msg .= "Classe du conducteur<br />";}
	if ($msg != ""){
		echo "<p class='center'><span class='alert'>&nbsp;Les champs obligatoires suivants n'ont pas été renseignés&nbsp;</span></p>
		<p class='center'>$msg</p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_licencesajoutconducteur.php'>RETOUR</a></div></th></tr></table>";
		mysql_close();
		exit;
	}
	if ($licence < 90000){
		if (($licence > 70000 and $classe == 1) or ($licence < 70000 and ($classe == 2 or $classe == 3))){
			echo "<p class='center'><span class='alert'>&nbsp;Classe incohérente avec numéro de licence&nbsp;</span></p>
			<table align='center'><tr><th><a href='maj_licencesmodif.php'>RETOUR</a></div></th></tr></table>";
			mysql_close();
			exit;
		}
	}
	// Préparation des variables pour MySql
	$nomchien = mysql_real_escape_string($nomchien);
	$affixe = mysql_real_escape_string($affixe);
	$nom = mysql_real_escape_string($nom);
	$prenom = mysql_real_escape_string($prenom);
	$adresse1 = mysql_real_escape_string($adresse1);
	$adresse2 = mysql_real_escape_string($adresse2);
	$ville = mysql_real_escape_string($ville);
	$query = "INSERT INTO cneac_licences SET Licence='$licence', NomChien='$nomchien', Affixe='$affixe', CodeRace='$coderace', LOF='$lof', Sexe='$sexe', Toise='$toise', Categorie='$categorie', Tatouage='$tatouage', Puce='$puce', CodeClub='$codeclub', Titre='$titre', Nom='$nom', Prenom='$prenom', Classe='$classe', Handi='$handi', Adresse1='$adresse1', Adresse2='$adresse2', CP='$cp', Ville='$ville', Email='$email', Telephone='$telephone'";
	$_SESSION['FlagEntrees'] = "N";
	$_SESSION['Idlicence'] = "";
	if (mysql_query($query)){echo "<p class='center'>La licence $licence a été enregistrée</p>";} else {echo mysql_error();}
	echo "<table align='center'><tr><th><div class='bouton'>";
	if ($_SESSION['Flag_AppelProgramme'] == "Y"){
		echo "<a href='".$_SESSION['RetourLicencesModif']."'>RETOUR ".$_SESSION['Activite']."</a>";
	} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>";}
	echo "</th></tr></table>";
	exit;
}
// Lecture licence
$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
if (!$result = mysql_query($query)){echo mysql_error();}
$row = mysql_fetch_assoc($result);
$licence = $row['Licence'];
$nomchien = $row['NomChien'];
$affixe = $row['Affixe'];
$coderace = $row['CodeRace'];
$lof = $row['LOF'];
$sexe = $row['Sexe'];
$toise = $row['Toise'];
$categorie = $row['Categorie'];
$classe = $row['Classe'];
$tatouage = $row['Tatouage'];
$puce = $row['Puce'];
$titre = $row['Titre'];
$nom = $row['Nom'];
$prenom = $row['Prenom'];
$handi = $row['Handi'];
$adresse1 = $row['Adresse1'];
$adresse2 = $row['Adresse2'];
$cp = $row['CP'];
$ville = $row['Ville'];
$email = $row['Email'];
$telephone = $row['Telephone'];
$codeclub = $row['CodeClub'];
$_SESSION['Licence'] = $licence;
if ($_SESSION['FlagEntrees'] == "Y"){
	$classe = $_SESSION['Classe'];
	$titre = $_SESSION['Titre'];
	$nom = $_SESSION['Nom'];
	$prenom = $_SESSION['Prenom'];
	$handi = $_SESSION['Handi'];
	$adresse1 = $_SESSION['Adresse1'];
	$adresse2 = $_SESSION['Adresse2'];
	$cp = $_SESSION['CP'];
	$ville = $_SESSION['Ville'];
	$email = $_SESSION['Email'];
	$telephone = $_SESSION['Telephone'];
}
?>
<form action='maj_licencesajoutconducteur.php' method='post' enctype='multipart/form-data'>
<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
<table class='general' width='80%' align='center' border='1' rules='groups'>
	<colgroup><col /><col /><col /></colgroup>
	<tbody>
	<tr>
		<th colspan="3">N° de licence&nbsp;: <?php echo $licence; ?></th></tr>
	</tbody>
	<tbody>
	<tr>
		<th>CLUB</th>
		<td></td>
		<td><?php
			$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$codeclubs = $row['CodeClub'];
			$clubs = $row['Club'];
			echo "$codeclubs / $clubs";
			?>
		</td>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="7">CHIEN</th>
		<td class="right">Nom&nbsp;:</td><td><?php echo $nomchien; ?></td></tr>
	<tr><td class="right">Affixe&nbsp;:</td><td><?php echo $affixe; ?></td></tr>
	<tr><td class="right">Race ou Type&nbsp;:</td>
		<td><?php
		$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$races = $row['Race'];
		$coderaces = $row['CodeRace'];
		echo $races
		?>
		</td>
	</tr>
	<tr><td class="right"></td>
		<td><?php if ($lof != ""){echo "Numéro LOF : $lof";} ?></td>
	</tr>
	<tr><td class="right">Sexe&nbsp;:</td>
		<td>
		<?php
		if ($sexe == "M"){echo "Mâle";}
		if ($sexe == "F"){echo "Femelle";}
		?>
		</td>
	</tr>
	<tr><td class='right'>
		<?php
		if ($_SESSION['Programme'] == "flyball"){echo "Toise&nbsp;:</td><td>$toise cm";}
		else if ($_SESSION['Programme'] == "agility"){echo "Catégorie Agility&nbsp;:</td><td>$nomcategories[$categorie]";}
		?>
		</td>
	</tr>
	<tr><td class="right">Identification&nbsp;:</td>
		<td><?php if ($puce != ""){echo "Puce : $puce";} else {echo "Tatouage : $tatouage";} ?></td>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="5">CONDUCTEUR</th><td></td>
		<td>Mr <input type="radio" name="titre" value="Mr" <?php if ($titre == "Mr"){echo " checked";} ?> /> /
			Mme <input type="radio" name="titre" value="Mme" <?php if ($titre == "Mme"){echo " checked";} ?> /> /
			Mlle <input type="radio" name="titre" value="Mlle" <?php if ($titre == "Mlle"){echo " checked";} ?> /> / 
			Nom <input type="text" name="nom" value="<?php echo $nom; ?>" /><span class='red'>*</span>
			Prénom <input type="text" name="prenom" value="<?php echo $prenom; ?>" /><span class='red'>*</span>
		</td>
	</tr>
	<tr>
		<td class="right">Classe : </td>
		<td>
		<?php
		if ($licence <= 70000 or $licence >= 90000){echo "Senior <input type='radio' name='classe' value='1' checked='checked' />";}
		if ($licence > 70000){echo "Poussin <input type='radio' name='classe' value='3'";
			if ($classe == 3){echo " checked='checked'";}
			echo " /> / Junior <input type='radio' name='classe' value='2'";
			if ($classe == 2){echo " checked='checked'";}
			echo " />";
		}
		?>
		</td>
	</tr>
	<tr><td class="right">Si licence handi : </td>
		<td>Classe du handicap&nbsp;: 
			1<input type="radio" name="handi" value="1" <?php if ($handi == 1){echo " checked='checked'";} ?> /> /
			2<input type="radio" name="handi" value="2" <?php if ($handi == 2){echo " checked='checked'";} ?> /> /
			3<input type="radio" name="handi" value="3" <?php if ($handi == 3){echo " checked='checked'";} ?> /> /
			4<input type="radio" name="handi" value="4" <?php if ($handi == 4){echo " checked='checked'";} ?> /> /
			5<input type="radio" name="handi" value="5" <?php if ($handi == 5){echo " checked='checked'";} ?> /> /
			Annuler handi <input type="radio" name="handi" value="0" />
		</td>
	</tr>
	<tr><td class="right">Adresse&nbsp;:</td>
		<td><input type="text" name="adresse1" value="<?php echo $adresse1; ?>" size="50" /><br />
			<input type="text" name="adresse2" value="<?php echo $adresse2; ?>" size="50" /><br />
			Code Postal <input type="text" name="cp" value="<?php echo $cp; ?>" size="6" />
			Ville <input type="text" name="ville" value="<?php echo $ville; ?>" size="30" />
		</td>
	</tr>
	<tr><td class="right">email&nbsp;:</td><td><input type="text" name="email" value="<?php echo $email; ?>" size="30" />
		Téléphone <input type="text" name="telephone" value="<?php echo $telephone; ?>" size="15" />
		</td>
	</tr>
	</tbody>
</table>
<table class='general' width='80%' align='center' border='1' rules='groups'>
	<colgroup><col width="33%" /><col width="*" /><col width="33%" /></colgroup>
	<tbody>
	<tr><th><div class='bouton'>
		<?php
		if ($_SESSION['Flag_AppelProgramme'] == "Y"){
			echo "<a href='".$_SESSION['RetourLicencesModif']."'>RETOUR ".$_SESSION['Activite']."</a>";
		} else {
			echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>
			<th><input type='submit' name='supprimer' value='SUPPRIMER CETTE LICENCE' />";
		}
		?>
		</td><td colspan="2" align="right"><input type="submit" name="valider" value="Valider" /></td>
	</tr>
	</tbody>
</table>
</form>
<?php
mysql_close();
exit;
?>

<table align='center'><tr><td class='center'><div class='bouton'><a href='boiteaoutils.php'>RETOUR</a></div></td></tr></table>
<p class="center">(cliquer sur le numéro de licence)</p>
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /><col /><col /></colgroup>
	<thead><tr><th align="left"><a href="maj_licencesmodif.php?ordre=Licence">Licence</a></th><th><a href="maj_licencesmodif.php?ordre=NomChien">Nom du Chien</a></th><th><a href="maj_licencesmodif.php?ordre=Nom">Conducteur</a></th></tr></thead>
	<tbody>
	<?php
	if (isset($_GET['ordre'])){$ordre = $_GET['ordre'];} else {$ordre = "Licence";}
	if ($ordre == "Nom"){$ordre .= ", Prenom";}
	$fond = "clair";
	$query = "SELECT * FROM cneac_licences ORDER BY $ordre";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$licence = $row['Licence'];
		$nomchien = $row['NomChien'];
		$conducteur = $row['Nom']." ".$row['Prenom'];
		echo "<tr class='$fond'><td><a href='maj_licencesmodif.php?idlicence=$id'>$licence</a></td><td>$nomchien</td><td>$conducteur</td></tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
	?>
	</tbody>
</table>

<table align="center"><tr><th><div class='bouton'>
<?php
if ($_SESSION['Flag_AppelProgramme'] == "Y"){
	echo "<a href='".$_SESSION['RetourLicencesModif']."'>RETOUR ".$_SESSION['Activite']."</a>";
} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>";}
?>
</th></tr></table>

</body>
</html>