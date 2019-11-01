

<?php

	// CONNEXION to the server
	function Teconnect_Serv($Server, $LogIn, $Password){
		$dbh = new PDO("mysql:host=$Server", $LogIn, $Password);
		return $dbh;
	}
	function connect_Serv($Server, $LogIn, $Password){
		$dbh = new PDO("mysql:host=$Server", $LogIn, $Password);
		return $dbh;
	}

	function createSelectMenu($ref,$myArray){
		$SelectMenu ="<td><select class=\"form-control form-control-lg\" name='".$ref."' id ='".$ref."'>" ;
		$Nb = count($myArray);
		for ($i=0; $i < $Nb; $i++){
			$SelectMenu .="<option value='".$myArray[$i]."'>".$myArray[$i]."</option>";
		}
		$SelectMenu .= "</select></td>";
		return $SelectMenu;
	}


	function field_Insertion($myServer, $myDB, $TableName){

		// Prepare the database
		$myServer->query('USE '.$myDB);
		$sql = 'SELECT * FROM `'.$myDB.'`.`'.$TableName.'`';
		$req = $myServer->query($sql);

		
		// Affichage de l'entête du tableau d'insertion
		echo '<p align="center" id="TableName">'.$TableName.'</p>';
		echo "<table border=\"0\" cellpadding=\"1\">";
		echo "<tr>";
		$tNames= $myServer->query("DESCRIBE ".$TableName);
		$table_fields = $tNames->fetchAll(PDO::FETCH_COLUMN);
		$colNb = $req->columnCount();
		for ($i=0; $i < $colNb; $i++)
		{
		echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">".$table_fields[$i]."</td>";
		}
			// Entête du bouton d'action
		echo "</tr>";


		//Creation des inputs pour entrer les valeurs
		echo '<tr>';
		for ($i=0; $i < $colNb; $i++)
		{
			switch($table_fields[$i]){
				case 'nature':
				$inputAtIndexi=createSelectMenu($table_fields[$i],[ "BD", "roman", "nouvelle", "cours", "manuel", "theatre"]);
					break;
				case 'genre':
				$inputAtIndexi=createSelectMenu($table_fields[$i],["fantastique", "sentimental", "amour", "comedie", "essais", "histoire", "science", "philosophie", "poesie", "religion", "science-fiction", "suspens", "policier", "technique", "roman", "theatre", "humour"]);
					break;
				default:
					$inputAtIndexi= "<td><input type='text' name='".$table_fields[$i]."' id='".$table_fields[$i]."'><br><br></td>";
					break;
			}
			
		echo $inputAtIndexi;
		}
		
		// Bouton d'action
		$btnAction ='<td><button id="btnDB" onclick="insertManual([';
		// Ici creer l'array ['truc,'machin','chose',...]

		//Insérer la database
		$btnAction .='\'';
		$btnAction .= $myDB;
		$btnAction .='\'';
		//Insérer le nom de la table
		$btnAction .=',\'';
		$btnAction .= $TableName;
		$btnAction .='\'';	
		// Faire les autres avec boucle en oubliant pas les virgules AVT
		for ($i=0; $i < $colNb; $i++){
			$btnAction .=',\'';
			$btnAction .= $table_fields[$i];
			$btnAction .='\'';	
		}
		$btnAction .= '])" type="button" class="btn btn-success">Insérer</button></td>';
		echo $btnAction;

		echo '</tr>';
		echo '</table>';
	}

	function launchDBInsertion ($myServer, $dataArray){
		//Diviser l'array pour retirer les infos utiles
		$dbName = $dataArray[0];
		$TableName = $dataArray[1]; // Constant
			//Recupérer les titres de column
		$titleArray = array();
		$stop = (count($dataArray) - 2)/2 +2; //Calcul pour viser que les titres
		for($i=2;  $i < $stop; $i++){
			array_push($titleArray,$dataArray[$i]);
		}

		//Recupérer les valeurs des columns
		$valArray = array();
		$deb = $stop;
		for($i=$deb;  $i < count($dataArray); $i++){
			array_push($valArray,$dataArray[$i]);
		}
		global $base;
		//Tenter l'insertion avec autre fct, faire un if et decider du return
		return insertThis($myServer,$dbName, $TableName, $titleArray, $valArray);
	}

	function insertThis($myServer, $myDB, $name, $titles, $vals){
		//INSERTION query
		$sqlInsert= 'INSERT INTO `'. $myDB .'`.`'. $name . '` ('.makeTitleList($titles).') VALUES ('.makeValList($vals).')';
		
		//Trouver les clefs primaires d'une table;
		$pkArray = getPrimaryKeys($myServer,$myDB, $name);
		//preparer les conditions de WHERE avec les primary keys;
		$whConditions = buildWhereConditions($pkArray, $titles, $vals);
		//preparer les conditions de SET si update needed;
		$stConditions = buildSetConditions($pkArray, $titles, $vals);
		
		//UPDATE query
		$sqlUpdate = 'UPDATE `'. $myDB .'`.`'. $name . '` SET '.$stConditions.' WHERE '.$whConditions;

		$query = "SELECT * FROM `".$myDB."`.`".$name."` WHERE ".$whConditions;
		if(isTheResultNotEmpty($query, $myServer)){
			//On doit UPDATER la ligne correspondant
			$realQuery = $sqlUpdate;
		}else{
			//On doit INSERT la ligne correspondant
			$realQuery = $sqlInsert;
		}
		
		if($myServer->query($realQuery) == false){
			return false;
		}else{
			return true;
		}

		//////////
		

	}

	function makeTitleList($titles){
		if (count($titles)==0){
			return "";
		}
		$myStr= '`'.$titles[0].'`'; //Constant, faut forcement mettre le premier
		for($i=1;  $i < count($titles); $i++){
			$myStr.=",`";
			$myStr.= $titles[$i];
			$myStr.="`";
		}
		return $myStr;
	}


	function makeValList($vals){
		if (count($vals)==0){
			return "";
		}
		$myStr= '\''.wellApostrophe($vals[0]).'\''; //Constant, faut forcement mettre le premier
		for($i=1;  $i < count($vals); $i++){
			$myStr.=",'";
			$myStr.= switchHyph(wellApostrophe($vals[$i]));
			$myStr.="'";
		}
		return $myStr;
	}

	function wellApostrophe($mystr){
		$withEscapedApostrophe = "" ;

		for($i = 0; $i < strlen($mystr);$i++){
			if($mystr[$i]=="'"){
				$withEscapedApostrophe .= "''";
			}else{
				$withEscapedApostrophe .= $mystr[$i];
			}
		}
		return $withEscapedApostrophe;
	}


	function isTheResultNotEmpty($query, $myServer){
		$res = $myServer->query($query);
		$mybool = false;
		while ($datas = $res->fetch(PDO::FETCH_NUM)){$mybool = true;}
		return $mybool;
	}

	function buildSetConditions($pkArray, $titles, $vals){
		$setConditions="";
		$max = count($titles);
		for($i=0; $i < $max; $i++){
			if (!in_array($titles[$i],$pkArray)){
				if($setConditions==""){$setConditions.='`'.$titles[$i].'`=\''.switchHyph($vals[$i]).'\'';}
				else{$setConditions.=', `'.$titles[$i].'`=\''.switchHyph($vals[$i]).'\'';}
			}else{/*Ce nest pas une clef primaire*/}
		}
		return $setConditions;
	}

	function buildWhereConditions($pkArray, $titles, $vals){
		$whereConditions="";
		$max = count($titles);
		for($i=0; $i < $max; $i++){ //Alors cest une clef primaire, donc la mettre en condition
			if (in_array($titles[$i],$pkArray)){
				if($whereConditions==""){$whereConditions.='`'.$titles[$i].'`=\''.$vals[$i].'\'';}
				else{$whereConditions.=' AND `'.$titles[$i].'`=\''.$vals[$i].'\'';}
			}else{/*Ce nest pas une clef primaire*/}
		}
		return $whereConditions;
	}


	function getPrimaryKeys($myServer, $myDB, $name){
		$res = $myServer->query('DESCRIBE `'.$myDB.'`.`'.$name.'`'); 
		$primary_key = array(); 
		while($line = $res->fetch(PDO::FETCH_ASSOC))
		{ 
			if(isset($line['Key']) && $line['Key'] == 'PRI'){ 
				array_push($primary_key,$line['Field']);
			} 
		}  
		return $primary_key; 
	}

	function getTitlesFromTable($myServer, $myDB, $TableName){
		$res = $myServer->query('DESCRIBE `'.$myDB.'`.`'.$TableName.'`'); 
		$keys = array();
		while($line = $res->fetch(PDO::FETCH_ASSOC)){array_push($keys,$line['Field']);}
		return $keys;
	}

	function csvInsertion($myServer, $myDB, $TableName, $srcPATH, $headers){
		try{
			$src = fopen( $srcPATH ,"r");
		}catch (Exception $e) {
			return false;
		}
		if(!$src){return false;} // Si ca na pas marché

		$titles = getTitlesFromTable($myServer, $myDB, $TableName);

		if($headers){
			$data=fgetcsv($src,1000,";"); // HERE, we ignore the title line.
		}

		while (($data=fgetcsv($src,1000,";"))!==FALSE) {
			$sqlInsert= 'INSERT INTO `'. $myDB .'`.`'. $TableName . '` ('.makeTitleList($titles).') VALUES ('.makeValList($data).')';
			if(!($myServer -> query ($sqlInsert))){
				return false;
			}else{/*on continue*/}
		}
		//tout sest bien passé
		return true;
	}

	function launchDBSuppr ($dbName, $myServer, $dataArray){
		//Diviser l'array pour retirer les infos utiles
		$TableName = $dataArray[0]; // Constant
			//Recupérer les titres de column
		$titleArray = array();
		$stop = (count($dataArray) - 1)/2 +1; //Calcul pour viser que les titres
		for($i=1;  $i < $stop; $i++){
			array_push($titleArray,$dataArray[$i]);
		}

		//Recupérer les valeurs des columns
		$valArray = array();
		$deb = $stop;
		for($i=$deb;  $i < count($dataArray); $i++){
			array_push($valArray,$dataArray[$i]);
		}
		
		//Tenter l'insertion avec autre fct, faire un if et decider du return
		return supprThis($myServer,$dbName, $TableName, $titleArray, $valArray);
	}

	function supprThis($myServer, $myDB, $name, $titles, $vals){
		
		//Trouver les clefs primaires d'une table;
		$pkArray = getPrimaryKeys($myServer,$myDB, $name);
		//preparer les conditions de WHERE avec les primary keys;
		$whConditions = buildWhereConditions($pkArray, $titles, $vals);
		//SUPPR query
		$sqlsuppr = 'DELETE FROM `'. $myDB .'`.`'. $name .'` WHERE '.$whConditions;
		
		if($myServer->query($sqlsuppr) == false){
			return false;
		}else{
			return true;
		}

		//////////
		

	}


	function switchHyph($myStr){
		if ($myStr == "- " or $myStr=="-"){
			return null;
		}
		return $myStr;
	}


?>
