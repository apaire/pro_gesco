<?php
include 'Encoding.php';
$DEBUG = True;

// Récupération des paramètres POST
$licence = $_POST['licence'];
$nomChien = Encoding::toUTF8($_POST["nom_chien"]);
$nomConducteur = Encoding::toUTF8($_POST["nom_conducteur"]);
$codePostal = $_POST["code_postal"];
$epreuve1 = $_POST["epreuve1"];
$epreuve2 = $_POST["epreuve2"];

if ($DEBUG) {
    echo "POST param[licence] = $licence<br/>";
    echo "POST param[nom_chien] = $nomChien<br/>";
    echo "POST param[nom_conducteur] = $nomConducteur<br/>";
    echo "POST param[codePostal] = $codePostal<br/>";
    echo "POST param[epreuve1] = $epreuve1<br/>";
    echo "POST param[epreuve2] = $epreuve2<br/>";
}

// Control de la pertinence des paramètres POST
if (!isset($licence) || $licence === "" || !isset($nomChien) || $nomChien === "" || !isset($nomConducteur) || $nomConducteur === "" || !isset($codePostal) || $codePostal === "" || !isset($epreuve1) || $epreuve1 === ""
    || ($epreuve1 === "2" && (!isset($epreuve2) || $epreuve2 === ""))) {
?>
Tous les champs sont n&eacute;cessaires &agrave; la pr&eacute;-inscription. En cas de probl&egrave;me veuillez envoyer un mail &agrave; help@me.com<br/>
<input type='button' onclick='history.back();' value='Retour'/>
<?php
    exit();
}
// Si Epreuve2 n'est pas renseigné, on force à la valeur associée au degré
if ($epreuve2 === "") {
    if ($epreuve1 === "1") {
        $epreuve2 = "normal";
    }
    if ($epreuve1 === "3") {
        $epreuve2 = "plus";
    }
}

// Connexion base de données locale
include("progesco/communs/connexion.php");

// Reccherche des données du licencier pour controle d'identité
$query = "SELECT Id,NomChien,Affixe,Categorie,Nom,Prenom,CP,AGI1 FROM cneac_licences WHERE Licence='$licence'";
if ($DEBUG) { echo "SQL=$query <br/>"; }

$donneesLicence = mysql_query($query);
if (!$donneesLicence) {
?>
Num&eacute;ro de licence incorrect. En cas de probl&egrave;me veuillez envoyer un mail &agrave; help@me.com<br/>
<input type='button' onclick='history.back();' value='Retour'/>
<?php
    exit();
}

// Controle l'identité de l'utilisateur
if (!controlIdentite($donneesLicence, $_POST, $DEBUG)) {
?>
Les donn&eacute;es que vous avez saisies ne nous permettent pas de valider votre pr&eacute;-inscription. Veuillez envoyer un mail &agrave; help@me.com<br/>
<input type='button' onclick='history.back();' value='Retour'/>
<?php
    exit();
}

// Controle la cohérence des epreuves choisies
if (($msg = controlEpreuves($epreuve1, $epreuve2))) {
    echo $msg . "Veuillez refaire votre choix d'&eacute;preuves<br/>";
?>
<input type='button' onclick='history.back();' value='Retour'/>
<?php
    exit();
}

// Controle si la pré-inscription n'a pas déjà été faite
if (mysql_result($donneesLicence, 0, 'AGI1') === "Y") {
?>
La pr&eacute;-inscription a d&eacute;j&agrave; &eacute;t&eacute; prise en compte. En cas de probl&egrave;me veuillez envoyer un mail &agrave; help@me.com<br/>
<input type='button' onclick='history.back();' value='Retour'/>
<?php
    exit();
}

// Envoie de la requête à Progesco pour ajouter le concurrent dans la base de données
if (!recordProgesco($donneesLicence, $licence, $epreuve1, $epreuve2, $DEBUG)) {
?>
Une erreur s'est produite lors de votre pr&eacute;-inscription. Veuillez envoyer un mail &agrave; help@me.com<br/>
<input type='button' onclick='history.back();' value='Retour'/>
<?php
    exit();
}

?>
Merci. Votre pr&eacute;-inscription a &eacute;t&eacute; prise en compte.

<?php
/**
 * Fonction permettant de vérifier la pertinence des données saisies par l'utilisateur
 *  Vérification du nom du chien, du nom du conducteur et du code postal du lieu de résidence du conducteur.
 * 
 * La fonction retourne True en cas de succès, False en cas de données ne correspondant pas à ce qu'il y a dans la base de données des licenciés
 */
