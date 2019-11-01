
<?php

// CONNEXION to the server
function connexion_Server($Server, $LogIn, $Password){
	$dbh = new PDO("mysql:host=$Server", $LogIn, $Password);
	return $dbh;
}

// INIT CREATION database
function create_Database($myServer, $myDB)
{
	$myServer->query('CREATE DATABASE '. $myDB.' COLLATE utf8_bin');
	//$myServer->query('ALTER DATABASE '.$myDB.'CHARACTER SET utf8 COLLATE utf8_bin');
}
function destroy_Database($myServer, $myDB)
{
	$myServer->query('DROP DATABASE '. $myDB);
}
// CREATE delegated creation function
function create_Table($myServer, $myDB, $myTable, $myColumns)
{
	$myServer->query('CREATE TABLE IF NOT EXISTS `' . $myDB . '`.`'. $myTable . '` (' . $myColumns . ')  ');
}

function formatLatin($myServer, $myDB,$tName, $cName){
	$sql = 'ALTER TABLE `'.$myDB.'`.`'.$tName.'` CHANGE '.$cName.' '.$cName.' VARCHAR(128) CHARACTER SET latin1 COLLATE utf8_bin NULL DEFAULT NULL';
	$myServer->query($sql);
}

// CREATE The tables and fill it
function create_ALL_Table($myServer, $myDB)
{

	//======================= AUTEUR =======================
	// Creer et remplir la Table Auteur
	//======================= AUTEUR =======================
	$Auteur_Table= ['Auteur', '`id_auteur`', '`nom_auteur`', '`prénom_auteur`', '`naissance`', '`décès`','`nationalité`'];
	create_Table($myServer, $myDB, $Auteur_Table[0], 
	$Auteur_Table[1] .' int(4),'.
	$Auteur_Table[2] .' nvarchar(128),'.
	$Auteur_Table[3] .' nvarchar(128),'.
	$Auteur_Table[4] .' nvarchar(10),'.
	$Auteur_Table[5] .' nvarchar(10),'.
	$Auteur_Table[6] .' nvarchar(128)');
	formatLatin($myServer, $myDB,$Auteur_Table[0],  $Auteur_Table[2]);
	formatLatin($myServer, $myDB,$Auteur_Table[0],  $Auteur_Table[3]);
	formatLatin($myServer, $myDB,$Auteur_Table[0],  $Auteur_Table[6]);
	$myServer->query('ALTER TABLE `'.$myDB.'`.`'.$Auteur_Table[0].'` ADD PRIMARY KEY( '.$Auteur_Table[1].')');
	fill_Auteur_Table($myServer, $myDB, $Auteur_Table,"src/Auteur.csv");
	


	//======================= EDITEUR =======================
	// Creer et remplir la Table Editeur
	//======================= EDITEUR =======================
	$Editeur_Table= ['Editeur', '`id_editeur`', '`nom_editeur`', '`site_web`'];
	create_Table($myServer, $myDB, $Editeur_Table[0], 
	$Editeur_Table[1] .' int(4),'.
	$Editeur_Table[2] .' nvarchar(50),'.
	$Editeur_Table[3] .' nvarchar(50)');
	formatLatin($myServer, $myDB,$Editeur_Table[0],  $Editeur_Table[2]);
	formatLatin($myServer, $myDB,$Editeur_Table[0],  $Editeur_Table[3]);
	
	$myServer->query('ALTER TABLE `'.$myDB.'`.`'.$Editeur_Table[0].'` ADD PRIMARY KEY( '.$Editeur_Table[1].')');
	fill_Editeur_Table($myServer, $myDB, $Editeur_Table,"src/Editeur.csv");
	


	//======================= LIVRE =======================
	// Creer et remplir la Table Livre
	//======================= LIVRE =======================
	$Livre_Table= ['Livre', '`id_livre`', '`titre_livre`', '`genre`', '`parution`', '`nature`','`langue`'];
	create_Table($myServer, $myDB, $Livre_Table[0], 
	$Livre_Table[1] .' int(4),'.
	$Livre_Table[2] .' nvarchar(50),'.
	$Livre_Table[3] .' nvarchar(50),'.
	$Livre_Table[4] .' int(4),'.
	$Livre_Table[5] .' nvarchar(50),'.
	$Livre_Table[6] .' nvarchar(50)');
	formatLatin($myServer, $myDB,$Livre_Table[0],  $Livre_Table[2]);
	formatLatin($myServer, $myDB,$Livre_Table[0],  $Livre_Table[3]);
	formatLatin($myServer, $myDB,$Livre_Table[0],  $Livre_Table[5]);
	formatLatin($myServer, $myDB,$Livre_Table[0],  $Livre_Table[6]);

	$myServer->query('ALTER TABLE `'.$myDB.'`.`'.$Livre_Table[0].'` ADD PRIMARY KEY( '.$Livre_Table[1].')');
	fill_Livre_Table($myServer, $myDB, $Livre_Table,"src/Livre.csv");
	

	//======================= ECRITURE =======================
	// Creer et remplir la Table Ecriture
	//======================= ECRITURE =======================
	$Ecriture_Table= ['Ecriture', '`id_auteur`', '`id_livre`'];
	create_Table($myServer, $myDB, $Ecriture_Table[0], 
	$Ecriture_Table[1] .' int(4),'.
	$Ecriture_Table[2] .' int(4)');
	$myServer->query('ALTER TABLE `'.$myDB.'`.`'.$Ecriture_Table[0].'` ADD PRIMARY KEY( '.$Ecriture_Table[1].','.$Ecriture_Table[2].')');
	fill_Ecriture_Table($myServer, $myDB, $Ecriture_Table,"src/Ecrit_par.csv");
	
	
	// Contraintes Foreign Keys
	$sqlConstr = 'ALTER TABLE `'.$myDB.'`.`'.$Ecriture_Table[0].'` ADD CONSTRAINT fk_Ecriture_id_auteur FOREIGN KEY (id_auteur) REFERENCES `'.$myDB.'`.`'.$Auteur_Table[0].'`(id_auteur)';
	$myServer->query($sqlConstr);
	$sqlConstr = 'ALTER TABLE `'.$myDB.'`.`'.$Ecriture_Table[0].'` ADD CONSTRAINT fk_Ecriture_id_livre FOREIGN KEY (id_livre) REFERENCES `'.$myDB.'`.`'.$Livre_Table[0].'`(id_livre)';
	$myServer->query($sqlConstr);

	//======================= EDITION =======================
	// Creer et remplir la Table Edition
	//======================= EDITION =======================
	$Edition_Table= ['Edition', '`id_editeur`', '`id_livre`'];
	create_Table($myServer, $myDB, $Edition_Table[0], 
	$Edition_Table[1] .' int(4),'.
	$Edition_Table[2] .' int(4)');
	$myServer->query('ALTER TABLE `'.$myDB.'`.`'.$Edition_Table[0].'` ADD PRIMARY KEY( '.$Edition_Table[1].','.$Edition_Table[2].')');
	fill_Edition_Table($myServer, $myDB, $Edition_Table,"src/Edite_par.csv");
	
	
	//Contraintes Foreign Key
	$sqlConstr = 'ALTER TABLE `'.$myDB.'`.`'.$Edition_Table[0].'` ADD CONSTRAINT fk_Editeur_id_editeur FOREIGN KEY (id_editeur) REFERENCES `'.$myDB.'`.`'.$Editeur_Table[0].'`(id_editeur)';
	$myServer->query($sqlConstr);
	$sqlConstr = 'ALTER TABLE `'.$myDB.'`.`'.$Edition_Table[0].'` ADD CONSTRAINT fk_Editeur_id_livre FOREIGN KEY (id_livre) REFERENCES `'.$myDB.'`.`'.$Livre_Table[0].'`(id_livre)';
	$myServer->query($sqlConstr);
	



}

