<?php
session_start();
if ($_SESSION['Flag_Local'] == "Y"){
	$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_resultats.php'>Entrée des résultats</a>";
	include("../utilitaires/bandeau_agi.php");
}
include("../utilitaires/nomvars_agi.php");
include("../../communs/connexion.php");
$choixepreuve = $_SESSION['ChoixEpreuve'];
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
// Validation résultats
if (isset($_POST['entresultats']) and $_SESSION['Flag_local'] == "Y"){
	$dossard = $_POST['dossard'];
	$temps = str_replace(",", ".", $_POST['temps']);
	$refus = $_POST['refus'];
	$fautes = $_POST['fautes'];
	$resultat = $_POST['resultat'];
	$brevet = $_POST['brevet'];
	if ($resultat == "E" or $resultat == "A" or $resultat == "F" or $refus >= 3){$temps = 0;}
	$query = "SELECT * FROM agility_epreuves WHERE Id='$choixepreuve'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	if ($resultat != "A" and $resultat != "F" and ($refus >= 3 or $temps > $tmp)){$resultat = "E";}
	if ($resultat == "E" or $resultat == "A" or $resultat == "F"){
		$penalites = 50;
	} else {
		if ($temps < $tps / 3){
			//**************************************************
			$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_resultats.php'>Entrée des résultats</a>";
			include("../utilitaires/bandeau_agi.php");
			echo "<h3 class='center'>Entrée ou Modification des résultats</h3>";
			//**************************************************
			echo "<p class='center'><span class='alert'>&nbsp;Temps trop faible&nbsp;</span></p>
			<p class='center'>Résultats non pris en compte</p>
			<table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultats.php'>RETOUR</a></div></td></tr></table>";
			exit;
		} else {$resultat = "P";}
		if ($temps > $tps){$depastemps = $temps - $tps;} else {$depastemps = 0;};
		$penalites = ($fautes + $refus) * 5;
	}
	$total = $penalites + $depastemps;
	if ($resultat == "P"){
		if ($total < 6){$resultat = "X";}
		else if ($total < 16){$resultat = "T";}
		else if ($total < 26){$resultat = "B";}
		else {$resultat = "N";}
	}
	if ($epreuve == "1" and $classe == "1" and $brevet > "0"){
		if ($resultat != "X" or $fautes > 0 or $refus > 0 or $depastemps > 0){
			$brevet = "0";
			//**************************************************
			$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_resultats.php'>Entrée des résultats</a>";
			include("../utilitaires/bandeau_agi.php");
			echo "<h3 class='center'>Entrée ou Modification des résultats</h3>";
			//**************************************************
			echo "<p class='center'><span class='alert'>&nbsp;ATTENTION : Brevet invalide&nbsp;</span></p>
			<p class='center'>Résultats non pris en compte</p>
			<table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultats.php'>RETOUR</a></div></td></tr></table>";
			exit;
		}
	}
	if ($epreuve == "1" and $classe == "1" and $resultat == "X" and $fautes == "0" and $refus == "0" and $depastemps = 0 and $brevet == ""){
		//**************************************************
		$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_resultats.php'>Entrée des résultats</a>";
		include("../utilitaires/bandeau_agi.php");
		echo "<h3 class='center'>Entrée ou Modification des résultats</h3>";
		//**************************************************
		echo "<p class='center'><span class='alert'>&nbsp;ATTENTION : Vous devez indiquer une partie de Brevet&nbsp;</span></p>
		<p class='center'>Résultats non pris en compte</p>
		<table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultats.php'>RETOUR</a></div></td></tr></table>";
		exit;
	}
	if ($classe > 1){$brevet = 0;}
	$query = "UPDATE agility_resultats SET Temps='$temps', Fautes='$fautes', Refus='$refus', Penalites='$penalites', Depastemps='$depastemps',	Total='$total', Resultat='$resultat', Brevet='$brevet' WHERE Dossard='$dossard' AND IdEpreuve='$choixepreuve'";
	mysql_query($query);
	// Classement pour cette épreuve
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='".$_SESSION['ChoixEpreuve']."' AND Resultat<>'' ORDER BY Total, Penalites, Temps";
	$result = mysql_query($query);
	$total_preced = "";
	$penalites_preced = "";
	$temps_preced = "";
	$place = 1;
	$rang = 1;
	while ($row = mysql_fetch_assoc($result)){
		$id = $row['Id'];
		$total = $row['Total'];
		$penalites = $row['Penalites'];
		$temps = $row['Temps'];
		$resultat = $row['Resultat'];
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
		$query = "UPDATE agility_resultats SET Classement='$classement' WHERE Id='$id'";
		mysql_query($query);
	}
	// Cumuls championnats
	if ($epreuve == 9 or $epreuve == 10){
		$epreuves = "XXXXXXXXXYYXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
//		$query = "SELECT Id FROM agility_resultats WHERE Epreuve='11' AND Dossard='$dossard'";
//		$result = mysql_query($query);
//		if (mysql_num_rows($result) > 0){
			$epreuvecalculee = 11; // ChR 2ème degré
			include("pendantagi_resultats_ChR.php");
//		}
		$epreuvecalculee = 12; // CoupeR 2ème degré
		include("pendantagi_resultats_ChR.php");
	}
	if ($epreuve == 13 or $epreuve == 14){
		$epreuves = "XXXXXXXXXXXXXYYXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
		$query = "SELECT Id FROM agility_resultats WHERE Epreuve='15' AND Dossard='$dossard'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			$epreuvecalculee = 15; // ChR 3ème degré
			include("pendantagi_resultats_ChR.php");
		}
		$epreuvecalculee = 16; // CoupeR 3ème degré
		include("pendantagi_resultats_ChR.php");
	}
	if ($epreuve == 17 or $epreuve == 18){
		$epreuves = "XXXXXXXXXXXXXXXXXYYXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
		$epreuvecalculee = 19; // SGPF
		include("pendantagi_resultats_ChR.php");
	}
	$_SESSION['Flag_local'] = "N";
	$_SESSION['Epreuve'] = $epreuve;
	$_SESSION['Categorie'] = $categorie;
	$_SESSION['Classe'] = $classe;
	$_SESSION['Handi'] = $handi;
	include('pendantagi_resultats.php');
	exit;
}
$_SESSION['Flag_local'] = "Y";
?>
<h3 class="center">Entrée ou Modification des résultats</h3>
<?php
// Frappe des résultats d'un dossard sélectionné
if (isset($_GET['dossard'])){
	$dossard = $_GET['dossard'];
	$query = "SELECT * FROM agility_epreuves WHERE Id='$choixepreuve'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$epreuve = $row['Epreuve'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	$query = "SELECT * FROM agility_resultats WHERE Dossard='$dossard' AND IdEpreuve='$choixepreuve'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0){
		echo "<p class='center'><span class='alert'>&nbsp;Numéro de dossard $dossard non enregistré pour cette épreuve&nbsp;</span></p>
		<table align='center' width='100%'><tr><th align='center'><div class='boutonchoix'><a href='../avant/avantagi_modifconcurrent.php?dossard=$dossard'>Modifier l'enregistrement de ce concurrent</a></div><br /><span class='alarm'>&nbsp;Attention, cette opération effacera tous les résultats déjà enregistrés pour ce concurrent&nbsp;</span></th></tr></table>
		</table><table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultats.php'>RETOUR</a></div></th></tr></table>";
		mysql_close();
		exit;
	}
	$row = mysql_fetch_assoc($result);
	$idlicence = $row['IdLicence'];
	$licence = $row['Licence'];
	$temps = $row['Temps'];
	$fautes = $row['Fautes'];
	$refus = $row['Refus'];
	if ($fautes == 0){$fautes = "";}
	if ($refus == 0){$refus = "";}
	if ($temps == 0){$temps = "";}
	$resultat = $row['Resultat'];
	$brevet = $row['Brevet'];
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result1 = mysql_query($query);
	$row = mysql_fetch_assoc($result1);
	$nomchien = $row['NomChien'];
	$coderace = $row['CodeRace'];
	$sexe = $row['Sexe'];
	$nom = $row['Nom']." ".$row['Prenom'];
	$codeclub = $row['CodeClub'];
	$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
	$result1 = mysql_query($query);
	$row = mysql_fetch_assoc($result1);
	$race = $row['Race'];
	$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
	$result1 = mysql_query($query);
	$row = mysql_fetch_assoc($result1);
	$club = $row['Club'];
	$coderegionale = $row['CodeRegionale'];
	$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
	$result1 = mysql_query($query);
	$row = mysql_fetch_assoc($result1);
	$regionale = $row['Regionale'];
	if ($epreuve >= "9" and $epreuve <= "12"){
		$query = "SELECT PenalitesAnt FROM agility_resultats WHERE Dossard='$dossard'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$penalitesant = $row['PenalitesAnt'];
	}
	echo "<p class='center'>Epreuve : $nomepreuves[$epreuve] - Catégorie : $nomcategories[$categorie]";
	if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){echo " - Classe : $nomclasses[$classe]";}
	echo "<br />TPS : $tps - TMP : $tmp</p>
	<form action='pendantagi_resultats.php' method='post'>
	<table class='general' align='center' border='1' rules='groups'>
	<colgroup><col /><col /></colgroup>
	<tbody>
	<tr><td align='right'>Dossard : </td><td><input type='hidden' name='dossard' value='$dossard' />$dossard</td></tr>
	<tr><td align='right'>Chien : </td><td>$nomchien</td></tr>
	<tr><td align='right'>Race : </td><td>$race</td></tr>
	<tr><td align='right'>Conducteur : </td><td>$nom</td></tr>";
	if ($epreuve >= "9" and $epreuve <= "12"){echo "<tr><td align='right'>Pénalités antérieures : </td><td>$penalitesant</td></tr>";}
	echo "</tbody>
	<tbody>
	<tr><td align='right'>Temps réalisé :</td><td><input id='1' type='text' name='temps' value='$temps' /></td></tr>
	<tr><td align='right'>Nombre de fautes :</td><td><input type='text' name='fautes' value='$fautes' /></td></tr>
	<tr><td align='right'>Nombre de refus :</td><td><input type='text' name='refus' value='$refus' /></td></tr>
	<tr><td align='right'>Mention :</td><td>Eliminé <input type='radio' name='resultat' value='E'";
	if ($resultat == "E" and $temps == 0){echo " checked='checked'";}
	echo " /> / Abandon <input type='radio' name='resultat' value='A'";
	if ($resultat == "A"){echo " checked='checked'";}
	echo " /> / Forfait <input type='radio' name='resultat' value='F'";
	if ($resultat == "F"){echo " checked='checked'";}
	echo " /> / Annuler mention <input type='radio' name='resultat' value='P'";
	if ($resultat == "P"){echo " checked='checked'";}
	echo " /></td></tr></tbody>";
	if ($epreuve == 1 and $classe == 1){ // Senior - Partie de brevet
		echo "<tbody><tr><td align='right' valign='bottom'>Brevet : </td>
		<td>1<sup>ère</sup> partie <input type='radio' name='brevet' value='1'";
		if ($brevet == '1'){echo " checked='checked'";}
		echo " /> / 2<sup>ème</sup> partie <input type='radio' name='brevet' value='2'";
		if ($brevet == '2'){echo " checked='checked'";}
		echo " /> / 3<sup>ème</sup> partie <input type='radio' name='brevet' value='3'";
		if ($brevet == '3'){echo " checked='checked'";}
		echo " /> / Annullation <input type='radio' name='brevet' value='0'";
		if ($brevet == '0'){echo " checked='checked'";}
		echo " /></tr></tbody>";
	}
	?>
	<tbody>
	<tr><th class="left"><div class='bouton'><a href='pendantagi_resultats.php'>RETOUR</a></div></th><td class="right"><input type='submit' name='entresultats' value='Valider' /></td></tr>
	</tbody>
	</table>
	<?php
	mysql_close();
	exit;
}

