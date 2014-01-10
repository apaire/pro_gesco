<?php
// Définitions des tableaux de noms de variables
$nommoiss = array("01"=>"janvier", "02"=>"février", "03"=>"mars", "04"=>"avril", "05"=>"mai", "06"=>"juin", "07"=>"juillet", "08"=>"août", "09"=>"septembre", "10"=>"octobre", "11"=>"novembre", "12"=>"décembre");

$nomtypeconcourss = array("CC"=>"Concours Classique", "ChR"=>"Championnat Régional", "SGPF"=>"Sélectif Grand Prix de France", "ChRSGPF"=>"Championnat Régional et Sélectif GPF", "Comp"=>"Concours Complet, Toutes Epreuves", "ChF"=>"Championnat de France", "GPF"=>"Grand Prix de France");

$nomepreuves = array("1"=>"1er degré", "2"=>"2ème degré", "3"=>"3ème degré", "4"=>"Open", "5"=>"Open +", "6"=>"Grand Prix de France", "7"=>"Jumping", "8"=>"Jumping +", "9"=>"Championnat / Coupe - Agility 2ème degré", "10"=>"Championnat / Coupe - Agility 3ème degré", "11"=>"Championnat / Coupe - Jumping 2ème degré", "12"=>"Championnat / Coupe - Jumping 3ème degré", "13"=>"Sélectif GPF - Agility", "14"=>"Sélectif GPF - Jumping", "15"=>"Championnat / Coupe de France 2ème degré - Manche 1", "16"=>"Championnat / Coupe de France 2ème degré - Manche 2", "17"=>"Championnat / Coupe de France 2ème degré - Manche 3", "18"=>"Championnat / Coupe de France 3ème degré - Manche 1", "19"=>"Championnat / Coupe de France 3ème degré - Manche 2", "20"=>"Championnat / Coupe de France 3ème degré - Manche 3", "21"=>"Grand Prix de France - Manche 1", "22"=>"Grand Prix de France - Manche 2", "23"=>"Grand Prix de France - Manche 3", "24"=>"Grand Prix de France - Manche 4", "51"=>"Championnat de France - 2ème degré", "52"=>"Championnat de France - 3ème degré", "53"=>"Coupe de France - 2ème degré", "54"=>"Coupe de France - 3ème degré");

$nomepreuveabrs = array("1"=>"1er degré", "2"=>"2ème degré", "3"=>"3ème degré", "4"=>"Open", "5"=>"Open +", "6"=>"GPF", "7"=>"Jumping", "8"=>"Jumping +", "9"=>"Champ. Rég. 2ème degré", "10"=>"Champ. Rég. 3ème degré", "11"=>"Champ. Rég. 2ème degré", "12"=>"Champ. Rég. 3ème degré", "13"=>"Sélectif GPF", "14"=>"Sélectif GPF", "15"=>"2ème degré - Manche 1", "16"=>"2ème degré - Manche 2", "17"=>"2ème degré - Manche 3", "18"=>"3ème degré - Manche 1", "19"=>"3ème degré - Manche 2", "20"=>"3ème degré - Manche 3", "21"=>"Manche 1", "22"=>"Manche 2", "23"=>"Manche 3", "24"=>"Manche 4", "51"=>"2ème degré", "52"=>"3ème degré", "53"=>"2ème degré", "54"=>"3ème degré");

$nomepreuveabr1s = array("1"=>"1er degré", "2"=>"2ème degré", "3"=>"3ème degré", "4"=>"Open", "5"=>"Open +", "6"=>"GPF", "7"=>"Jumping", "8"=>"Jumping +", "9"=>"Ch.R. Agility 2ème deg.", "10"=>"Ch.R. Agility 3ème deg.", "11"=>"Ch.R. Jumping 2ème deg.", "12"=>"Ch.R. Jumping 3ème deg.", "13"=>"Sélectif GPF Agility", "14"=>"Sélectif GPF Jumping", "15"=>"2ème degré - Manche 1", "16"=>"2ème degré - Manche 2", "17"=>"2ème degré - Manche 3", "18"=>"3ème degré - Manche 1", "19"=>"3ème degré - Manche 2", "20"=>"3ème degré - Manche 2", "21"=>"Manche 1", "22"=>"Manche 2", "23"=>"Manche 3", "24"=>"Manche 4");