function controlIdentite($donneesLicence, $userParam, $DEBUG) {

    // Récupération des informations de la base de données
    $dbNomChien = Encoding::toUTF8(trim(mysql_result($donneesLicence, 0, 'NomChien')));
    $dbAffixe = Encoding::toUTF8(trim(mysql_result($donneesLicence, 0, 'Affixe')));
    $dbCategorie = trim(mysql_result($donneesLicence, 0, 'Categorie'));
    $dbNomConducteur = Encoding::toUTF8(trim(mysql_result($donneesLicence, 0, 'Nom')));
    $dbPrenomConducteur = Encoding::toUTF8(trim(mysql_result($donneesLicence, 0, 'Prenom')));
    $dbCodePostal = trim(mysql_result($donneesLicence, 0, 'CP'));
    
    // Récupération des informations passées par l'utilisteur
    $nomChien = Encoding::toUTF8(trim($_POST["nom_chien"]));
    $nomConducteur = Encoding::toUTF8(trim($_POST["nom_conducteur"]));
    $codePostal = trim($_POST["code_postal"]);
    $epreuve1 = trim($_POST["epreuve1"]);
    $epreuve2 = trim($_POST["epreuve2"]);

    if ($DEBUG) {
        echo "NomChien= $dbNomChien <br/>";
        echo "Affixe= $dbAffixe <br/>";
        echo "Categorie= $dbCategorie <br/>";
        echo "Nom= $dbNomConducteur <br/>";
        echo "Prenom= $dbPrenomConducteur <br/>";
        echo "CP= $dbCodePostal<br/>";
    }
    
    // Si le code postal saisi n'est pas le bon, on sort en erreur (On ignore le test si le code postal n'est pas rempli dans la base de données)
    if ($dbCodePostal !== "" && strcasecmp($codePostal, $dbCodePostal)) {
        return False;
    }
    
    // Si le nom du chien saisi n'est pas le bon, on sort en erreur
    if (strcasecmp($dbNomChien, $nomChien) && strcasecmp($dbNomChien . " " . $dbAffixe, $nomChien)) {
        return False;
    }
    
    // Si le nom du conducteur n'est pas le bon, on sort en erreur
    if (strcasecmp($nomConducteur, $dbNomConducteur) && strcasecmp($nomConducteur, $dbPrenomConducteur) && strcasecmp($nomConducteur, $dbNomConducteur . " " . $dbPrenomConducteur) && strcasecmp($nomConducteur, $dbPrenomConducteur . " " . $dbNomConducteur)) {
        return False;
    }
    
    // Si les données passées sont bonnes on sort avec succès
    return True;
}

/**
 * Fonction de contrôle de la cohérance des épreuves.
 *  Un 1er degré ne peut pas s'inscrire aux épreuves PLUS et un 3ème degré ne peut pas s'inscrire aux épreuves NORMALES
 *
 * La fonction retourn une chaine vide en cas d'absence de problème, ou un message d'erreur précisant sa nature en cas d'erreur.
 */
function controlEpreuves($epreuve1, $epreuve2) {
    if ($epreuve1 == "1" && $epreuve2 == "plus") {
        return "Vous ne pouvez pas vous inscrire en &eacute;preuves PLUS, lorsque vous &ecirc;tes en 1<sup>er</sup> degr&eacute;. ";
    }
    if ($epreuve1 == "3" && $epreuve2 == "normal") {
        return "Vous ne pouvez pas vous inscrire en &eacute;preuves NORMALES, lorsque vous &ecirc;tes en 3<sup>&egrave;me</sup> degr&eacute;. ";
    }
    return "";
}

/**
 * Fonction d'enregistrement du concurrent dans la base de données PROGESCO
 *  Cette fonction envoie une requête http au serveur web de PROGESCO.
 *
 * La fonction retourne True en cas de succès de l'enregistrement du concurrent dans la base et False en cas d'echec.
 */
function recordProgesco($donneesLicence, $licence, $epreuve1, $epreuve2, $DEBUG) {
    $idlicence = trim(mysql_result($donneesLicence, 0, 'Id'));

    $url = "http://".$_SERVER['HTTP_HOST'].'/progesco/agility/avant/avantagi_concurrents_2.php';
    $fields = array('RetourConcurrents1' => urlencode("avantagi_concurrents.php"),
                    'IdLicence' => urlencode($idlicence),
                    'Licence' => urlencode($licence),
                    'validconcurrent' => urlencode("1"),
                    'epreuve1' => urlencode($epreuve1),
                    'epreuve2' => urlencode($epreuve2));

    //url-ify the data for the POST
    $fields_string = "";
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    //execute post
    $result = curl_exec($ch);

    if ($DEBUG) {
        echo "------------------------------<br/>";
        echo $result;
        echo "------------------------------<br/>";
    }

    //close connection
    curl_close($ch);

    if (strpos($result, "concurrent est enregistr") === False && strpos($result, "concurrents sont enregistr") === False) {
        return False;
    }
    return True;
}
?>
