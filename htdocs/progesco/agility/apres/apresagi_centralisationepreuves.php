<?php
$sep = '","';

$codeepreuvecentragils = array("1"=>"1", "2"=>"2", "3"=>"3", "4"=>"R", "5"=>"O", "6"=>"S", "7"=>"J", "8"=>"h", "9"=>"Champ. Rég. 2ème degré", "10"=>"Champ. Rég. 2ème degré", "11"=>"Champ. Rég. 2ème degré", "12"=>"Coupe Régionale 2ème degré", "13"=>"Champ. Rég. 3ème degré", "14"=>"Champ. Rég. 3ème degré", "15"=>"Champ. Rég. 3ème degré", "16"=>"Coupe Régionale 3ème degré", 17=>"Sélectif GPF", "18"=>"Sélectif GPF", "19"=>"Sélectif GPF");

$qalificatifs = array("X"=>"EXC", "T"=>"TBO", "B"=>"BON", "N"=>"NCL", "E"=>"ELI", "A"=>"ABA", "F"=>"FOR");

$codeclasses = array("1"=>"S", "2"=>"J", "3"=>"P");

$nomepreuve = $nomepreuveabrs[$epreuve]." ".$nomclasses[$classe]." ".$nomcategories[$categorie];

$codeepreuvecentragil = $handi.$codeepreuvecentragils[$epreuve];
if ($codeeprevecentragil == "1" and $classe == 2){$codeepreuvecentragil = "U";}
if ($codeeprevecentragil == "2" and $classe == 2){$codeepreuvecentragil = "D";}
$codeepreuvecentragil .= $nomcategories[$categorie].$codeclasses[$classe];

?>