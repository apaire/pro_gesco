<?php
session_start();
$crlf = chr(13) . chr(10);
// Chargement variables agility
include("../utilitaires/nomvars_agi.php");
$date = $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];

// Initialiser le PDF
include("../utilitaires/imp_init_p.php");

// Traitement date
$mois_liste = array('01'=>'janvier','02'=>'février','03'=>'mars','04'=>'avril','05'=>'mai','06'=>'juin','07'=>'juillet','08'=>'août','09'=>'septembre','10'=>'octobre','11'=>'novembre','12'=>'décembre');

// Retrouve les Brevets dans la base de données
include("../../communs/connexion.php");
include("../../communs/lect_variables_genes.php");
include("../utilitaires/lect_variables_agi.php");

// Liste des brevets
$query = "SELECT * FROM agility_resultats Res 
			LEFT OUTER JOIN cneac_licences Li ON Res.idLicence = Li.Id
			LEFT OUTER JOIN agility_epreuves Ep ON Res.idEpreuve = Ep.id
			LEFT OUTER JOIN cneac_races Ra USING (codeRace)
			LEFT OUTER JOIN cneac_clubs Club USING(codeClub)
			LEFT OUTER JOIN cneac_regionales Reg USING (codeRegionale)
			WHERE Res.Epreuve = '1' AND Brevet='3'
			";

$result = mysql_query($query);

// Informer si aucun brevet
if (mysql_num_rows($result) == '0')
{
	$pdf->addpage();
	$pdf->setfont("Arial", "B", 12);
	$pdf->cell(100, 8,"Aucun concurrent n'a obtenu sa 3 ème partie de brevet.", 0, 1, "C");
}


while ($row = mysql_fetch_assoc($result))
{
	$licence = $row['Licence'];
	$nomcategorie = $nomcategories[$row['Categorie']];
	$conducteur = $row['Prenom']." ".$row['Nom'];

	
	// 2 impressions par feuille :
	if (!isset($y) || $y !=0)
	{
		$y = 0;
		$pdf->addpage();
	}else{
		$y = 145;	//décaler de 145 mm verticalement
	}

	// cadre haut
	$pdf->setfont("Arial", "B", 12);
	$pdf->setxy(10, $y+10);
	$pdf->cell(190, 100," ", 1, 1, "L");	// cadre haut
	// entete
	$pdf->image("../../images/SCC.jpg", 15, $y+15, 20);
	$pdf->image("../../images/FCI.jpg", 180, $y+20, 15);
	$pdf->setxy(55,$y+25);
	$pdf->cell(99, 8,"BREVET D'AGILITY INTERNATIONAL - ".date("Y"), 1, 1, "C");
	// texte
	$pdf->setxy(20,$y+50);
	$pdf->setfont("Arial", "", 8);
	$pdf->cell(25, 8, "Le chien : ", 0, 0);
	$pdf->cell(80, 8, utf8_decode($row['NomChien']), 0, 0);
	$pdf->cell(20, 8, "Catégorie : ", 0, 0);
	$pdf->cell(80, 8, $nomcategorie , 0, 2);
	$pdf->setx(20);
	$pdf->cell(25,8,"Race : ",0,0,"L");
	$pdf->cell(80,8,utf8_decode($row['Race']),0,0,"L");
	$pdf->cell(20,8,"Sexe : ",0,0,"L");
	$pdf->cell(80,8,$row['Sexe'],0,2,"L");
	$pdf->setx(20);
	$pdf->cell(25,8,"Identification : ",0,0,"L");
	$pdf->cell(80,8,$row['Tatouage'].$row['Puce'],0,0,"L");
	$pdf->cell(20,8,"LOF : ",0,0,"L");
	$pdf->cell(80,8,$row['LOF'],0,2,"L");
	$pdf->setx(20);
	$pdf->cell(25,8,"Licence CNEAC : ",0,0,"L");
	$pdf->cell(80,8,$licence,0,2,"L");
	$pdf->setx(20);
	$pdf->cell(25,8,"Conduit par : ",0,0,"L");
	$pdf->cell(80,8,utf8_decode($conducteur),0,0,"L");
	$pdf->cell(20,8,"Club : ",0,0,"L");
	$pdf->cell(80,8,$row['Club'],0,2,"L");
	// cadre bas
	$pdf->setxy(10,$y+110);
	$pdf->cell(190, 30," ", 1, 1, "L");	// cadre bas
	$pdf->setxy(20,$y+115);
	$pdf->setfont("Arial", "", 8);
	$date= $_SESSION['Jour']."/".$_SESSION['Mois']."/".$_SESSION['Annee'];
	$pdf->cell(100, 8,"Brevet délivré le : ".$date." au ".$_SESSION['NomComplet'], 0, 0, "L");
	$pdf->setx(150);
	$pdf->cell(100, 8,"signature du juge : ", 0, 2, "L");
	$pdf->setx(20);
	$pdf->cell(100, 8,"Par : ".utf8_decode($row['Juge']), 0, 2, "L");

} // FIN While

$pdf->output();
?>