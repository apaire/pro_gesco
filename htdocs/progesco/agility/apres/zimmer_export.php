<?php
$fichierSQL = $sauvegarde.$fichier.".sql";

backup_tables($host,$user,$pass,$bdd,'*',$fichierSQL);

/* sauvegarde  db ou juste une(les) table(s) */
function backup_tables($host,$user,$pass,$name,$tables = '*',$fichier)
{
  
  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
  
  // Récupération du nom des tables
  if($tables == '*') //cas de toutes les tables
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else // cas d'une liste de tables séparées par une virgule ,
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  // Lecture
  foreach($tables as $table)
  {
    echo "<br>Export de la table ".$table;
	$nbLignes = 0;
    
    $return.= 'DROP TABLE IF EXISTS '.$table.';';	// Ligne pour effacer la table
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));	// Ligne pour créer la structure de la table
    $return.= "\n\n".$row2[1].";\n\n";
	
	$result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);	// nb de champs de la requête

	// Lignes des données de la table
	if (mysql_affected_rows())	// insérer des données seulement s'il en existe
	{
	      $return.= 'INSERT INTO '.$table.' VALUES';
		  // boucle ligne
		  while($row = mysql_fetch_row($result)) // convertir une ligne de résultat MySQL sous la forme d'un tableau
		  {
				$return.= "(";
				// boucle colonne
				for($j=0; $j<$num_fields; $j++) 	// pour chaque valeur
				{
					  // $row[$j] = addslashes($row[$j]);	//proteger des apastrophes
					  // $row[$j] = str_replace("\n","\\n",$row[$j]);	//proteger des sauts de ligne
					  $row[$j] = mysql_real_escape_string($row[$j]);	//proteger des caractères spéciaux
					  if (isset($row[$j]))	//verifier si la valeur est vide
					  { 
						$return.= "'".$row[$j]."'" ; 
					  } else { 
						$return.= "''"; 
					  }
					  if ($j<($num_fields-1)) { $return.= ','; }	// séparer chaque valeur par une virgule, sauf la dernière
				} // fin boucle colonne
				$return.= "),\n";
				
				// Si la requete fait plus de 5 000 lignes l'envoyer en plusieurs fois
				$nbLignes++;
				if ($nbLignes > 5000)
				{
					$return = substr($return, 0, strlen($return) - 2); // enlever  les 2 dernier caractères :
					$return.=";\n\n\n";
					$return.= 'INSERT INTO '.$table.' VALUES';
					$nbLignes = 0;
				}
				
		  } // fin boucle ligne
		$return = substr($return, 0, strlen($return) - 2); // enlever les 2 dernier caractères :
		$return.=";\n\n\n";
	}
  }
  
  //save file
  $handle = fopen($fichier,'w+');
  fwrite($handle,$return);
  fclose($handle);
}

?>