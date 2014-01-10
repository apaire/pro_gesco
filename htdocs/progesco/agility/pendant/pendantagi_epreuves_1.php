<?php
session_start();
include("../utilitaires/nomvars_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript1.2" src="../../communs/programmes.js"></script>
</head>
<body onload="donner_focus('1')">
<?php
// msg = message d'erreur. Les données ne sont pas enregistrées
// msgano = message d'anomalie non bloquante. Le message est affiché et les données sont enregistrées
$_SESSION['RetourJugesAjout'] = "../agility/pendant/pendantagi_epreuves_1.php?choixepreuve=true";
$_SESSION['Flag_AppelProgramme'] = "Y";
// Connexion bdd
include("../../communs/connexion.php");
if (isset($_POST['valider'])){
	$msg = "";
	$msgano = "";
	$idepreuve = $_SESSION['choixepreuve'];
	$idjuge = $_POST['idjuge'];
	$nbobstacles = $_POST['nbobstacles'];
	$longueur = $_POST['longueur'];
	$vitesse = str_replace(",", ".", $_POST['vitesse']);
	$tps = $_POST['tps'];
	$tmp = $_POST['tmp'];
	$query = "SELECT * FROM cneac_juges WHERE Id='$idjuge'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$juge = $row['Nom']." ".$row['Prenom'];
	$_SESSION['juge'] = $juge;
	$juge = mysql_real_escape_string($juge);
	if ($longueur < 99 or $longueur > 201){
		$msg .= "La longueur du parcours $longueur mètres est incorrecte. Elle doit être comprise entre 100 et 200 mètres<br />";
	}
	if ($tps > 0){$vitessecalc = round(($longueur / $tps) * 10) / 10;}
	if ($vitesse != $vitessecalc){
		$msgano .= "La vitesse calculée d'après le TPS ($vitessecalc) est différente de la vitesse entrée ($vitesse)<br />
			La vitesse calculée est prise en compte";
		$vitesse = $vitessecalc;
	}
	if ($idjuge == ""){$msg .= "Juge<br />";}
	if ($nbobstacles == 0){$msg .= "Nombre d'obstacles<br />";}
	if ($longueur == 0){$msg .= "Longueur du parcours<br />";}
	if ($tps == 0){$msg .= "TPS<br />";}
	if ($tmp == 0){$msg .= "TMP";}
	$tmpmini = $tps * 1.5 - 1;
	$tmpmaxi = ceil($tps * 2);
	if ($tmp < $tmpmini or $tmp > $tmpmaxi){$msg .= "TPS et TMP incompatibles";}
	if ($msg != "" or $msgano != ""){
		//************************************************
		if ($_SESSION['Flag_Programme'] != "Y"){
			$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_epreuves.php'>Entrée des paramètres des épreuves</a>";
			include("../utilitaires/bandeau_agi.php");
		}
		//************************************************
		echo "<table class='general' align='center'><tr><th><span class='alert'>&nbsp;Données manquantes ou anomalies détectées&nbsp;</span><br />$msg</th></tr><tr><th>$msgano</th></tr>";
		if ($msg != ""){
			echo "<tr><th align='center'><div class='bouton'><a href='pendantagi_epreuves_1.php'>RETOUR</a></div></td></tr></table>";
			exit;
		}
	}
	echo "</table>";
	$query = "UPDATE agility_epreuves SET Juge='$juge', NbObstacles='$nbobstacles', Longueur='$longueur', Vitesse='$vitesse', TPS='$tps', TMP='$tmp' WHERE Id='$idepreuve'";
	if (!mysql_query($query)){echo $query." - ".mysql_error();}
	$_SESSION['drapeau_epreuve'] = "Y";
	// Recalcul pénalités de temps
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$idepreuve' AND Temps>'0'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$epreuve = $row['Epreuve'];
		$fautes = $row['Fautes'];
		$refus = $row['Refus'];
		$temps = $row['Temps'];
		if ($temps > $tmp){
			$resultat = "E";
			$query = "UPDATE agility_resultats SET Penalites='50', Depastemps='0', Total='50', Resultat='E' WHERE Id='$id'";
		} else {
			if ($temps > $tps){$depastemps = $temps - $tps;} else {$depastemps = 0;}
			$penalites = ($fautes + $refus) * 5;
			$total = $penalites + $depastemps;
			if ($total < 6){$resultat = "X";}
			else if ($total < 16){$resultat = "T";}
			else if ($total < 26){$resultat = "B";}
			else {$resultat = "N";}
			$query = "UPDATE agility_resultats SET Depastemps='$depastemps', Total='$total', Resultat='$resultat' WHERE Id='$id'";
		}
		mysql_query($query);
	}
	// Recalcul classement
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$idepreuve' AND Resultat<>'' ORDER BY Total, Penalites, Temps";
	$result = mysql_query($query);
	$total_preced = "";
	$penalites_preced = "";
	$temps_preced = "";
	$place = 1;
	$rang = 1;
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$dossard = $row['Dossard'];
		$total = $row['Total'];
		$penalites = $row['Penalites'];
		$temps = $row['Temps'];
		$resultat = $row['Resultat'];
		$brevet = $row['Brevet'];
		if ($resultat == "N"){$classement = "9995";} // Non Classé
		if ($resultat == "E"){$classement = "9996";} // Eliminé
		if ($resultat == "A"){$classement = "9997";} // Abandon
		if ($resultat == "F"){$classement = "9998";} // Forfait
		if ($resultat == "X" or $resultat == "T" or $resultat == "B"){ // Parcours OK
			if ($total != $total_preced or $penalites != $penalites_preced or $temps != $temps_preced){ // Non Exequo
				$place = $rang;
			}
			$classement = $place;
			$total_preced = $total;
			$penalites_preced = $penalites;
			$temps_preced = $temps;
			$rang++;
		}
		if ($epreuve == "1" and $classe == "1"){ // Recalcul brevet
			if ($brevet != ""){
				if ($resultat != "E" or $penalites > 0){$brevet = "";}
			}
			if ($brevet == "" and $resultat == "E" and $penalites == 0){
				$msg .= "<span class='alarm'>&nbsp;ATTENTION : du fait des modifications de l'épreuve, un brevet doit être attribué au dossard $dossard&nbsp;</span>";
			}
		}
		$query = "UPDATE agility_resultats SET Classement='$classement', Brevet='$brevet' WHERE Id='$id'";
		if (!mysql_query($query)){echo "Erreur de classement";}
	}
	echo "<p class='center'><span class='alert'>$msg</span></p>";
	if ($_SESSION['Flag_Programme'] == "Y"){include($_SESSION['RetourEpreuves']);}
	else {include('pendantagi_epreuves.php');}
	exit;
}
//************************************************
if ($_SESSION['Flag_Programme'] != "Y"){
	$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_epreuves.php'>Entrée des paramètres des épreuves</a>";
	include("../utilitaires/bandeau_agi.php");
}
//************************************************
?>
<h3 class="center">Entrée des paramètres des épreuves</h3>
<?php
if (isset($_POST['choixepreuve'])){
	$epreuve = $_POST['epreuve'];
	$categorie = $_POST['categorie'];
	$classe = $_POST['classe'];
	$handi = $_POST['handi'];
	if ($classe == ""){$classe = 1;}
	$query = "SELECT * FROM agility_epreuves WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$idepreuve = $row['Id'];
	$juge = $row['Juge'];
	$nbobstacles = $row['NbObstacles'];
	$longueur = $row['Longueur'];
	$vitesse = $row['Vitesse'];
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	// Concurrents enregistrés
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$idepreuve'";
	$result1 = mysql_query($query);
	if (mysql_num_rows($result1) == 0){
		echo "<p class='center'><span class='alert'>&nbsp;Aucun concurrent n'est enregistré pour cette épreuve&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='";
		if ($_SESSION['Flag_Programme'] == "Y"){echo "pendantagi_resultats_1.php";}
		else {echo "pendantagi_epreuves.php";}
		echo "'>RETOUR</a></div></th></tr></table>";
		exit;
	}
	$_SESSION['choixepreuve'] = $idepreuve;
	$_SESSION['Epreuve'] = $epreuve;
	$_SESSION['Categorie'] = $categorie;
	$_SESSION['Classe'] = $classe;
	$_SESSION['Handi'] = $handi;
}