// Epreuve choisie
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
	$tps = $row['TPS'];
	$tmp = $row['TMP'];
	$_SESSION['ChoixEpreuve'] = $idepreuve;
	$_SESSION['Epreuve'] = $epreuve;
	$_SESSION['Categorie'] = $categorie;
	$_SESSION['Classe'] = $classe;
	$_SESSION['Handi'] = $handi;
	if ($juge == "" or $tps == 0 or $tmp == 0){
		$_SESSION['RetourEpreuves'] = "pendantagi_resultats.php";
		$_SESSION['Flag_Programme'] = "Y";
		include("pendantagi_epreuves_1.php");
		exit;
	}
}

// Entrée du numéro de dossard si épreuve choisie
if ($_SESSION['ChoixEpreuve'] != ""){
	$choixepreuve = $_SESSION['ChoixEpreuve'];
	$query = "SELECT * FROM agility_epreuves WHERE Id='$choixepreuve'";
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
	echo "<p class='center'><b>$nomepreuves[$epreuve] - Catégorie $nomcategories[$categorie]";
	if ($_SESSION['TypeConcours'] != "ChF" and $_SESSION['TypeConcours'] != "GPF"){echo " - Classe $nomclasses[$classe]";}
	if ($handi > 0){echo " - Handi : $handi";}
	echo "</b><br />Juge $juge - $nbobstacles obstacles - Longueur&nbsp;: $longueur&nbsp;m - Vitesse&nbsp;: $vitesse&nbsp;m/s - TPS&nbsp;: $tps&nbsp;sec - TMP&nbsp;: $tmp&nbsp;sec</p>";
	echo "<form method='get' action='pendantagi_resultats.php'><p class='center'>Dossard : <input id='1' type='text' name='dossard' /><input type='submit' name='valider' value='Valider' /></p></form>";
	// Nombre de concurrents
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$choixepreuve'";
	$result = mysql_query($query);
	$nb_concurrents = mysql_num_rows($result);
	// Liste des concurrents sans résultats
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$choixepreuve' AND Resultat='' ORDER BY Dossard";
	$result = mysql_query($query);
	$nb_resultats = mysql_num_rows($result);
	echo "<p class='center'>Résultats à entrer : $nb_resultats / $nb_concurrents</p>";
	if ($nb_resultats > 0){echo "<table class='general' align='center'><tr><th>Dossard</th><th>Chien</th><th>Race</th><th>Conducteur</th><th>Club</th></tr>";}
	$fond = "clair";
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['IdLicence'];
		$licence = $row['Licence'];
		$dossard = $row['Dossard'];
		$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$nomchien = $row['NomChien'];
		$coderace = $row['CodeRace'];
		$sexe = $row['Sexe'];
		$nom = $row['Nom']." ".$row['Prenom'];
		$codeclub = $row['CodeClub'];
		$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$race = $row['Race'];
		$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$club = $row['Club'];
		$coderegionale = $row['CodeRegionale'];
		$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$regionale = $row['Regionale'];
		echo "<tr class='$fond' align='center'><td><a href='pendantagi_resultats.php?dossard=$dossard'>$dossard</a></td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club / $regionale</td></tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
	echo "</table><table align='center'><tr><th><div class='bouton'><a href='pendantagi_resultats_1.php'>RETOUR</a></div></th></tr></table>";
	// Liste des concurrents avec résultats
	$query = "SELECT * FROM agility_resultats WHERE IdEpreuve='$choixepreuve' AND Resultat<>'' ORDER BY Dossard";
	$result = mysql_query($query);
	$nb_resultats = mysql_num_rows($result);
	if ($nb_resultats > 0){
		echo "<table class='general' align='center'><tr><th>Dossard</th><th>Chien</th><th>Race</th><th>Conducteur</th><th>Club</th><th>Temps</th><th>Fautes</th><th>Refus</th><th>Pénalités</th><th>Qualif.</th>";
		if ($epreuve == "1" and $classe == "1"){echo "<th>Brevet</th>";}
		echo "</tr>";
	}
	$fond = "clair";
	while ($row = mysql_fetch_assoc($result)){
		$idlicence = $row['IdLicence'];
		$licence = $row['Licence'];
		$dossard = $row['Dossard'];
		$temps = $row['Temps'];
		$fautes = $row['Fautes'];
		$refus = $row['Refus'];
		$penalites = $row['Total'];
		$penalitesant = $row['PenalitesAnt'];
		$nomresultat = $nomresultats[$row['Resultat']];
		$nombrevet = $nombrevets[$row['Brevet']];
		$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$nomchien = $row['NomChien'];
		$coderace = $row['CodeRace'];
		$sexe = $row['Sexe'];
		$nom = $row['Nom']." ".$row['Prenom'];
		$codeclub = $row['CodeClub'];
		$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$race = $row['Race'];
		$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$club = $row['Club'];
		$coderegionale = $row['CodeRegionale'];
		$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
		$result1 = mysql_query($query);
		$row = mysql_fetch_assoc($result1);
		$regionale = $row['Regionale'];
		echo "<tr class='$fond' align='center'><td><a href='pendantagi_resultats.php?dossard=$dossard'>$dossard</a></td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club / $regionale</td><td>$temps</td><td>$fautes</td><td>$refus</td><td>$penalites</td><td>$nomresultat</td>";
		if ($epreuve == "1" and $classe == "1"){echo "<td>$nombrevet</td>";}
		echo "</tr>";
		if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
	}
	mysql_close();
	exit;
}

