<?php
session_start();
$titre = "<a href='".$_SESSION["RetourLicencesModif"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_licencesmodif.php'>Modification d'une Licence</a>";
include("bandeau_bao.php");
$_SESSION['RetourClubsAjout'] = "maj_licencesmodif.php";
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
<h3 class="center">Modification d'une Licence</h3>
<?php
// Connexion bdd
include("../communs/connexion.php");
// Nom variables
include("../agility/utilitaires/nomvars_agi.php");
// Traitement
$idlicence = $_SESSION['IdLicence'];
$licence = $_SESSION['Licence'];

if (isset($_POST['supprimer'])){
	$query = "DELETE FROM cneac_licences WHERE Id='$idlicence'";
	if (!mysql_query($query)){echo mysql_error();}
	else {echo "<p class='center'>La Licence a été supprimée de la table</p>
		<table align='center'><tr><th><div class='bouton'>";
		if ($_SESSION['Flag_AppelProgramme'] == "Y"){
			echo "<a href='".$_SESSION['RetourLicencesModif']."'>RETOUR ".$_SESSION['Activite']."</a>";
		} else {
			echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>";
		}
		echo "</th></tr></table>";
	}
	exit;
}

if (isset($_POST['valider'])){
	$nomchien = mb_strtoupper($_POST['nomchien'], "UTF-8");
	$affixe = $_POST['affixe'];
	$coderace = $_POST['coderace'];
	if (isset($_POST['lof'])){$lof = $_POST['lof'];} else {$lof = "";}
	$sexe = $_POST['sexe'];
	$toise = $_POST['toise'];
	$categorie = $_POST['categorie'];
	$classe = $_POST['classe'];
	if (isset($_POST['tatouage'])){$tatouage = $_POST['tatouage'];}
	if (isset($_POST['puce'])){$puce = $_POST['puce'];}
	$titre = $_POST['titre'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$handi = $_POST['handi'];
	$adresse1 = $_POST['adresse1'];
	$adresse2 = $_POST['adresse2'];
	$cp = $_POST['cp'];
	$ville = mb_strtoupper($_POST['ville'], "UTF-8");
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$codeclub = $_POST['codeclub'];
	if ($classe == ""){$classe = 1;}
	if ($handi == ""){$handi = 0;}
	// Sauvegarde des entrées
	$_SESSION['NomChien'] = $nomchien;
	$_SESSION['Affixe'] = $affixe;
	$_SESSION['CodeRace'] = $coderace;
	$_SESSION['LOF'] = $lof;
	$_SESSION['Sexe'] = $sexe;
	$_SESSION['Toise'] = $toise;
	$_SESSION['Categorie'] = $categorie;
	$_SESSION['Classe'] = $classe;
	$_SESSION['Tatouage'] = $tatouage;
	$_SESSION['Puce'] = $puce;
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
	$_SESSION['CodeClub'] = $codeclub;
	$_SESSION['FlagEntrees'] = "Y";
	// Contrôle des entrées
	$msg = "";
	if ($licence == ""){$msg = "Numéro de licence<br />";}
	if ($codeclub == ""){$msg .= "Code du Club<br />";}
	if ($licence < 70000 or $licence > 90000){
		if ($_SESSION['Programme'] == "agility" and $categorie == ""){$msg .= "Catégorie du chien en agility<br />";}
		if ($_SESSION['Programme'] == "flyball" and $toise < 10){$msg .= "Toise du chien<br />";}
	}
	if ($nom == ""){$msg .= "Nom du conducteur<br />";}
	if ($prenom == ""){$msg .= "Prenom du conducteur<br />";}
	if ($classe == ""){$msg .= "Classe du conducteur<br />";}
	if ($msg != ""){
		echo "<p class='center'><span class='alert'>&nbsp;Les champs obligatoires suivants n'ont pas été renseignés&nbsp;</span></p>
		<p class='center'>$msg</p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_licencesmodif.php'>RETOUR</a></div></th></tr></table>";
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
	$query = "UPDATE cneac_licences SET NomChien='$nomchien', Affixe='$affixe', CodeRace='$coderace', LOF='$lof', Sexe='$sexe', Toise='$toise', Categorie='$categorie', Tatouage='$tatouage', Puce='$puce', CodeClub='$codeclub' WHERE Licence='$licence'";
	mysql_query($query);
	$query = "UPDATE cneac_licences SET Titre='$titre', Nom='$nom', Prenom='$prenom', Classe='$classe', Handi='$handi', Adresse1='$adresse1', Adresse2='$adresse2', CP='$cp', Ville='$ville', Email='$email', Telephone='$telephone' WHERE Id='$idlicence'";
	mysql_query($query);
	$_SESSION['FlagEntrees'] = "N";
	if (mysql_query($query)){echo "<p class='center'>La licence $licence a été enregistrée</p>";} else {echo mysql_error();}
	echo "<table align='center'><tr><th><div class='bouton'>";
	if ($_SESSION['Flag_AppelProgramme'] == "Y"){
		echo "<a href='".$_SESSION['RetourLicencesModif']."'>RETOUR ".$_SESSION['Activite']."</a>";
	} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>";}
	echo "</th></tr></table>";
	exit;
}
if (isset($_GET['idlicence'])){
	$idlicence = $_GET['idlicence'];
	$_SESSION['IdLicence'] = $idlicence;
}
if ($_SESSION['IdLicence'] != ""){
	if ($_SESSION['FlagEntrees'] == "Y"){
		$licence = $_SESSION['Licence'];
		$nomchien = $_SESSION['NomChien'];
		$affixe = $_SESSION['Affixe'];
		$coderace = $_SESSION['CodeRace'];
		$lof = $_SESSION['LOF'];
		$sexe = $_SESSION['Sexe'];
		$toise = $_SESSION['Toise'];
		$categorie = $_SESSION['Categorie'];
		$classe = $_SESSION['Classe'];
		$tatouage = $_SESSION['Tatouage'];
		$puce = $_SESSION['Puce'];
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
		$codeclub = $_SESSION['CodeClub'];
	} else {
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
	}
	?>
	<form action='maj_licencesmodif.php' method='post' enctype='multipart/form-data'>
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
			<td><select name="codeclub">
				<?php
				$query = "SELECT * FROM cneac_clubs ORDER BY CodeClub";
				$result = mysql_query($query);
				while ($row = mysql_fetch_assoc($result)){
					$codeclubs = $row['CodeClub'];
					$clubs = $row['Club'];
					echo "<option value='$codeclubs'";
					if ($codeclubs == $codeclub){echo " selected='selected'";}
					echo ">$codeclubs / $clubs</option>";
				}
				echo "</select><span class='red'>*</span> <a href='maj_clubsajout.php'>Si le club n'est pas dans la liste, cliquez ici</a>";
				?>
			</td>
		</tr>
		</tbody>
		<tbody>
		<tr><th rowspan="7">CHIEN</th>
			<td class="right">Nom&nbsp;:</td><td><input type="text" name="nomchien" value="<?php echo $nomchien; ?>" size="30" /><span class='red'>*</span></td></tr>
		<tr><td class="right">Affixe&nbsp;:</td><td><input type="text" name="affixe" value="<?php echo $affixe; ?>" size="50" /></td>
		</tr>
		<tr><td class="right">Race ou Type&nbsp;:</td><td><select name="coderace">
			<option value=""></option>
			<?php
			$query = "SELECT * FROM cneac_races ORDER BY Race";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)){
				$idraces = $row['Id'];
				$races = $row['Race'];
				$coderaces = $row['CodeRace'];
				echo "<option value='$coderaces'";
				if ($coderace == $coderaces){echo " selected='selected'";}
				echo ">$races</option>";
			}
			?>
			</select>
			</td>
		</tr>
		<tr><td class="right">Si chien de race&nbsp;:</td>
			<td>Numéro LOF <input type="text" name="lof" value="<?php echo $lof; ?>" /></td>
		</tr>
		<tr><td class="right">Sexe&nbsp;:</td>
			<td>Male <input type="radio" name="sexe" value="M" <?php if ($sexe == "M"){echo " checked";} ?> /> /
				Femelle <input type="radio" name="sexe" value="F" <?php if ($sexe == "F"){echo " checked";} ?> />
			</td>
		</tr>
		<tr><td class='right'>
			<?php
			if ($_SESSION['Programme'] == "flyball"){echo "Toise&nbsp;:</td><td><input type='text' name='toise' value='$toise' size='10' /> cm<span class='red'>*</span>";}
			else if ($_SESSION['Programme'] == "agility"){ ?>
			Catégorie Agility&nbsp;:</td><td>
			A <input type="radio" name="categorie" value="1" <?php if ($categorie == "1"){echo " checked";} ?> /> /
			B <input type="radio" name="categorie" value="2" <?php if ($categorie == "2"){echo " checked";} ?> /> /
			C <input type="radio" name="categorie" value="3" <?php if ($categorie == "3"){echo " checked";} ?> /> /
			D <input type="radio" name="categorie" value="4" <?php if ($categorie == "4"){echo " checked'";} ?> /><span class="red">*</span>
			<?php } ?>
			</td>
		</tr>
		<tr><td class="right">Identification&nbsp;:</td>
			<td>Tatouage <input type="text" name="tatouage" value="<?php echo $tatouage; ?>" size="10" /> ou Puce <input type="text" name="puce" value="<?php echo $puce; ?>" /></td>
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
				Annulation handi <input type="radio" name="handi" value="0" />
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
}
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