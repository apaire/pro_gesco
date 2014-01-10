<h3 class="center">C'est la première utilisation du logiciel sur cet ordinateur</h3>
<?php
// Création de la base de données
$query = "CREATE DATABASE cneac DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if (mysql_query($query)){
	echo "<p class='center'>La base de données 'cneac' a été créée</p>";
	mysql_select_db('cneac');
} else {
	echo "<p class='center'>La base de données 'cneac' n'a pas pu être créée<br />".mysql_error()."</p>";
}
// Création des tables
include("communs/creation_tables_cneac.php");
include("communs/creation_tables_agility.php");
?>