$nomepreuvewwws = array("15"=>"2eme_degre_Manche 1", "16"=>"2eme_degre_Manche 2", "17"=>"2eme_degre_Manche 3", "18"=>"3eme_degre_Manche 1", "19"=>"3eme_degre_Manche 2", "20"=>"3eme_degre_Manche 2", "21"=>"Manche_1", "22"=>"Manche_2", "23"=>"Manche_3", "24"=>"Manche_4", "51"=>"ChF_2eme_degre", "52"=>"ChF_3eme_degre", "53"=>"Coupe_2eme_degre", "54"=>"Coupe_3eme_degre", "55"=>"GPF");

$nomcategories = array("1"=>"A", "2"=>"B", "3"=>"C", "4"=>"D");

$nomclasses = array("1"=>"Senior", "2"=>"Junior", "3"=>"Poussin");

$nomhandis = array("0"=>"", "1"=>"Classe 1", "2"=>"Classe 2", "3"=>"Classe 3", "4"=>"Classe 4", "5"=>"Classe 5");

$nomresultats = array(""=>" ", "A"=>"Abandon", "F"=>"Forfait", "E"=>"Eliminé", "N"=>" ", "X"=>"Excellent", "T"=>"Très Bon", "B"=>"Bon", "P"=>" ");
$nomresultatcodes = array("1"=>"EXC", "2"=>"TBON", "3"=>"BON", "4"=>"NCL", "5"=>"ELI", "6"=>"ABAN", "0"=>"FOR");
$nomresultatabrs = array("A"=>"ABAN", "F"=>"FOR", "E"=>"ELI", "N"=>"NCL", "X"=>"EXC", "T"=>"TBON", "B"=>"BON", "P"=>" ");
//$nomresultatabrs = array("A"=>"ABD", "F"=>" ", "E"=>"ELI", "N"=>"NCL", "X"=>"EX", "T"=>"TB", "B"=>"B", "P"=>" ");
$coderesultats = array("X"=>"1", "T"=>"2", "B"=>"3", "N"=>"4", "E"=>"5", "A"=>"6", "F"=>"0", " "=>"0");

$nombrevets = array(""=>"", "1"=>"1ère", "2"=>"2ème", "3"=>"3ème");

$nombrelettres = array("1"=>"Un", "2"=>"Deux", "3"=>"Trois", "4"=>"Quatre", "5"=>"Cinq", "6"=>"Six", "7"=>"Sept", "8"=>"Huit", "9"=>"Neuf", "10"=>"Dix", "11"=>"Onze", "12"=>"Douze", "13"=>"Treize", "14"=>"Quatorze");
$crlfn = "\n";
$crlf = chr(13).chr(10);

if ($_SESSION['TypeConcours'] == "CC"){
	$epreuvedeb = 1;
	$epreuvefin = 8;
}
if ($_SESSION['TypeConcours'] == "ChR"){
	$epreuvedeb = 9;
	$epreuvefin = 12;
}
if ($_SESSION['TypeConcours'] == "SGPF"){
	$epreuvedeb = 13;
	$epreuvefin = 14;
}
if ($_SESSION['TypeConcours'] == "ChRSGPF"){
	$epreuvedeb = 9;
	$epreuvefin = 14;
}
if ($_SESSION['TypeConcours'] == "Comp"){
	$epreuvedeb = 1;
	$epreuvefin = 14;
}
if ($_SESSION['TypeConcours'] == "ChF"){
	$epreuvedeb = 15;
	$epreuvefin = 20;
}
if ($_SESSION['TypeConcours'] == "GPF"){
	$epreuvedeb = 21;
	$epreuvefin = 24;
}
?>