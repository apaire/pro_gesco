<?php
$query = "SELECT Id FROM agility_epreuves WHERE Epreuve='$epreuve' AND Categorie='$categorie' AND Classe='$classe' AND Handi='$handi'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$idepreuve = $row['Id'];
$query = "INSERT INTO agility_resultats SET Licence='$licence', IdLicence='$idlicence', Dossard='$dossard', IdEpreuve='$idepreuve', Epreuve='$epreuve', Categorie='$categorie', Classe='$classe', Handi='$handi', Brevet=''";
mysql_query($query);
?>