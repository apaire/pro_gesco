<?php
session_start();
$titre = "<a href='avantagi.php'>Avant le concours</a> &gt; <a href='avantagi_concurrentsimp.php'>Impression des concurrents</a>";
include("../utilitaires/bandeau_agi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROGESCO</title>
<meta name="author" content="J.P Tourrès" />
<meta name="copyright" content="J.P Tourrès" />
<link href="../../communs/styles.css" rel="stylesheet" type="text/css" />
</head>
<body onload="parent.Bandeau.location.href='avant_dossardsimp_bandeau.php'">
<h3 class="center">Impression des concurrents</h3>
<p class="center">Choisissez l'ordre d'affichage des concurrents en cliquant sur la ligne correspondante</p>

<table class="general" align="center">
	<tr><th><div class="boutonimp"><a href="avantagi_concurrentsimp_1.php?ordre=Licence" target="_blank">PAR NUMERO DE LICENCE</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="avantagi_concurrentsimp_1.php?ordre=CodeClub" target="_blank">PAR CLUB</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="avantagi_concurrentsimp_1.php?ordre=Categorie" target="_blank">PAR CATEGORIE</a></div></th></tr>
	<tr><th><div class="boutonimp"><a href="avantagi_concurrentsimp_1.php?ordre=CodeRace" target="_blank">PAR RACE</a></div></th></tr>
	<tr><th align="center"><div class="bouton"><a href="avantagi.php">RETOUR</a></div></th></tr>
</table>
</body>
</html>