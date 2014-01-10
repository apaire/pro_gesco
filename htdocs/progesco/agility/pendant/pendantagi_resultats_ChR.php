<?php
$temps = 0;
$fautes = 0;
$refus = 0;
$penalites = 0;
$depastemps = 0;
$total = 0;

// N° dossard maxi
$query = "SELECT Dossard FROM agility_resultats ORDER BY Dossard DESC LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$dossardmax = $row['Dossard'];

// Chargement des épreuves
$n = 0;
for ($dossard = 1; $dossard <= $dossardmax; $dossard++){
	$temps = 0;
	$fautes = 0;
	$refus = 0;
	$penalites = 0;
	$depastemps = 0;
	$total = 0;
	$penalitesant = 0;
	$resultat = "";
	for ($epreuve = 9; $epreuve <= 18; $epreuve++){
		if ($epreuves{$epreuve} == "Y"){
			$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' AND Dossard='$dossard' AND (Resultat<>'' AND Resultat<>'F')";
			$result = mysql_query($query);
			if (mysql_num_rows($result) == 0){
				$resultat = "F";
				break;
			}
			$row = mysql_fetch_assoc($result);
			$temps = $temps + $row['Temps'];
			$fautes = $fautes + $row['Fautes'];
			$refus = $refus + $row['Refus'];
			$penalites = $penalites + $row['Penalites'];
			$depastemps = $depastemps + $row['Depastemps'];
			$total = $total + $row['Total'];
			$penalitesant = $row['PenalitesAnt'];
		}
	}
	if ($resultat == "F"){
		$query = "UPDATE agility_resultats SET Resultat='F' WHERE Epreuve='$epreuvecalculee' AND Dossard='$dossard'";
	} else {
		if ($epreuvecalculee == 11 or $epreuvecalculee == 15){$total = $total + $penalitesant;} // Championnat
		$query = "UPDATE agility_resultats SET Temps='$temps', Fautes='$fautes', Refus='$refus', Penalites='$penalites', PenalitesAnt='$penalitesant', Depastemps='$depastemps', Total='$total', Resultat='' WHERE Epreuve='$epreuvecalculee' AND Dossard='$dossard'";
	}
	mysql_query($query);
}
// Calcul qualificatif
$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuvecalculee' AND Resultat<>'F'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$id = $row['Id'];
	$total = $row['Total'];
	if ($total < 6){$resultat = "X";}
	else if ($total < 16){$resultat = "T";}
	else if ($total < 26){$resultat = "B";}
	else {$resultat = "N";}
	$query = "UPDATE agility_resultats SET Resultat='$resultat' WHERE Id='$id'";
	mysql_query($query);
}
// Classement
for ($handi = 0; $handi <= 5; $handi++){
	for ($classe = 1; $classe <= 3; $classe++){
		if ($epreuves[49] != "Y"){ // Toutes catégories confondues
			for ($categorie = 1; $categorie <= 4; $categorie++){
				$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuvecalculee' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'E' ORDER BY Total, Penalites, Temps";
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
					$query = "UPDATE agility_resultats SET Classement='$classement' WHERE Id='$id'";
					mysql_query($query);
				}
			}
		} else {
			$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuvecalculee' AND Classe='$classe' AND Handi='$handi' AND Resultat<>'F' ORDER BY Total, Penalites, Temps";
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
				$query = "UPDATE agility_resultats SET Classement='$classement' WHERE Id='$id'";
				mysql_query($query);
			}
		}
	}
}
?>