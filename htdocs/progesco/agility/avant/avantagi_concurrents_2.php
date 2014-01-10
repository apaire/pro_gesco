<?php
session_start();
$retour = $_SESSION['RetourConcurrents1'];
include("../../communs/connexion.php");
$flag_affichage = "N";
// TRAITEMENTS
// Entrée de la licence
$idlicence = $_SESSION['IdLicence'];
$licence = $_SESSION['Licence'];
// Supprimer concurrent
if (isset($_POST['supprimer'])){
	$query = "UPDATE cneac_licences SET AGI1='N' WHERE Id='$idlicence'";
	mysql_query($query);
	$query = "DELETE FROM agility_resultats WHERE Licence='$licence'";
	mysql_query($query);
	$query = "DELETE FROM agility_penalants WHERE Licence='$licence'";
	mysql_query($query);
	$_SESSION['IdLicence'] = "";
	$_SESSION['Licence'] = "";
	include("avantagi_concurrents.php");
	exit;
}

// Modifier licence
if (isset($_POST['modiflicence'])){
	include("../../boiteaoutils/maj_licencesmodif.php");
	exit;
}
// Enregistrement concurrent
if (isset($_POST['validconcurrent'])){
	// Concurrent déjà enregistré avec conducteur différent
	$query = "SELECT Id FROM cneac_licences WHERE Licence='$licence' AND AGI1='Y'";
	$result = mysql_query($query);
	$dossard = "";
	if (mysql_num_rows($result) > 0){
		$row = mysql_fetch_assoc($result);
		$idlicencesuprim = $row['Id'];
		$query = "UPDATE cneac_licences SET AGI1='N' WHERE Id='$idlicencesuprim'";
		mysql_query($query);
		// Récupération N° de dossard
		$query = "SELECT Dossard FROM agility_resultats WHERE Licence='$licence'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$dossard = $row['Dossard'];
		// Suppression du concurrent dans table résultats
		$query = "DELETE FROM agility_resultats WHERE Licence='$licence'";
		mysql_query($query);
	}
	$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$lof = $row['LOF'];
	$categorie = $row['Categorie'];
	$classe = $row['Classe'];
	$handi = $row['Handi'];
	if ($handi == ""){$handi = 0;}
	// Mise à jour de la table des résultats
	// Recherche si dossard déjà attribué
	if ($_SESSION['Dossards'] > 0 and $dossard == ""){
		$query = "SELECT Dossard FROM agility_resultats WHERE IdLicence='$idlicence'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) == 0){ // Nouveau concurrent
			$query = "SELECT Dossard FROM agility_resultats ORDER BY Dossard DESC LIMIT 1";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$dossard = $row['Dossard'];
			$dossard++;
		} else {
			$row = mysql_fetch_assoc($result);
			$dossard = $row['Dossard'];
		}
	}
	$query = "SELECT Id FROM agility_resultats WHERE IdLicence='$idlicence' AND Resultat<>''";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0){$_SESSION['Message'] = "<p class='center'><span class='alert'>&nbsp;ATTENTION : les Résultats déjà enregistrés pour ce concurrents vont être effacés. Il faudra les réentrer&nbsp;</span></p>";}
	$query = "DELETE FROM agility_resultats WHERE IdLicence='$idlicence'";
	mysql_query($query);

	$epreuve1 = $_POST['epreuve1'];
	$epreuve2 = $_POST['epreuve2'];
	$epreuve3 = $_POST['epreuve3'];
	$epreuve4 = $_POST['epreuve4'];
	$epreuve3degre = $_POST['epreuve3degre'];
	$typeconcours = $_SESSION['TypeConcours'];
	if ($licence >= 70000 and $epreuve3 == "ChR"){$epreuve3degre = 2;}
	if ($licence >= 70000 and $licence < 90000 and $epreuve1 != ""){$epreuve2 = "normal";}
	$_SESSION['Epreuve1'] = $epreuve1;
	$_SESSION['Epreuve2'] = $epreuve2;
	$_SESSION['Epreuve3'] = $epreuve3;
	$_SESSION['Epreuve4'] = $epreuve4;
	$_SESSION['Epreuve3degre'] = $epreuve3degre;
	
	// Vérification des épreuves entrées
	// Toutes les épreuves sont entrées
	if (
		($typeconcours == "CC" and $lof != "" and $epreuve1 == "")
		 or ($typeconcours == "CC" and ($licence < 70000 or $licence >= 90000) and $epreuve2 == "")
		 or ($typeconcours == "ChR" and $licence < 70000 and $epreuve3degre == "")
		 or ($typeconcours == "ChRSGPF" and $epreuve3 == "" and $epreuve4 == "")
		 or ($typeconcours == "ChRSGPF" and $epreuve3 == "ChR" and $licence < 70000 and $epreuve3degre == "")
		 or ($typeconcours == "Comp" and $epreuve1 == "" and $epreuve2 == "" and $epreuve3 == "" and $epreuve4 == "")
		 or ($typeconcours == "Comp" and $epreuve1 != "" and ($licence < 70000 or $licence >= 90000) and $epreuve2 == "")
		 or ($typeconcours == "Comp" and ($epreuve3 != "" and $epreuve3degre == ""))
		){
		//**************************************************
		$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a";
		include('../utilitaires/bandeau_agi.php');
		$_SESSION['Modif'] = "Y";
		echo "<p class='center'><span class='alert'>&nbsp;Une épreuve n'a pas été convenablement renseignée&nbsp;</span></p>
		<table align='center'><tr><th><div class='bouton'><a href='avantagi_concurrents_1.php'>RETOUR</a></div></th></tr></table>";
		exit;
	}
	if ($typeconcours == "CC" or $typeconcours == "Comp"){
		// Cohérence épreuves
		if ($epreuve1 != "" and $epreuve3 != "" and $epreuve1 != $epreuve3degre){
			//**************************************************
			$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a";
			include('../utilitaires/bandeau_agi.php');
			$_SESSION['Modif'] = "Y";
			echo "<p class='center'><span class='alert'>&nbsp;Incohérence entre degrés&nbsp;</span></p>
			<table align='center'><tr><th><div class='bouton'><a href='avantagi_concurrents_1.php'>RETOUR</a></div></th></tr></table>";
			exit;
		}
		// Cohérence degré / épreuves normales ou +
		if ($epreuve1 == 1 and ($epreuve2 == "plus" or $epreuve2 == "")){
			//**************************************************
			$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a>";
			include("../utilitaires/bandeau_agi.php");
			echo "<p class='center'><span class='alert'>&nbsp;Le concurrent est en 1er degré&nbsp;</span><br />Il a été inscrit automatiquement aux épreuves Open et Jumping normales</p>";
			$epreuve2 = "normal";
			$flag_affichage = "Y";
			$_SESSION['AfficheTitre'] = "N";
		}
		if ($epreuve1 == 3 and ($epreuve2 == "normal" or $epreuve2 == "")){
			//**************************************************
			$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a>";
			include("../utilitaires/bandeau_agi.php");
			echo "<p class='center'><span class='alert'>&nbsp;Le concurrent est en 3ème degré&nbsp;</span><br />Il a été inscrit automatiquement aux épreuves Open + et Jumping +</p>";
			$epreuve2 = "plus";
			$flag_affichage = "Y";
			$_SESSION['AfficheTitre'] = "N";
		}
		// Enregistrement concurrent
		if ($epreuve1 != ""){ // 1er, 2ème ou 3ème degré
			$epreuve = $epreuve1;
			include("avantagi_concurrents_3.php");
		}
		if ($epreuve2 == "normal"){ // Epreuves normales
			$epreuve = 4;
			include("avantagi_concurrents_3.php");
			$epreuve = 7;
			include("avantagi_concurrents_3.php");
		} else if ($epreuve2 == "plus"){ // Epreuves plus
			$epreuve = 5;
			include("avantagi_concurrents_3.php");
			$epreuve = 8;
			include("avantagi_concurrents_3.php");
		}
		if ($epreuve1 != "" or $epreuve2 != ""){ // GPF
			$epreuve = 6;
			include("avantagi_concurrents_3.php");
		}
	}
	if ($typeconcours == "ChR"){
		if ($epreuve3degre == 2 or ($licence >= 70000 and $licence < 90000)){ // 2ème degré ou Jeune
			for ($numepreuve = 9; $numepreuve <= 12; $numepreuve ++){
				$epreuve = $numepreuve;
				include("avantagi_concurrents_3.php");
			}
		} else { // 3ème degré
			for ($numepreuve = 13; $numepreuve <= 16; $numepreuve++){
				$epreuve = $numepreuve;
				include("avantagi_concurrents_3.php");
			}
		}
	}
	if ($typeconcours == "SGPF"){ // Sélectif GPF
		for ($numepreuve = 17; $numepreuve <= 19; $numepreuve ++){
			$epreuve = $numepreuve;
			include("avantagi_concurrents_3.php");
		}
	}
	$inscritchr = "N";
	$inscritsgpf = "N";
	if ($typeconcours == "ChRSGPF" or $typeconcours == "Comp"){
		if ($epreuve3 == "ChR"){ // Inscrit au Championnat Régional
			$inscritchr = "Y";
			if ($epreuve3degre == 2 or $licence >= 70000){ // 2ème degré ou Jeune
				for ($numepreuve = 9; $numepreuve <= 12; $numepreuve ++){
					$epreuve = $numepreuve;
					include("avantagi_concurrents_3.php");
				}
			} else { // 3ème degré
				for ($numepreuve = 13; $numepreuve <= 16; $numepreuve++){
					$epreuve = $numepreuve;
					include("avantagi_concurrents_3.php");
				}
			}
		}
		if ($epreuve4 == "SGPF"){ // Inscrit au Sélectif GPF
			$inscritsgpf = "Y";
			for ($numepreuve = 17; $numepreuve <= 19; $numepreuve ++){
				$epreuve = $numepreuve;
				include("avantagi_concurrents_3.php");
			}
		}
	}

	// Enregistrement
	$query = "UPDATE cneac_licences SET AGI1='Y' WHERE Id='$idlicence'";
	mysql_query($query);

	$_SESSION['Concurrents'] = "entres";
	include("../utilitaires/ecrit_variables_agi.php");
	// Mise à jour stats par épreuve
	include("avantagi_epreuvesstats.php");
	mysql_close();

	if ($typeconcours == "ChR" or $inscritchr == "Y"){
		if ($classe == 1){$_SESSION['nbexc'] = 5;} else {$_SESSION['nbexc'] = 3;}
		include("avantagi_concurrents_4.php");
		exit;
	}
	$_SESSION['IdLicence'] = "";
	$_SESSION['Licence'] = "";
	if ($flag_affichage == "Y"){
		echo "<table align='center'><tr><th><div class='bouton'><a href='avantagi_concurrents.php'>RETOUR</a></div></th></tr></table>";
		exit;
	}
	if ($retour != "avantagi_concurrents.php"){
		//**************************************************
		$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrents.php'>Entrée des concurrents</a";
		include('../utilitaires/bandeau_agi.php');
		echo "<p class='center'>L'inscription de ce concurrent à été modifiée</p>
		<table align='center'><tr><th><div class='bouton'><a href='$retour'>RETOUR</a></div></th></tr></table>";
		exit;
	}
	include('avantagi_concurrents.php');
}
?>
</body>
</html>