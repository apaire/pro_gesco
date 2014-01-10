<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a>";
include("../utilitaires/bandeau_agi.php");
include("../utilitaires/nomvars_agi.php");
$_SESSION["RetourLicencesModif"] = "../agility/avant/avantagi_concurrents_1.php";
$_SESSION['RetourLicencesAjout'] = "../agility/avant/avantagi_concurrents_1.php";
$_SESSION["Flag_AppelProgramme"] = "Y";
$retour = $_SESSION['RetourConcurrents1'];
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
<h3 class="center">Entrée des concurrents</h3>
<?php
include("../utilitaires/nomvars_agi.php");
include("../../communs/connexion.php");
$typeconcours = $_SESSION['TypeConcours'];
$nbepreuves = $nbepreuvess[$typeconcours];
// Récupération infos licence
if (isset($_POST['licence'])){
	$_SESSION['Licence'] = $_POST['licence'];
	$_SESSION['IdLicence'] = "";
}
if (isset($_POST['idlicence'])){
	$_SESSION['IdLicence'] = $_POST['idlicence'];
	$_SESSION['Licence'] = "";
}
if (isset($_GET['idlicence'])){
	$_SESSION['IdLicence'] = $_GET['idlicence'];
	$_SESSION['Licence'] = "";
}
$idlicence = $_SESSION['IdLicence'];
$licence = $_SESSION['Licence'];
if ($idlicence == ""){
	$query = "SELECT * FROM cneac_licences WHERE Licence='$licence'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$nb_licences = mysql_num_rows($result);
	if ($nb_licences == 0){ // Pas de licence
		echo "<p class='center'>La licence $licence n'est pas enregistrée.</p>
		<p class='center'><a href='../../boiteaoutils/maj_licencesajout.php'>Cliquez ICI pour entrer la licence.</a></p>
		<table align='center'><tr><th class='center'><div class='bouton'><a href='$retour'>RETOUR</a></div></th></tr></table>";
		exit;
	}

	if ($nb_licences > 1){ // Plus d'une licence
		?>
		<p class='center'>Sélectionnez le conducteur</p>
		<form method="post" action="avantagi_concurrents_1.php" enctype="multipart/form-data">
		<table class="general" align="center">
			<tr>
				<th colspan="2"><select name="idlicence" size="<?php echo $nb_licences; ?>">
		<?php
		do {
			$idlicence = $row['Id'];
			$licence = $row['Licence'];
			$conducteur = $row['Nom']." ".$row['Prenom'];
			echo "<option value='$idlicence'>$licence / $conducteur</option>";
		} while ($row = mysql_fetch_assoc($result));
		echo "</select></th></tr><tr>
		<th class='left'><div class='bouton'><a href='$retour'>RETOUR</a></div></th>
		<th class='right'><input type='submit' name='validconcurrent' value='VALIDER LE CONDUCTEUR' /></th></tr></table>";
		exit;
	}
	if ($nb_licences == 1){ // Une licence
		$idlicence = $row['Id'];
	}
}
$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$licence = $row['Licence'];
$nomchien = $row['NomChien'];
$affixe = $row['Affixe'];
$coderace = $row['CodeRace'];
$lof = $row['LOF'];
$sexe = $row['Sexe'];
$categorie = $row['Categorie'];
$classe = $row['Classe'];
$handi = $row['Handi'];
$tatouage = $row['Tatouage'];
$puce = $row['Puce'];
$titre = $row['Titre'];
$nom = $row['Nom'];
$prenom = $row['Prenom'];
$adresse1 = $row['Adresse1'];
$adresse2 = $row['Adresse2'];
$cp = $row['CP'];
$ville = $row['Ville'];
$email = $row['Email'];
$telephone = $row['Telephone'];
$codeclub = $row['CodeClub'];
$agi1 = $row['AGI1'];
$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
$result1 = mysql_query($query);
$row1 = mysql_fetch_assoc($result1);
$idrace = $row1['Id'];
$race = $row1['Race'];
$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
$result1 = mysql_query($query);
$row1 = mysql_fetch_assoc($result1);
$club = $row1['Club'];
$_SESSION['IdLicence'] = $idlicence;
$_SESSION['Licence'] = $licence;
$_SESSION['LOF'] = $lof;

