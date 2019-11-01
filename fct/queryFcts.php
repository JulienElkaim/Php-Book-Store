<?php

	// CONNEXION to the server
	function MYconnect_Serv($Server, $LogIn, $Password){
		$dbh = new PDO("mysql:host=$Server", $LogIn, $Password);
		return $dbh;
	}

	function displayResult($tmp){
		
		while ($datas = $tmp->fetch(PDO::FETCH_BOTH))
		{
			echo "<tr>"; // nouvelle ligne du tableau
			$colNb = $tmp->columnCount();

			for ($i=0; $i < $colNb; $i++){ // Toutes les lignes de datas
				echo "<td align=\"center\">".$datas[$i]."</td>";
			}
			echo "</tr>";
			
		}
	}

?>