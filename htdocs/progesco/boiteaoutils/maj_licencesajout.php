<?php
session_start();
$titre = "<a href='".$_SESSION["RetourLicencesAjout"]."'>".$_SESSION['Activite']."</a> &gt; <a href='boiteaoutils.php'>Boite à Outils</a> &gt; <a href='maj_licencesajout.php'>Ajout d'une Licence</a>";
include("bandeau_bao.php");
include("../communs/connexion.php");
$_SESSION['RetourClub'] = "../boiteaoutils/maj_licencesajout.php";
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
<h3 class="center">Ajout d'une Licence</h3>
<?php
// Traitement
if (isset($_POST['valider'])){
	$licence = $_POST['licence'];
	$nomchien = mb_strtoupper($_POST['nomchien'], "UTF-8");
	$affixe = $_POST['affixe'];
	$coderace = $_POST['coderace'];
	if (isset($_POST['lof'])){$lof = $_POST['lof'];} else {$lof = "";}
	$sexe = $_POST['sexe'];
	$toise = $_POST['toise'];
	$categorie = $_POST['categorie'];
	$classe = $_POST['classe'];
	$tatouage = $_POST['tatouage'];
	$puce = $_POST['puce'];
	$titre = $_POST['titre'];
	$nom = mb_strtoupper($_POST['nom'], "UTF-8");
	$prenom = $_POST['prenom'];
	$handi = $_POST['handi'];
	$adresse1 = $_POST['adresse1'];
	$adresse2 = $_POST['adresse2'];
	$cp = $_POST['cp'];
	$ville = mb_strtoupper($_POST['ville'], "UTF-8");
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$codeclub = $_POST['codeclub'];
	// Sauvegarde des données entrées
	$_SESSION['Licence'] = $licence;
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
	// Contrôle des entrées
	$msg = "";
	if ($licence == ""){$msg = "Numéro de licence<br />";}
	if ($codeclub == ""){$msg .= "Code du Club<br />";}
	if ($licence < 70000 or $licence > 90000){
		if ($nomchien == ""){$msg .= "Nom du chien<br />";}
		if ($coderace == ""){$msg .= "Race ou type du chien<br />";}
		if ($sexe == ""){$msg .= "Sexe du chien<br />";}
		if ($_SESSION['Programme'] == "Agility" and $categorie == ""){$msg .= "Catégorie du chien<br />";}
		if ($_SESSION['Programme'] == "Flyball" and $toise < 10){$msg .= "Toise du chien<br />";}
		if ($tatouage == "" and $puce == ""){$msg .= "Identification du chien (tatouage ou puce)<br />";}
	}
	if ($titre == ""){$msg .= "Titre : Mr, Mme ou Mlle<br />";}
	if ($nom == ""){$msg .= "Nom du conducteur<br />";}
	if ($prenom == ""){$msg .= "Prenom du conducteur<br />";}
	if ($classe == "" and $_SESSION['Programme'] == "agility"){$msg .= "Classe du conducteur<br />";}
	$nomchien = mysql_real_escape_string($nomchien);
	$affixe = mysql_real_escape_string($affixe);
	$tatouage = mysql_real_escape_string($tatouage);
	$nom = mysql_real_escape_string($nom);
	$prenom = mysql_real_escape_string($prenom);
	$adresse1 = mysql_real_escape_string($adresse1);
	$adresse2 = mysql_real_escape_string($adresse2);
	$ville = mysql_real_escape_string($ville);
	if ($msg != ""){
		echo "<p class='center'><span class='alert'>&nbsp;Les champs obligatoires suivants n'ont pas été renseignés&nbsp;</span></p>
		<p class='center'>$msg</p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_licencesajout.php'>RETOUR</a></div></th></tr></table>";
		mysql_close();
		exit;
	}
	if ($licence < 90000){
		if (($licence > 70000 and $classe == 1) or ($licence < 70000 and ($classe == 2 or $classe == 3))){
			echo "<p class='center'><span class='alert'>&nbsp;Classe incohérente avec numéro de licence&nbsp;</span></p>
			<table align='center'><tr><th><a href='maj_licencesajout.php'>RETOUR</a></div></th></tr></table>";
			mysql_close();
			exit;
		}
	}
	$query = "SELECT Id FROM cneac_licences WHERE Licence='$licence' AND NomChien<>'$nomchien'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0){
		echo "<p class='center'><span class='alert'>&nbsp;Ce numéro de licence existe déjà pour un autre chien&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_licencesajout.php'>RETOUR</a></div></th></tr></table>";
		mysql_close();
		exit;
	}
	$query = "SELECT Id FROM cneac_licences WHERE Licence='$licence' AND NomChien='$nomchien' AND Nom='$nom' AND Prenom='$prenom'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0){
		echo "<p class='center'><span class='alert'>&nbsp;Une licence ou une carte conducteur existe déjà pour ce conducteur&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='maj_licencesajout.php'>RETOUR</a></div></th></tr></table>";
		mysql_close();
		exit;
	}
	$query = "INSERT INTO cneac_licences SET Licence='$licence', NomChien='$nomchien', Affixe='$affixe', CodeRace='$coderace', LOF='$lof', Sexe='$sexe', Toise='$toise', Categorie='$categorie', Classe='$classe', Tatouage='$tatouage', Puce='$puce', Titre='$titre', Nom='$nom', Prenom='$prenom', Handi='$handi', Adresse1='$adresse1', Adresse2='$adresse2', CP='$cp', Ville='$ville', Email='$email', Telephone='$telephone', CodeClub='$codeclub'";
	if (mysql_query($query)){echo "<p class='center'>La licence $licence a été enregistrée</p>";}
	else {echo mysql_error();}
	$_SESSION['idlicence'] = mysql_insert_id();
	$_SESSION['Licence'] = $licence;
	echo "<table align='center'><tr><th><div class='bouton'><a href='".$_SESSION['RetourLicencesAjout']."'>RETOUR</a></div></th></tr></table>";
	// Effacelent des données entrées
	$_SESSION['NomChien'] = "";
	$_SESSION['Affixe'] = "";
	$_SESSION['CodeRace'] = "";
	$_SESSION['LOF'] = "";
	$_SESSION['Sexe'] = "";
	$_SESSION['Toise'] = "";
	$_SESSION['Categorie'] = "";
	$_SESSION['Classe'] = "";
	$_SESSION['Tatouage'] = "";
	$_SESSION['Puce'] = "";
	$_SESSION['Titre'] = "";
	$_SESSION['Nom'] = "";
	$_SESSION['Prenom'] = "";
	$_SESSION['Handi'] = "";
	$_SESSION['Adresse1'] = "";
	$_SESSION['Adresse2'] = "";
	$_SESSION['CP'] = "";
	$_SESSION['Ville'] = "";
	$_SESSION['EMail'] = "";
	$_SESSION['Telephone'] = "";
	$_SESSION['CodeClub'] = "";
	exit;
}
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
$email = $_SESSION['EMail'];
$telephone = $_SESSION['Telephone'];
$codeclub = $_SESSION['CodeClub'];
if (isset($_GET['licence'])){$_SESSION['Licence'] = $_GET['licence'];}
?>
<form action='maj_licencesajout.php' method='post' enctype='multipart/form-data'>
<p class='center'>(<span class='red'>*</span> = paramètre obligatoire)</p>
<table class='general' width='80%' align='center' border='1' rules='groups'>
	<colgroup><col /><col /><col /></colgroup>
	<tbody>
	<tr>
		<td></td>
		<td align="right">N° de licence&nbsp;: </td>
		<td><input type="text" name="licence" value="<?php echo $_SESSION['Licence']; ?>" /><span class='red'>*</span></td>
	</tr>
	</tbody>
	<tbody>
	<tr>
		<th>CLUB</th>
		<td align="right">Code Club&nbsp;: </td>
		<td><select name="codeclub">
			<?php
			$query = "SELECT * FROM cneac_clubs ORDER BY Club";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)){
				$codeclubs = $row['CodeClub'];
				$clubs = $row['Club'];
				echo "<option value='$codeclubs'";
				if ($codeclubs == $codeclub){echo " selected='selected'";}
				echo ">$clubs / $codeclubs</option>";
			}
			?>
			</select><span class='red'>*</span> <a href='../boiteaoutils/maj_clubsajout.php'>Si le club n'est pas dans la liste, cliquez ici</a>
		</td>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="6">CHIEN</th>
		<td class="right">Nom&nbsp;:</td><td><input type="text" name="nomchien" value="<?php echo $nomchien; ?>" size="30" /><span class="red">*</span> Affixe <input type="text" name="affixe" value="<?php echo $affixe; ?>" size="50" /></td>
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
			echo ">$races / $coderaces</option>";
		}
		?>
		</select><span class="red">*</span>
		</td>
	</tr>
	<tr><td class="right">Si chien de race&nbsp;:</td>
		<td>Numéro LOF <input type="text" name="lof" value="<?php echo $lof; ?>" /></td>
	</tr>
	<tr><td class="right">Sexe&nbsp;:</td>
		<td>Male <input type="radio" name="sexe" value="M" <?php if ($sexe == "M"){echo " checked";} ?> /> /
			Femelle <input type="radio" name="sexe" value="F" <?php if ($sexe == "F"){echo " checked";} ?> /><span class="red">*</span>
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
		D <input type="radio" name="categorie" value="4" <?php if ($categorie == "4"){echo " checked";} ?> /><span class="red">*</span>
		<?php } ?>
		</td>
	</tr>
	<tr><td class="right">Identification&nbsp;:</td>
		<td>Tatouage <input type="text" name="tatouage" value="<?php echo $tatouage; ?>" size="10" /> ou Puce <input type="text" name="puce" value="<?php echo $puce; ?>" /><span class="red">*</span></td>
	</tr>
	</tbody>
	<tbody>
	<tr><th rowspan="5">CONDUCTEUR</th><td></td>
		<td>Mr <input type="radio" name="titre" value="Mr" <?php if ($titre == "Mr"){echo " checked";} ?> /> /
			Mme <input type="radio" name="titre" value="Mme" <?php if ($titre == "Mme"){echo " checked";} ?> /> /
			Mlle <input type="radio" name="titre" value="Mlle" <?php if ($titre == "Mlle"){echo " checked";} ?> /><span class="red">*</span> / 
			Nom <input type="text" name="nom" value="<?php echo $nom; ?>" /><span class="red">*</span>
			Prénom <input type="text" name="prenom" value="<?php echo $prenom; ?>" /><span class='red'>*</span>
		</td>
	</tr>
	<?php
	if ($_SESSION['Programme'] == "agility"){
	?>
	<tr>
		<td class="right">Classe : </td>
		<td>Senior <input type='radio' name='classe' value='1' <?php if ($classe == 1 or $classe == ""){echo "checked='checked'";} ?> /> /
			Junior <input type='radio' name='classe' value='2' <?php if ($classe == 2){echo "checked='checked'";} ?> /> /
			Poussin <input type='radio' name='classe' value='3' <?php if ($classe == 3){echo "checked='checked'";} ?> /> <span class="red">*</span>
		</td>
	</tr>
	<?php } ?>
	<tr><td class="right">Si licence handi : </td>
		<td>Classe du handicap&nbsp;: 
			1<input type="radio" name="handi" value="1" <?php if ($handi == 1){echo " checked='checked'";} ?> /> /
			2<input type="radio" name="handi" value="2" <?php if ($handi == 2){echo " checked='checked'";} ?> /> /
			3<input type="radio" name="handi" value="3" <?php if ($handi == 3){echo " checked='checked'";} ?> /> /
			4<input type="radio" name="handi" value="4" <?php if ($handi == 4){echo " checked='checked'";} ?> /> /
			5<input type="radio" name="handi" value="5" <?php if ($handi == 5){echo " checked='checked'";} ?> /> /
			Annulation handi <input type="radio" name="handi" value="0" <?php if ($handi == 0 or $handi == ""){echo " checked='checked'";} ?>/>
		</td>
	</tr>
	<tr><td class="right">Adresse&nbsp;:</td>
		<td><input type="text" name="adresse1" value="<?php echo $adresse1; ?>" size="50" /><br />
			<input type="text" name="adresse2" value="<?php echo $adresse2; ?>" size="50" /><br />
			Code Postal <input type="text" name="cp" value="<?php echo $cp; ?>" size="6" />
			Ville <input type="text" name="ville" value="<?php echo $ville; ?>" size="15" />
		</td>
	</tr>
	<tr><td class="right">email&nbsp;:</td><td><input type="text" name="email" value="<?php echo $email; ?>" size="30" />
			Téléphone <input type="text" name="telephone" value="<?php echo $telephone; ?>" size="15" />
		</td>
	</tr>
	</tbody>
	<tbody>
	<tr><th><div class='bouton'>
		<?php if ($_SESSION['Flag_AppelProgramme'] == "Y"){echo "<a href='".$_SESSION['RetourLicencesAjout']."'>RETOUR ".$_SESSION['Activite']."</a>";} else {echo "<a href='boiteaoutils.php'>RETOUR Boîte à Outils</a>"; } ?>
		</th>
		<td></td>
		<td align="right"><input type="submit" name="valider" value="Valider" /></td>
	</tr>
	</tbody>
</table>
</form>

</body>
</html>