// Championnat
if (($typeconcours == "ChR" or $typeconcours == "ChF") and ($licence < 70000 or $licence > 90000) and $lof == ""){
	// Chien non LOF
	echo "<p class='center'><span class='alert'><b>&nbsp;CHIEN NON LOF. Ne peut être inscrit à ce concours.&nbsp;</b></span></p>
	<table align='center'><tr><th class='center'><div class='bouton'><a href='$retour'>RETOUR</a></div></th></tr></table>";
	exit;
}
if ($typeconcours == "ChR" or $typeconcours == "SGPF" or $typeconcours == "Comp"){
	$query = "SELECT CodeRegionale FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$coderegionale = $row1['CodeRegionale'];
	$query = "SELECT Regionale FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($result1);
	$regionale = stripslashes($row1['Regionale']);
	$_SESSION['Championnat'] = "Y";
	if ($regionale != $_SESSION['Regionale']){ // Chien pas de la régionale
		$_SESSION['Championnat'] = "N";
		if ($typeconcours == "ChR" or $typeconcours == "SGPF"){
			echo "<p class='center'><span class='alert'><b>&nbsp;CE CHIEN N'EST PAS DE LA REGIONALE. Ne peut être inscrit à ce concours.&nbsp;</b></span></p>
			<table align='center'><tr><th class='center'><div class='bouton'><a href='$retour'>RETOUR</a></div></th></tr></table>";
			exit;
		}
	}
}
if ($_SESSION['Modif'] == "Y"){
	$epreuve1 = $_SESSION['Epreuve1'];
	$epreuve2 = $_SESSION['Epreuve2'];
	$epreuve3 = $_SESSION['Epreuve3'];
	$epreuve4 = $_SESSION['Epreuve4'];
	$epreuve3degre = $_SESSION['Epreuve3degre'];
	$epreuve4degre = $_SESSION['Epreuve4degre'];
	$_SESSION['Modif'] = "N";
} else {
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='1'"; // 1er degré
	if (mysql_num_rows(mysql_query($query)) > 0){$epreuve1 = 1;}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='2'"; // 2ème degré
	if (mysql_num_rows(mysql_query($query)) > 0){$epreuve1 = 2;}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='3'"; // 3ème degré
	if (mysql_num_rows(mysql_query($query)) > 0){$epreuve1 = 3;}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='4'"; // Epreuvs normales
	if (mysql_num_rows(mysql_query($query)) > 0){$epreuve2 = "normal";}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='5'"; // Epreuves plus
	if (mysql_num_rows(mysql_query($query)) > 0){$epreuve2 = "plus";}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='12'"; // ChR 2ème degré
	if (mysql_num_rows(mysql_query($query)) > 0){
		$epreuve3 = "ChR";
		$epreuve3degre = 2;
	}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='16'"; // ChR3ème degré
	if (mysql_num_rows(mysql_query($query)) > 0){
		$epreuve3 = "ChR";
		$epreuve3degre = 3;
	}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='19'"; // SGPF
	if (mysql_num_rows(mysql_query($query)) > 0){
		$epreuve4 = "SGPF";
	}
}
if ($typeconcours == "CC" and $lof == "" and ($licence < 70000 or $licence >= 90000)){$nbepreuves--;}
?>

<table class="general" align="center" width="80%" border="1">
	<tr>
		<td class="center">N° de licence&nbsp;: <b><?php echo $licence; ?></b></td>
	</tr>
</table>

