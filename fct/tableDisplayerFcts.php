<?php

// CONNEXION to the server
function connexion_Server($Server, $LogIn, $Password){
	$dbh = new PDO("mysql:host=$Server", $LogIn, $Password);
	return $dbh;
}

function db_Displayer($myServer, $myDB, $TableName){

	// Prepare the database
	$myServer->query('USE '.$myDB);
	$sql = 'SELECT * FROM `'.$myDB.'`.`'.$TableName.'`';
	$req = $myServer->query($sql);

	
	// Affichage de l'entête du tableau
	echo '<h2> Table Displayer :</h2>';
	echo "<table border=\"0\" cellpadding=\"1\">";
	echo "<tr>";
	$tNames= $myServer->query("DESCRIBE ".$TableName);
	$table_fields = $tNames->fetchAll(PDO::FETCH_COLUMN);
	$colNb = $req->columnCount();
	for ($i=0; $i < $colNb; $i++)
	{
	echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">".$table_fields[$i]."</td>";
	   }
	echo "</tr>";


	// affichage des datas
	$tValues = $myServer->query("SELECT * FROM ".$myDB.".".$TableName);

	while ($datas = $tValues->fetch(PDO::FETCH_NUM))
	{
		echo "<tr>"; // nouvelle ligne du tableau
		for ($i=0; $i < $colNb; $i++){
			echo "<td align=\"center\">".$datas[$i]."</td>";
		}
		echo "</tr>"; // fin de la ligne du tableau
	}

	// terminer la table
	echo "</table>";
	
	
}


//Table in insert version
function db_DisplayerINSERT($myServer, $myDB, $TableName){

	// Prepare the database
	$myServer->query('USE '.$myDB);
	$sql = 'SELECT * FROM `'.$myDB.'`.`'.$TableName.'`';
	$req = $myServer->query($sql);

	
	// Affichage de l'entête du tableau
	echo '<h2> Table Displayer :</h2>';
	echo "<table border=\"0\" cellpadding=\"1\">";
	echo "<tr>";
	$tNames= $myServer->query("DESCRIBE ".$TableName);
	$table_fields = $tNames->fetchAll(PDO::FETCH_COLUMN);
	$colNb = $req->columnCount();
	for ($i=0; $i < $colNb; $i++)
	{
	echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">".$table_fields[$i]."</td>";
	   }
	//AJOUT TABLE INSERT : Titre correspondant aux boutons d'action
	echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">MOD/SUPRR</td>";
	echo "</tr>";


	// affichage des datas
	$tValues = $myServer->query("SELECT * FROM ".$myDB.".".$TableName);

	while ($datas = $tValues->fetch(PDO::FETCH_NUM))
	{
		echo "<tr>"; // nouvelle ligne du tableau

		for ($i=0; $i < $colNb; $i++){ // Toutes les lignes de datas
			echo "<td align=\"center\">".$datas[$i]."</td>";
		}
		//AJOUT TABLE INSERT : btns correspondant à la ligne de donnees;
		echo '<td>';
			echo "<table>";
			echo '<tr>';
				echo '<td>';
					createBtnMod($myServer, $myDB, $TableName, $datas, $colNb);
				echo '</td>';
				echo '<td>';
				createBtnSuprr($myServer, $myDB, $TableName, $datas, $colNb);
				echo '</td>';
			echo '</tr>';
			echo "</table>";
		echo '</td>';
		echo "</tr>"; // fin de la ligne du tableau
	}
	// terminer la table
	echo "</table>";
	
	
}
function createBtnMod($myServer, $myDB, $TableName, $datas, $colNb){
	createRelativeBtnLine($myServer, $myDB, $TableName, $datas, $colNb, "modManual","Modifier","warning");
}
function createBtnSuprr($myServer, $myDB, $TableName, $datas, $colNb){
	createRelativeBtnLine($myServer, $myDB, $TableName, $datas, $colNb, "suprrManual","Supprimer", "danger");
}

function createRelativeBtnLine($myServer, $myDB, $TableName, $datas, $colNb, $fct, $btnName,$btnType){
	$titles= getTitles($myServer, $myDB, $TableName);

		$tempList="";
	
		// Faire les autres avec boucle en oubliant pas les virgules AVT
		for ($i=0; $i < $colNb; $i++){
			if ($tempList==""){
				$tempList .='\'';
				$tempList .= $titles[$i];
				$tempList .='\'';
			}else{
				$tempList .=',\'';
				$tempList .= $titles[$i];
				$tempList .='\'';
			}	
		}
		for ($i=0; $i < $colNb; $i++){
			$tempList .=',\'';
			$tempList .= wellApost($datas[$i]);
			$tempList .='\'';
		}

		$btnMod ='<button id="btnDB" onclick="'.$fct.'([';
		$btnMod.=$tempList;
		$btnMod .= '])" type="button" class="btn btn-'.$btnType.'">'.$btnName.'</button>';
		echo $btnMod;

}

function wellApost($mystr){
	$withEscapedApostrophe = "" ;

	for($i = 0; $i < strlen($mystr);$i++){
		if($mystr[$i]=="'"){
			$withEscapedApostrophe .= "\\'";
		}else{
			$withEscapedApostrophe .= $mystr[$i];
		}
	}
	return $withEscapedApostrophe;
}

function getTitles($myServer, $myDB, $TableName){
	$res = $myServer->query('DESCRIBE `'.$myDB.'`.`'.$TableName.'`'); 
	$keys = array();
	while($line = $res->fetch(PDO::FETCH_ASSOC)){array_push($keys,$line['Field']);}
	return $keys;
}

?>

