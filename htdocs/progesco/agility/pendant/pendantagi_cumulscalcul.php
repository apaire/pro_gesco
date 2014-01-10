<?php
$query = "SELECT * FROM agility_reglescumuls WHERE Id='$idcumul'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$nomcumul = $row['NomCumul'];
$numepreuve = $row['Epreuve'];
$epreuves = $row['Epreuves'];

// Effacement données précédentes
$query = "DELETE FROM agility_resultatscumuls WHERE Idcumul='$idcumul'";
mysql_query($query);

// N° dossard maxi
$query = "SELECT Dossard FROM agility_resultats ORDER BY Dossard DESC LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$dossardmax = $row['Dossard'];

// Chargement des épreuves
$n = 0;
for ($epreuve = 1; $epreuve <= 19; $epreuve++){
	if ($epreuves{$epreuve} == "Y"){
		for ($dossard = 1; $dossard <= $dossardmax; $dossard++){
			$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' AND Dossard='$dossard' AND Resultat<>'' AND Resultat<>'F'";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$query = "SELECT * FROM agility_resultatscumuls WHERE IdCumul='$idcumul' AND Dossard='$dossard'";
			$resultcumul = mysql_query($query);
			$rowcumul = mysql_fetch_assoc($resultcumul);
			if (mysql_num_rows($result) == 0){ // Le concurrent n'a pas participé à cette épreuve
				if (mysql_num_rows($resultcumul) > 0){ // Concurrent déjà enregistré sur ce cumul
					$id = $rowcumul['Id'];
					$query = "UPDATE agility_resultatscumuls SET Resultat='E' WHERE Id='$id'";
				} else {
					$query = "INSERT INTO agility_resultatscumuls SET IdCumul='$idcumul', Dossard='$dossard', Resultat='E'";
				}
				mysql_query($query);
			} else { // L'épreuve est validée pour ce concurrent
				$resultat = $row['Resultat'];
				$idlicence = $row['IdLicence'];
				$licence = $row['Licence'];
				$dossard = $row['Dossard'];
				$categorie = $row['Categorie'];
				$classe = $row['Classe'];
				$handi = $row['Handi'];
				$temps = $row['Temps'];
				$fautes = $row['Fautes'];
				$refus = $row['Refus'];
				$penalites = $row['Penalites'];
				$depastemps = $row['Depastemps'];
				$total = $row['Total'];
				if (mysql_num_rows($resultcumul) > 0){ // Résultats déjà enregistrés
					$id = $rowcumul['Id'];
					$resultatcumul = $rowcumul['Resultat'];
					if ($resultatcumul != "E"){ // Non élimine du cumul
						$temps = $rowcumul['Temps'] + $temps;
						$fautes = $rowcumul['Fautes'] + $fautes;
						$refus = $rowcumul['Refus'] + $refus;
						$penalites = $rowcumul['Penalites'] + $penalites;
						$depastemps = $rowcumul['Depastemps'] + $depastemps;
						$total = $rowcumul['Total'] + $total;
						$query = "UPDATE agility_resultatscumuls SET Temps='$temps', Fautes='$fautes', Refus='$refus', Penalites='$penalites', Depastemps='$depastemps', Total='$total' WHERE Id='$id'";
					}
				} else {
					$query = "INSERT INTO agility_resultatscumuls SET IdCumul='$idcumul', Licence='$licence', IdLicence='$idlicence', Dossard='$dossard', Categorie='$categorie', Classe='$classe', Handi='$handi', Temps='$temps', Fautes='$fautes', Refus='$refus', Penalites='$penalites', Depastemps='$depastemps', Total='$total'";
				}
				mysql_query($query);
			}
		}
	}
}
// Calcul qualificatif
$query = "SELECT * FROM agility_resultatscumuls WHERE IdCumul='$idcumul' AND Resultat<>'E'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$id = $row['Id'];
	$total = $row['Total'];
	if ($total < 6){$resultat = "X";}
	else if ($total < 16){$resultat = "T";}
	else if ($total < 26){$resultat = "B";}
	else {$resultat = "N";}
	$query = "UPDATE agility_resultatscumuls SET Resultat='$resultat' WHERE Id='$id'";
	mysql_query($query);
}
// Classement
for ($handi = 0; $handi <= 5; $handi++){
	for ($classe = 1; $classe <= 3; $classe++){
		if ($epreuves[49] != "Y"){ // Toutes catégories confondues
			for ($categorie = 1; $categorie <= 4; $categorie++){
				$query = "SELECT * FROM agility_resultatscumuls WHERE Idcumul='$idcumul' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Total, Penalites, Temps";
				$result = mysql_query($query);
				$total_preced = "";
				$penalites_preced = "";
				$temps_preced = "";
				$rang = 1;
				while ($row = mysql_fetch_assoc($result)){
					$id = $row['Id'];
					$total = $row['Total'];
					$penalites = $row['Penalites'];
					$temps = $row['Temps'];
					$resultat = $row['Resultat'];
					if ($total != $total_preced or $penalites != $penalites_preced or $temps != $temps_preced){$classement = $rang;} // Nom exequo
					$total_preced = $total;
					$penalites_preced = $penalites;
					$temps_preced = $temps;
					$rang++;
					$query = "UPDATE agility_resultatscumuls SET Classement='$classement' WHERE Id='$id'";
					mysql_query($query);
				}
			}
		} else {
			$query = "SELECT * FROM agility_resultatscumuls WHERE Idcumul='$idcumul' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Total, Penalites, Temps";
			$result = mysql_query($query);
			$total_preced = "";
			$penalites_preced = "";
			$temps_preced = "";
			$rang = 1;
			while ($row = mysql_fetch_assoc($result)){
				$id = $row['Id'];
				$total = $row['Total'];
				$penalites = $row['Penalites'];
				$temps = $row['Temps'];
				$resultat = $row['Resultat'];
				if ($total != $total_preced or $penalites != $penalites_preced or $temps != $temps_preced){$classement = $rang;} // Nom exequo
				$total_preced = $total;
				$penalites_preced = $penalites;
				$temps_preced = $temps;
				$rang++;
				$query = "UPDATE agility_resultatscumuls SET Classement='$classement' WHERE Id='$id'";
				mysql_query($query);
			}
		}
	}
}
?>