<form method="post" action="avantagi_concurrents_2.php" enctype="multipart/form-data">
<table class="general" align="center" width="80%" border="3" rules="groups">
	<colgroup><col /><col /></colgroup>
	<tbody>
	<tr>
		<th align="left">CLUB</th>
		<th class="left"><?php echo $club; ?></th>
	</tr>
	</tbody>
	<tbody>
	<tr>
		<th rowspan="3" align="left">CHIEN</th>
		<th class="left"><?php echo $nomchien." ".$affixe; ?></th>
	</tr>
	<tr>
		<td><?php if ($lof != ""){echo "Race";} else {echo "Type";} ?>&nbsp;: <b><?php echo $race; ?></b> - Sexe&nbsp;: <b><?php echo $sexe; ?></b>
		<?php if ($lof != ""){echo " - Numéro LOF&nbsp;: <b>$lof</b>";} ?></td>
	</tr>
	<tr>
		<td>Catégorie&nbsp;: <b><?php echo $nomcategories[$categorie]; ?></b> - Identification&nbsp;: <b><?php echo $tatouage." ".$puce; ?></b></td>
	</tr>
	</tbody>
	<tbody>
	<tr>
		<th rowspan="4" align="left">CONDUCTEUR</th>
		<th class="left"><?php echo $titre." ".$nom." ".$prenom; ?></th>
	</tr>
	<tr>
		<td>Classe&nbsp;: <b><?php echo $nomclasses[$classe]; ?></b>
		<?php if ($handi > 0){echo " - Classe Handi&nbsp;: <b>$nomhandis[$handi]</b>";} ?></td>
	</tr>
	<tr>
		<td>Adresse&nbsp;: <b><?php echo $adresse1; ?></b>
		<?php if ($adresse2 != ""){echo " / <b>".$adresse2;} echo " <b>".$cp." ".$ville; ?></b></td>
	</tr>
	<tr>
		<td>email&nbsp;: <b><?php echo $email."</b> - Téléphone&nbsp;: <b>".$telephone; ?></b></td>
	</tr>
	</tbody>
	<?php
	if ($typeconcours == "SGPF"){echo "<input type='hidden' name='epreuve4' value='SGPF'";}
	if ($nbepreuves == 1 and $licence >= 70000 and $licence < 90000){$nbepreuves = 0;}
	if ($nbepreuves > 0){ // Au moins une épreuve à sélectionner
		echo "<tbody><tr><th rowspan='$nbepreuves' align='left'>EPREUVES</th>";

		if ($typeconcours == "CC"){
			if ($lof != "" or ($licence > 70000 and $licence < 90000)){ // Chien de race ou Jeune
				echo "<td>1<sup>er</sup> degré <input type='radio' name='epreuve1' value='1'";
				if ($epreuve1 == 1){echo " checked='checked'";}
				echo " /> / 2<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve1' value='2'";
				if ($epreuve1 == 2){echo " checked='checked'";}
				echo " />";
				if ($licence < 70000 or $licence > 90000){ // Licence senior ou étranger
					echo " / 3<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve1' value='3'";
					if ($epreuve1 == 3){echo " checked='checked'";}
					echo " />";
				}
				echo "</td></tr>";
			}
			if ($licence < 70000 or $licence > 90000){ // Licence senior ou étranger
				echo "<td>Jumping &amp; Open <input type='radio' name='epreuve2' value='normal'";
				if ($epreuve2 == "normal"){echo " checked='checked'";}
				echo " /> / Jumping + &amp; Open + <input type='radio' name='epreuve2' value='plus'";
				if ($epreuve2 == "plus"){echo " checked='checked'";}
				echo " />";
			} else {echo "<input type='hidden' name='epreuve2' value='normal' />";} // Licence jeune
		}
		
		if ($typeconcours == "ChR"){
			if ($licence < 70000){ // Licence senior
				echo "<td>2<sup>ème</sup> degr&eacute; <input type='radio' name='epreuve3degre' value='2'";
				if ($epreuve3degre == 2){echo " checked='checked'";}
				echo " /> / 3<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve3degre' value='3'";
				if ($epreuve3degre == 3){echo " checked='checked'";}
				echo " /></td>";
			}
			if ($licence >= 70000){ // Licence jeune
				echo "<input type='hidden' name='epreuve3' value='ChR' /><input type='hidden' name='epreuve3degre' value='2' />";
			}
		}

		if ($typeconcours == "ChRSGPF"){
			if ($lof != "" or ($licence > 70000 and $licence < 90000)){ // Chien de race ou Jeune
				echo "<td>Championnat Régional <input type='checkbox' name='epreuve3' value='ChR'";
				if ($epreuve3 == "ChR"){echo " checked='checked'";}
				echo " /> / 2<sup>ème</sup> degré <input type='radio' name='epreuve3degre' value='2'";
				if ($epreuve3degre == 2 or $licence > 70000){echo " checked='checked'";}
				echo " />";
				if ($licence < 70000 or $licence > 90000){ // Senior de race
					echo " / 3<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve3degre' value='3'";
					if ($epreuve3degre == 3){echo " checked='checked'";}
					echo " /></td></tr>";
				}
			}
			echo "<tr><td>Sélectif GPF <input type='checkbox' name='epreuve4' value='SGPF'";
			if ($epreuve4 == "SGPF"){echo " checked='checked'";}
			echo " /></td></tr>";
		}
		
		if ($typeconcours === "Comp"){
			echo "<td>Epreuves du concours classique : <br />";
			if ($lof != "" or ($licence > 70000 and $licence < 90000)){ // Chien de race ou Jeune
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1<sup>er</sup> degré <input type='radio' name='epreuve1' value='1'";
				if ($epreuve1 == 1){echo " checked='checked'";}
				echo " /> / 2<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve1' value='2'";
				if ($epreuve1 == 2){echo " checked='checked'";}
				echo " />";
				if ($licence < 70000 or $licence > 90000){ // Licence senior ou étranger
					echo " / 3<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve1' value='3'";
					if ($epreuve1 == 3){echo " checked='checked'";}
					echo " />";
				}
				echo " / Annuler <input type='radio' name='epreuve1' Value='' /><br />";
			}
			if ($licence < 70000 or $licence >= 90000){ // Licence senior ou étranger
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumping &amp; Open <input type='radio' name='epreuve2' value='normal'";
				if ($epreuve2 == "normal"){echo " checked='checked'";}
				echo " /> / Jumping + &amp; Open + <input type='radio' name='epreuve2' value='plus'";
				if ($epreuve2 == "plus"){echo " checked='checked'";}
				echo " /> / Annuler <input type='radio' name='epreuve2' Value='' /></td></tr>";
			} else { // Licence jeune
				echo "<input type='hidden' name='epreuve2' value='normal' /></td></tr>";
			}
			echo "<tr><td>Championnat Régional ";
			if ($_SESSION['Championnat'] == "N"){
					echo ": Ce chien n'est pas de la Régionale. Il ne peut pas participer à cette épreuve</td></tr>";
			} else if ($lof != "" or ($licence >= 70000 and $licence < 900000)){ // Chien de race ou Jeune
				echo "<input type='checkbox' name='epreuve3' value='ChR'";
				if ($epreuve3 == "ChR"){echo " checked='checked'";}
				echo " /> / 2<sup>ème</sup> degré <input type='radio' name='epreuve3degre' value='2'";
				if ($epreuve3degre == 2 or $licence > 70000){echo " checked='checked'";}
				echo " />";
				if ($licence < 70000){ // Senior de race
					echo " / 3<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve3degre' value='3'";
					if ($epreuve3degre == 3){echo " checked='checked'";}
					echo " /></td></tr>";
				}
			} else {
				echo ": Chien non LOF. Ne peut pas participer à cette épreuve.</td></tr>";
			}
			echo "<tr><td>Sélectif GPF ";
			if ($_SESSION['Championnat'] == "N"){
				echo ": Ce chien n'est pas de la Régionale. Il ne peut pas participer à cette épreuve</td></tr>";
			} else {
				if ($licence < 900000){ // Chien non étranger
					echo "<input type='checkbox' name='epreuve4' value='SGPF'";
					if ($epreuve4 == "SGPF"){echo " checked='checked'";}
					echo " /></td></tr>";
				}
			}
		}
	}
		

