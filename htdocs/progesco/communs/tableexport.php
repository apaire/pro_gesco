<?php
// Lecture des champs
$query = "SHOW COLUMNS FROM $table";
$result = mysql_query("SHOW COLUMNS FROM $table");
$nb_champs = mysql_num_rows($result);
$texte = "";
$texte = "[$table]$crlf$nb_champs;$auto_increment".$crlf;
for ($n = 0; $n < $nb_champs; $n++){
	$row = mysql_fetch_assoc($result);
	$nomchamps[$n] = $row['Field'];
	$texte .= $row['Field'].";".$row['Type'].";".$row['Null'].";".$row['Key'].";".$row['Default'].";".$row['Extra'].";".$crlf;
}
// Lecture du contenu
$query = "SELECT * FROM $table ORDER BY Id";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	for ($n = 0; $n < $nb_champs; $n++){
		$champ = $row[$nomchamps[$n]];
		$texte .= $champ.";";
	}
	$texte .= $crlf;
}
fputs($fp, $texte);
?>