<?php
include('connexion.php');
$query = "SELECT * FROM cneac_variables WHERE Activite='com'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)){
	$variable = $row['Variable'];
	$_SESSION[$variable] = stripslashes($row['Valeur']);
}
?>