function switchHyphen($myStr){
	if ($myStr == "- " or $myStr=="-"){
		return null;
	}
	return $myStr;
}

//FILL Edition table
function fill_Edition_Table($myServer, $myDB, $tableDatas, $srcFile)
{
	$src = fopen( $srcFile ,"r");

	$stmt = $myServer->prepare('INSERT INTO `'. $myDB .'`.`'. $tableDatas[0] .
			'` ('.$tableDatas[1].', '.
			$tableDatas[2].') 
			VALUES (:idedit, :idliv)');

	$data=fgetcsv($src,1000,";"); // HERE, we ignore the title line.

	while (($data=fgetcsv($src,1000,";"))!==FALSE) {

		
		$stmt->execute(array(
			':idedit' => (int)$data[0],
			':idliv' => $data[1]
			)) ;
		

	}
	
	fclose($src);
}


// FILL Ecriture table
function fill_Ecriture_Table($myServer, $myDB, $tableDatas, $srcFile)
{
	$src = fopen( $srcFile ,"r");

	$stmt = $myServer->prepare('INSERT INTO `'. $myDB .'`.`'. $tableDatas[0] .
			'` ('.$tableDatas[1].', '.
			$tableDatas[2].') 
			VALUES (:idaut, :idliv)');

	$data=fgetcsv($src,1000,";"); // HERE, we ignore the title line.

	while (($data=fgetcsv($src,1000,";"))!==FALSE) {

		
		$stmt->execute(array(
			':idaut' => (int)$data[0],
			':idliv' => $data[1]
			)) ;
		

	}
	
	fclose($src);
}

// Fill Livre table
function fill_Livre_Table($myServer, $myDB, $tableDatas, $srcFile)
{
	$src = fopen( $srcFile ,"r");

	$stmt = $myServer->prepare('INSERT INTO `'. $myDB .'`.`'. $tableDatas[0] .
			'` ('.$tableDatas[1].', '.
			$tableDatas[2].', '.
			$tableDatas[3].', '.
			$tableDatas[4].', '.
			$tableDatas[5].', '.
			$tableDatas[6].') 
			VALUES (:id, :titre, :genre, :parution, :nature, :langue)');

	$data=fgetcsv($src,1000,";"); // HERE, we ignore the title line.

	while (($data=fgetcsv($src,1000,";"))!==FALSE) {

		
		$stmt->execute(array(
			':id' => (int)$data[0],
			':titre' => switchHyphen($data[1]),
			':genre' => switchHyphen($data[2]),
			':parution' => switchHyphen($data[3]),
			':nature' => switchHyphen($data[4]),
			':langue' => switchHyphen($data[5])
			)) ;
		

	}
	
	fclose($src);
}

// FILL Editeur Table
function fill_Editeur_Table($myServer, $myDB, $tableDatas, $srcFile)
{
	$src = fopen( $srcFile ,"r");

	$stmt = $myServer->prepare('INSERT INTO `'. $myDB .'`.`'. $tableDatas[0] .
			'` ('.$tableDatas[1].', '.
			$tableDatas[2].', '.
			$tableDatas[3].') 
			VALUES (:id, :name, :site)');

	$data=fgetcsv($src,1000,";"); // HERE, we ignore the title line.

	while (($data=fgetcsv($src,1000,";"))!==FALSE) {

		
		$stmt->execute(array(
			':id' => (int)$data[0],
			':name' => switchHyphen($data[1]),
			':site' => switchHyphen($data[2])
			)) ;
		

	}
	
	fclose($src);
}


// FILL Auteur Table
function fill_Auteur_Table($myServer, $myDB, $tableDatas, $srcFile)
{
	$src = fopen( $srcFile ,"r");

	$stmt = $myServer->prepare('INSERT INTO `'. $myDB .'`.`'. $tableDatas[0] .
			'` ('.$tableDatas[1].', '.
			$tableDatas[2].', '.
			$tableDatas[3].', '.
			$tableDatas[4].', '.
			$tableDatas[5].', '.
			$tableDatas[6].') 
			VALUES (:id, :name, :fname, :birth, :death, :nation)');

	$data=fgetcsv($src,1000,";"); // HERE, we ignore the title line.

	while (($data=fgetcsv($src,1000,";"))!==FALSE) {

		
		$stmt->execute(array(
			':id' => (int)$data[0],
			':name' => switchHyphen($data[1]),
			':fname' => switchHyphen($data[2]),
			':birth' => switchHyphen($data[3]),
			':death' => switchHyphen($data[4]),
			':nation' => switchHyphen($data[5])
			)) ;
		

	}

	fclose($src);
}

?>







