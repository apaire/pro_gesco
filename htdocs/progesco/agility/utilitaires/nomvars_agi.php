<?php
// Définitions des tableaux de noms de variables
$nommoiss = array("01"=>"janvier", "02"=>"février", "03"=>"mars", "04"=>"avril", "05"=>"mai", "06"=>"juin", "07"=>"juillet", "08"=>"août", "09"=>"septembre", "10"=>"octobre", "11"=>"novembre", "12"=>"décembre");

$nomtypeconcourss = array("CC"=>"Concours Classique", "ChR"=>"Championnat Régional", "SGPF"=>"Sélectif Grand Prix de France", "ChRSGPF"=>"Championnat Régional et Sélectif GPF", "Comp"=>"Concours Complet, Toutes Epreuves", "ChF"=>"Championnat de France", "GPF"=>"Grand Prix de France");

$nomepreuves = array(
	"1"=>"1er degré",
	"2"=>"2ème degré",
	"3"=>"3ème degré",
	"4"=>"Open",
	"5"=>"Open +",
	"6"=>"Grand Prix de France",
	"7"=>"Jumping",
	"8"=>"Jumping +",
	"9"=>"Championnat Régional 2ème degré - Manche 1",
	"10"=>"Championnat Régional 2ème degré - Manche 2",
	"11"=>"Championnat Régional 2ème degré",
	"12"=>"Coupe Régionale 2ème degré",
	"13"=>"Championnat Régional 3ème degré - Manche 1",
	"14"=>"Championnat Régional 3ème degré - Manche 2",
	"15"=>"Championnat Régional 3ème degré",
	"16"=>"Coupe Régionale 3ème degré",
	"17"=>"Sélectif GPF - Manche 1",
	"18"=>"Sélectif GPF - Manche 2",
	"19"=>"Sélectif GPF",
	"100"=>"Championnat de France 2ème degré - Manche 1",
	"101"=>"Championnat de France 2ème degré - Manche 2",
	"102"=>"Championnat de France 2ème degré - Manche 3",
	"103"=>"Championnat de France 2ème degré",
	"104"=>"Coupe de France 2ème degré",
	"105"=>"Championnat de France 3ème degré - Manche 1",
	"106"=>"Championnat de France 3ème degré - Manche 2",
	"107"=>"Championnat de France 3ème degré - Manche 3",
	"108"=>"Championnat de France 3ème degré",
	"109"=>"Coupe de France 3ème degré",
	"110"=>"Grand Prix de France - Manche 1",
	"111"=>"Grand Prix de France - Manche 2",
	"112"=>"Grand Prix de France - Manche 3",
	"113"=>"Grand Prix de France - Manche 4",
	"114"=>"Grand Prix de France",
);

$nomepreuveabrs = array(
	"1"=>"1er degré",
	"2"=>"2ème degré",
	"3"=>"3ème degré",
	"4"=>"Open",
	"5"=>"Open +",
	"6"=>"GPF",
	"7"=>"Jumping",
	"8"=>"Jumping +",
	"9"=>"Champ-Coupe. Rég. 2ème degré M1",
	"10"=>"Champ-Coupe. Rég. 2ème degré M2",
	"11"=>"Champ. Rég. 2ème degré",
	"12"=>"Coupe Rég. 2ème degré",
	"13"=>"Champ-Coupe. Rég. 3ème degré M1",
	"14"=>"Champ-Coupe. Rég. 3ème degréM2",
	"15"=>"Champ. Rég. 3ème degré",
	"16"=>"Coupe Rég. 3ème degré",
	"17"=>"Sélectif GPF M1",
	"18"=>"Sélectif GPF M2",
	"19"=>"Sélectif GPF",
	"100"=>"Champ. de France 2ème degré M1",
	"101"=>"Champ. de France 2ème degré M2",
	"102"=>"Champ. de France 2ème degré M3",
	"103"=>"Champ. de France 2ème degré",
	"104"=>"Coupe de France 2ème degré",
	"105"=>"Champ. de France 3ème degré M1",
	"106"=>"Champ. de France 3ème degré M2",
	"107"=>"Champ. de France 3ème degré M3",
	"108"=>"Champ. de France 3ème degré",
	"109"=>"Coupe de France 3ème degré",
	"110"=>"GPF M1",
	"111"=>"GPF M2",
	"112"=>"GPF M3",
	"113"=>"GPF M4",
	"114"=>"GPF",
);