/* FINALES **************************************************
		if ($_SESSION['TypeConcours'] == "ChF"){
			echo "<td>2<sup>ème</sup> degré <input type='radio' name='epreuve1' value='2'";
			$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='15'";
			if (mysql_num_rows(mysql_query($query)) > 0){echo " checked='checked'";}
			echo " /> / 3<sup>&egrave;me</sup> degr&eacute; <input type='radio' name='epreuve1' value='3'";
			$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Epreuve='18'";
			if (mysql_num_rows(mysql_query($query)) > 0){echo " checked='checked'";}
			echo " />";
		}
//	}*/
	mysql_close();
	?>
	</tbody>
</table>
<table class="general" align="center" width="80%" border="1" rules="groups">
	<colgroup><col width="25%" /><col width="25%" /><col width="25%" /><col width="*" /></colgroup>
	<tbody>
	<tr>
		<th class="left"><div class="bouton"><a href="<?php echo $retour; ?>">RETOUR</a></div></th>
		<th align="center"><?php if ($agi1 == "Y"){echo "<input type='submit' name='supprimer' value='RETIRER CE CONCURRENT' />";} ?></th>
		<th align="center"><div class="bouton" align="center"><a href="../../boiteaoutils/maj_licencesmodif.php">MODIFIER LES DONNEES</a></div></th>
		<th class="right"><input type="submit" name="validconcurrent" value="VALIDER LE CONCURRENT" /></th>
	</tr>
	</tbody>
</table>
</form>
</body>
</html>