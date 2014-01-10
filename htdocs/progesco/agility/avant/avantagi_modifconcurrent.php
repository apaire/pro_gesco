<?php
session_start();
include("../../communs/connexion.php");
$dossard = $_GET['dossard'];
$query = "SELECT * FROM agility_resultats WHERE Dossard='$dossard' LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$_SESSION['IdLicence'] = $row['IdLicence'];
$_SESSION['RetourConcurrents1'] = "../pendant/pendantagi_resultats.php";
include("avantagi_concurrents_1.php");
?>