mysql_close();

// Choix de l'épreuve
$epreuve_preced = $_SESSION['Epreuve'];
$categorie_preced = $_SESSION['Categorie'];
$classe_preced = $_SESSION['Classe'];
$handi_preced = $_SESSION['Handi'];
?>
<form method="post" action="pendantagi_resultats.php" enctype="multipart/form-data">
<table class="general" align="center" border="1" rules="groups">
	<colgroup><col /><col /></colgroup>
	<tbody>
	<tr><td align="right">Epreuve : </td><td align="right"><select name="epreuve">
		<?php
		for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
			if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
				echo "<option value='$epreuve'";
				if ($epreuve == $epreuve_preced){echo " selected='selected'";}
				echo ">$nomepreuves[$epreuve]</option>";
			}
		}
		?>
		</select></td>
	</tr>
	<tr><td align="right">Catégorie : </td><td align="right"><select name="categorie">
		<?php
		for ($categorie = "1"; $categorie <= "4"; $categorie++){
			echo "<option value='$categorie'";
			if ($categorie == $categorie_preced){echo " selected='selected'";}
			echo ">$nomcategories[$categorie]</option>";
		}
		?>
		</select></td>
	</tr>
	<?php
	if ($_SESSION['TypeConcours'] != "ChF"){
		echo "<tr><td align='right'>Classe : </td><td align='right'><select name='classe'>";
		for ($classe = 1; $classe <= 3; $classe++){
			echo "<option value='$classe'";
			if ($classe == $classe_preced){echo " selected='selected'";}
			echo ">$nomclasses[$classe]</option>";
		}
		echo "</select></td></tr>";
	}
	?>
	<tr><td align="right">Handi : </td><td align="right"><select name="handi">
		<?php
		for ($handi = "0"; $handi <= "5"; $handi++){
			echo "<option value='$handi'";
			if ($handi == $handi_preced){echo " selected='selected'";}
			echo ">$nomhandis[$handi]</option>";
		}
		?>
		</select></td>
	</tr>
	</tbody>
	<tbody>
	<tr><th class="left"><div class="bouton"><a href="pendantagi.php">RETOUR</a></div></th><td class="right"><input type="submit" name="choixepreuve" value="Valider" /></td></tr>
	</tbody>
</table>
</form>
</body>
</html>