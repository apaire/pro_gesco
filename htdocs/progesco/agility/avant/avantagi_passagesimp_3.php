<?php
session_start();
include("../utilitaires/nomvars_agi.php");
include("../../communs/imp_init_p.php");
$_SESSION['Ordre'] = $_GET['ordre'];
// connexion bdd
include("../../communs/connexion.php");
// Variables
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
// En-tête
$titre = "N° DE DOSSARD CLASSES PAR ORDRE DE PASSAGE";
include("../utilitaires/imp_titre_p.php");
$posy = 40;
for ($epreuve = $epreuvedeb; $epreuve <= $epreuvefin; $epreuve++){
	if ($epreuve != 11 and $epreuve != 12 and $epreuve != 15 and $epreuve != 16 and $epreuve != 19){
		for ($handi = 0; $handi <= 5; $handi++){
			for ($categorie = 1; $categorie <= 4; $categorie++){
				for ($classe = 1; $classe <= 3; $classe++){
					$query = "SELECT * FROM agility_resultats WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi' ORDER BY OrdrePassage";
					$result = mysql_query($query);
					$nb_concurrents = mysql_num_rows($result);
					if ($nb_concurrents > 0){
						include("avantagi_passagesimp_31.php");
					}
				}
			}
		}
	}
}
$pdf->output();
?>