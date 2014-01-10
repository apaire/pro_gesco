<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
</head>
<body>

<?php
$fichier = $_SESSION['Fichier'];
$concours = $_SESSION['Concours'];
$boundary = "-----=".md5(uniqid(rand()));
$header = "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
$header .= "\r\n";

// Message
$msg = "Ceci est un message au format MIME 1.0 multipart/mixed.\r\n";
$msg .= "--$boundary\r\n";
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
$msg .= "Content-Transfer-Encoding:8bit\r\n";
$msg .= "\r\n";
$msg .= "Ci-joint le fichier de sauvegarde du concours Agility\r\n";
$msg .= "\r\n";

// Traitement du fichier à transmettre
$fp = fopen($fichier, "rb");   // b c'est pour les windowsiens
$attachment = fread($fp, filesize($fichier));
fclose($fp);
$attachment = chunk_split(base64_encode($attachment));
$msg .= "--$boundary\r\n";
$msg .= "Content-Type: progesco/plain; name=\"$concours\"\r\n";
$msg .= "Content-Transfer-Encoding: base64\r\n";
$msp .= "Content-Disposition: attachment; filename=\"$concours\"\r\n\n";
$msg .= "\r\n";
$msg .= $attachment . "\r\n";
$msg .= "\r\n\r\n";
$msg .= "--$boundary--\r\n";

// Variables
$destinataire = $_SESSION['Adresses_envoi'];
$expediteur   = "progesco@sportscanins.fr";
$reponse      = $expediteur;
echo "<p class='center'>Le fichier $concours a été envoyé à $destinataire</p>";
mail($destinataire, "Fichier Progesco", $msg, "From: $expediteur\r\n".$header);

?>
</body>
</html>
