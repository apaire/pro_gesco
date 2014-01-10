<?php
session_start();
$titre = "<a href='pendantagi.php'>Pendant le concours</a> &gt; <a href='pendantagi_cumulsaff.php'>Affichage résultats des cumuls</a>";
include("../utilitaires/bandeau_agi.php");
include("../../communs/connexion.php");
include("../utilitaires/nomvars_agi.php");
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
<center>
<a id="debut"></a>
<?php
// Chargement Cumul
$idcumul = $_GET['idcumul'];
// Etablissement des résultats de ce cumul
include("pendantagi_cumulscalcul.php");
// Affichage
?>
<h3 id="debut" class='center'><?php echo $nomcumul; ?></h3>
<?php
$query = "SELECT Id FROM agility_resultatscumuls WHERE IdCumul='$idcumul' AND Resultat<>'E'";
if (mysql_num_rows(mysql_query($query)) == 0){ // Aucun concurrent
	?>
	<p class="center">Aucun concurrent n'a fait toutes les épreuves du cumul</p>
	<table align="center"><tr><th><div class="bouton"><a href="pendantagi_cumulsaff.php">RETOUR</a></div></th></tr></table>
	<?php
	exit;
}
?>

<table align="center">

<?php
// Liste des concurrents
$fond = "clair";
for ($handi = 0; $handi <= 5; $handi++){
	for ($classe = 1; $classe <= 3; $classe++){
		if ($epreuves{49} == "N"){ // Catégories séparées
			for ($categorie = 1; $categorie <= 4; $categorie++){
				$query = "SELECT * FROM agility_resultatscumuls WHERE Idcumul='$idcumul' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Classement";
				$result = mysql_query($query);
				$nb_concurrents = mysql_num_rows($result);
				if ($nb_concurrents == 0){continue;}
				// Affichage titre catégorie
				?>
				<tr><th colspan='11'>Categorie <?php echo $nomcategories[$categorie]; ?> - Classe <?php echo $nomclasses[$classe]; ?></th></tr>
				<tr>
					<th rowspan="2">Clas.</th>
					<th rowspan="2">Dossard</th>
					<th colspan="2">Chien</th>
					<th rowspan="2">Conducteur</th>
					<th rowspan="2">Club</th>
					<th colspan="3">Penalites</th>
					<th rowspan="2">Temps</th>
					<th rowspan="2">Qualif.</th>
				</tr>
				<tr>
					<th>Nom</th>
					<th>Race</th>
					<th>Parc.</th>
					<th>&gt; TPS</th>
					<th>Total</th>
				</tr>
				<?php
				$classement_preced = "";
				for ($n = 1; $n <= $nb_concurrents; $n++){
					$row = mysql_fetch_assoc($result);
					$licence = $row['Licence'];
					$idlicence = $row['IdLicence'];
					$dossard = $row['Dossard'];
					$temps = $row['Temps'];
					$fautes = $row['Fautes'];
					$refus = $row['Refus'];
					$penalitesant = $row['PenalitesAnt'];
					$penalites = $row['Penalites'];
					$depastemps = $row['Depastemps'];
					$total = $row['Total'];
					$classement = $row['Classement'];
					$resultat = $row['Resultat'];
					if ($classement == $classement_preced){$classement = "";} else {$classement_preced = $classement;}
					$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$nomchien = $row1['NomChien'];
					$coderace = $row1['CodeRace'];
					$nom = $row1['Nom']." ".$row1['Prenom'];
					$codeclub = $row1['CodeClub'];
					$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$race = $row1['Race'];
					$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$club = $row1['Club'];
					$coderegionale = $row1['CodeRegionale'];
					$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($result1);
					$club .= " / ".$row1['Regionale'];
					echo "<tr align='center' class='$fond'><td>$classement</td><td>$dossard</td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club</td><td>$penalites</td><td>$depastemps</td><td>$total</td><td>$temps</td><td>$nomresultats[$resultat]</td></tr>";
					if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
				}
				echo "<tr align='right'><td colspan='12'><a href='#debut'>Haut de page</a></td></tr>";
			}
		} else { // Toutes catégories confondues
			$query = "SELECT * FROM agility_resultatscumuls WHERE Idcumul='$idcumul' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Classement";
			$result = mysql_query($query);
			$nb_concurrents = mysql_num_rows($result);
			if ($nb_concurrents == 0){continue;}
			// Affichage titre catégorie
			?>
			<tr><th colspan='11'>Classe <?php echo $nomclasses[$classe]; ?></th></tr>
			<tr>
				<th rowspan="2">Clas.</th>
				<th rowspan="2">Dossard</th>
				<th colspan="2">Chien</th>
				<th rowspan="2">Conducteur</th>
				<th rowspan="2">Club</th>
				<th colspan="3">Penalites</th>
				<th rowspan="2">Temps</th>
				<th rowspan="2">Qualif.</th>
			</tr>
			<tr>
				<th>Nom</th>
				<th>Race</th>
				<th>Parc.</th>
				<th>&gt; TPS</th>
				<th>Total</th>
			</tr>
			<?php
			$classement_preced = "";
			for ($n = 1; $n <= $nb_concurrents; $n++){
				$row = mysql_fetch_assoc($result);
				$licence = $row['Licence'];
				$idlicence = $row['IdLicence'];
				$dossard = $row['Dossard'];
				$temps = $row['Temps'];
				$fautes = $row['Fautes'];
				$refus = $row['Refus'];
				$penalitesant = $row['PenalitesAnt'];
				$penalites = $row['Penalites'];
				$depastemps = $row['Depastemps'];
				$total = $row['Total'];
				$classement = $row['Classement'];
				$resultat = $row['Resultat'];
				if ($classement == $classement_preced){$classement = "";} else {$classement_preced = $classement;}
				$query = "SELECT * FROM cneac_licences WHERE Id='$idlicence'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$nomchien = $row1['NomChien'];
				$coderace = $row1['CodeRace'];
				$nom = $row1['Nom']." ".$row1['Prenom'];
				$codeclub = $row1['CodeClub'];
				$query = "SELECT * FROM cneac_races WHERE CodeRace='$coderace'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$race = $row1['Race'];
				$query = "SELECT * FROM cneac_clubs WHERE CodeClub='$codeclub'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$club = $row1['Club'];
				$coderegionale = $row1['CodeRegionale'];
				$query = "SELECT * FROM cneac_regionales WHERE CodeRegionale='$coderegionale'";
				$result1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($result1);
				$club .= " / ".$row1['Regionale'];
				echo "<tr align='center' class='$fond'><td>$classement</td><td>$dossard</td><td>$nomchien</td><td>$race</td><td>$nom</td><td>$club/td><td>$penalites</td><td>$depastemps</td><td>$total</td><td>$temps</td><td>$nomresultats[$resultat]</td></tr>";
				if ($fond == "clair"){$fond = "fonce";} else {$fond = "clair";}
			}
			echo "<tr align='right'><td colspan='12'><a href='#debut'>Haut de page</a></td></tr>";
		}
	}
	echo "</table>";
}
mysql_close();
?>
<table align="center"><tr><th><div class="bouton"><a href="pendantagi_cumulsaff.php">RETOUR</a></div></th></tr></table>
</body>
</html>