$nomepreuveabr1s = array(
	"1"=>"1er degré",
	"2"=>"2ème degré",
	"3"=>"3ème degré",
	"4"=>"Open",
	"5"=>"Open +",
	"6"=>"GPF",
	"7"=>"Jumping",
	"8"=>"Jumping +",
	"9"=>"2ème degré Manche 1",
	"10"=>"2ème degré Manche 2",
	"11"=>"Ch.R. 2ème deg.",
	"12"=>"Coupe R. 2ème deg.",
	"13"=>"3ème degré Manche 1",
	"14"=>"3ème degré Manche 2",
	"15"=>"Ch.R. 3ème deg.",
	"16"=>"Coupe R. 3ème deg.",
	"17"=>"Sél. GPF Manche 1",
	"18"=>"Sél. GPF Manche 2",
	"19"=>"Sél. GPF",
	"100"=>"Champ. de France 2ème deg. M1",
	"101"=>"Champ. de France 2ème deg. M2",
	"102"=>"Champ. de France 2ème deg. M3",
	"103"=>"Champ. de France 2ème deg.",
	"104"=>"Coupe de France 2ème deg.",
	"105"=>"Champ. de France 3ème deg. M1",
	"106"=>"Champ. de France 3ème deg. M2",
	"107"=>"Champ. de France 3ème deg. M3",
	"108"=>"Champ. de France 3ème deg.",
	"109"=>"Coupe de France 3ème deg.",
	"110"=>"GPF M1",
	"111"=>"GPF M2",
	"112"=>"GPF M3",
	"113"=>"GPF M4",
	"114"=>"GPF",
);

$nomepreuvewwws = array("15"=>"2eme_degre_Manche 1", "16"=>"2eme_degre_Manche 2", "17"=>"2eme_degre_Manche 3", "18"=>"3eme_degre_Manche 1", "19"=>"3eme_degre_Manche 2", "20"=>"3eme_degre_Manche 2", "21"=>"Manche_1", "22"=>"Manche_2", "23"=>"Manche_3", "24"=>"Manche_4", "51"=>"ChF_2eme_degre", "52"=>"ChF_3eme_degre", "53"=>"Coupe_2eme_degre", "54"=>"Coupe_3eme_degre", "55"=>"GPF");

$nomcategories = array("1"=>"A", "2"=>"B", "3"=>"C", "4"=>"D");

$nomclasses = array("1"=>"Senior", "2"=>"Junior", "3"=>"Poussin");
$nomclasseabrs = array("1"=>"S", "2"=>"J", "3"=>"P");

$nomhandis = array("0"=>"", "1"=>"Classe 1", "2"=>"Classe 2", "3"=>"Classe 3", "4"=>"Classe 4", "5"=>"Classe 5");

$nomresultats = array(""=>" ", "A"=>"Abandon", "F"=>"Forfait", "E"=>"Eliminé", "N"=>"Non Classé", "X"=>"Excellent", "T"=>"Très Bon", "B"=>"Bon", "P"=>" ");
$nomresultatcodes = array("1"=>"EXC", "2"=>"TBON", "3"=>"BON", "4"=>"NCL", "5"=>"ELI", "6"=>"ABAN", "0"=>"FOR");
$nomresultatabrs = array("A"=>"ABAN", "F"=>"FOR", "E"=>"ELI", "N"=>"NCL", "X"=>"EXC", "T"=>"TBON", "B"=>"BON", "P"=>" ");
$nomresultatabrcentras = array("A"=>"ABD", "F"=>" ", "E"=>"ELI", "N"=>"NCL", "X"=>"EX", "T"=>"TB", "B"=>"B", "P"=>" ");
$coderesultats = array("X"=>"1", "T"=>"2", "B"=>"3", "N"=>"4", "E"=>"5", "A"=>"6", "F"=>"0", " "=>"0");

$nombrevets = array(""=>"", "1"=>"1ère", "2"=>"2ème", "3"=>"3ème");

$nombrelettres = array("1"=>"Un", "2"=>"Deux", "3"=>"Trois", "4"=>"Quatre", "5"=>"Cinq", "6"=>"Six", "7"=>"Sept", "8"=>"Huit", "9"=>"Neuf", "10"=>"Dix", "11"=>"Onze", "12"=>"Douze", "13"=>"Treize", "14"=>"Quatorze");
$crlfn = "\n";
$crlf = chr(13).chr(10);

$nbepreuvess = array("CC"=>"2", "ChR"=>"1", "ChF"=>"1", "SGPF"=>"0", "GPF"=>"0", "ChRSGPF"=>"2", "Comp"=>"3"); 

$typeconcours = $_SESSION['TypeConcours'];
if ($typeconcours == "CC"){
	$epreuvedeb = 1;
	$epreuvefin = 8;
}
if ($typeconcours == "ChR"){
	$epreuvedeb = 9;
	$epreuvefin = 16;
}
if ($typeconcours == "SGPF"){
	$epreuvedeb = 17;
	$epreuvefin = 19;
}
if ($typeconcours == "ChRSGPF"){
	$epreuvedeb = 9;
	$epreuvefin = 19;
}
if ($typeconcours == "Comp"){
	$epreuvedeb = 1;
	$epreuvefin = 19;
}
if ($typeconcours == "ChF"){
	$epreuvedeb = 100;
	$epreuvefin = 109;
}
if ($typeconcours == "GPF"){
	$epreuvedeb = 110;
	$epreuvefin = 114;
}
?>