if ($_SESSION['choixepreuve'] > 0){
	$idepreuve = $_SESSION['choixepreuve'];
	// Epreuve
	$query = "SELECT * FROM agility_epreuves WHERE Id='$idepreuve'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	$juge = $row['Juge'];
	$nbobstacles = $row['NbObstacles'];
	$longueur = $row['Longueur'];
	$vitesse = $row['Vitesse'];
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	if ($nbobstacles == 0 and $longueur == 0 and $vitesse == 0){
		for ($c = 1; $c <= 4; $c++){
			$query = "SELECT * FROM agility_epreuves WHERE Epreuve='$epreuve' AND Categorie='$c' AND Classe='1' AND Handi='0'";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$juge = $row['Juge'];
			$nbobstacles = $row['NbObstacles'];
			$longueur = $row['Longueur'];
			$vitesse = $row['Vitesse'];
			$tps = $row['TPS'];
			$tmp = $row['TMP'];
			if ($tps > 0){break;}
		}
	} else {
		echo "<h4 class='center'><span class='alarm'>&nbsp;Les caractéristiques de cette épreuve ont déjà été entrées&nbsp;<br />
			&nbsp;Vous vous apprêtez à les modifier&nbsp;</span><br />
			Si ce n'est pas le cas, cliquez sur retour</h4>";
	}
	if ($juge == ""){$juge = $_SESSION['Juge'];}
	$tpscalc = $_SESSION['tpscalc'];
	$tmpmin = $_SESSION['tmpmin'];
	$tmpmax = $_SESSION['tmpmax'];
	if ($nbobstacles == 0){$nbobstacles = "";}
	if ($longueur == 0){$longueur = "";}
	if ($vitesse == 0){$vitesse = "";}
	if ($tps == 0){$tps = "";}
	if ($tmp == 0){$tmp = "";}
	
	?>
	
	<h4 class='center'><span class="red">*</span> = champ obligatoire</h4>
	<form action='pendantagi_epreuves_1.php' method='post' enctype='multipart/form-data'>
	<table class='general' align='center' border='1' rules='groups'>
		<colspan><col /><col /></colgroup>
		<thead>
		<tr><td align='right'>Epreuve :</td><td><input type='hidden' name='id' value='<?php echo $id; ?>' /><?php echo $nomepreuves[$epreuve]; ?></td></tr>
		<tr><td align='right'>Catégorie :</td><td><?php echo $nomcategories[$categorie]; ?></td></tr>
		<?php
		if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){
			echo "<tr><td align='right'>Classe :</td><td>$nomclasses[$classe]</td></tr>";
		}
		?>
		<tr><td align='right'>Handi :</td><td><?php echo $nomhandis[$handi]; ?></td></tr>
		</thead>
		<tbody>
		<tr><td align='right'>Juge :</td><td><select id="1" name='idjuge'>
	<?php
	$query = "SELECT * FROM cneac_juges ORDER BY Nom, Prenom";
	$result = mysql_query($query);
	$nb_juges = mysql_num_rows($result);
	if ($juge == ""){$juge = $_SESSION['Juge'];}
	for ($n=0; $n<$nb_juges; $n++){
		$row = mysql_fetch_assoc($result);
		$idjuges = $row['Id'];
		$noms = $row['Nom']." ".$row['Prenom'];
		echo "<option value='$idjuges'";
		if ($noms == $juge){echo " selected='selected'";}
		echo ">$noms</option>";
	}
	?>
		</select><span class='red'>*</span> <a href='../../boiteaoutils/maj_jugesajout.php'>Si le Juge n'est pas dans la liste, cliquez ICI.</a>
		</td></tr>
		<tr><td class='right'>Nombre d'obstacles :</td><td><input type='text' name='nbobstacles' value='<?php echo $nbobstacles; ?>' size='1' /><span class='red'>*</span></td></tr>
		<tr><td class='right'>Longueur du parcours (en mètres) :</td><td><input type='text' name='longueur' value='<?php echo $longueur; ?>' size='1' /><span class='red'>*</span></td></tr>
		<tr><td align='right'>Vitesse moyenne d'évolution (en mètres par seconde) :</td><td><input type='text' name='vitesse' value='<?php echo $vitesse; ?>' size='1' /></td></tr>
		<tr><td align='right'>Temps de Parcours Standard (en secondes) :</td><td><input type='text' name='tps' value='<?php echo $tps; ?>' size='1' /><span class='red'>*</span> <?php if ($tpscalc > 0){echo "TPS calculé : $tpscalc";} ?></td></tr>
		<tr><td align='right'>Temps Maximum de Parcours (en secondes) :</td><td><input type='text' name='tmp' value='<?php echo $tmp; ?>' size='1' /><span class='red'>*</span> <?php if ($tmpmin > 0){echo $tmpmin." < TMP < ".$tmpmax;} ?></td></tr>
		</tbody>
		<tbody>
		<tr><th class='left'><div class='bouton'><a href='
		<?php
		if ($_SESSION['Flag_Programme'] == "Y"){echo $_SESSION['RetourEpreuves'];}
		else {echo "pendantagi_epreuves.php";}
		?>
		'>RETOUR</a></div></th><td class="right"><input type='submit' name='valider' value='Valider' /></td></tr>
		</tbody>
	</table>
	</form>
	<?php
	exit;
}
?>
</body>
</html>