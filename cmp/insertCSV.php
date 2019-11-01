
<form method="post" >
	<tr>
		<td>
	        <label for="csvFile">Chemin du fichier : </label>
	    </td>
	    <td>
	        <input type="text" name="csvFile" id="csvFile"><br><br>
	    </td>
	    <td>
	        <input type="submit" value="Envoyer">
	    </td>
	    <?php
	    	if(isset($_POST['csvFile'])){
	    		//Si on a soumis le form faire laction dinsertion avec le path fourni
	    		
	            if (isset($_POST["tableChoiceIndex"]) ){

					$dbh = Teconnect_Serv($host, $login, $password);
					if(isset($_POST["headers"])){
						$headers = true;
					}else{
						$headers = false;
					}
		            switch($_POST["tableChoiceIndex"]){
		            	case 1:
		            		$rez = csvInsertion($dbh,$base, "Auteur", $_POST['csvFile'], $headers );
		            		break;
		            	case 2:
		            		$rez = csvInsertion($dbh,$base, "Editeur", $_POST['csvFile'], $headers );
		            		break;
		            	case 3:
		            		$rez = csvInsertion($dbh,$base, "Livre", $_POST['csvFile'], $headers );
		            		break;
		            	case 4:
		            		$rez = csvInsertion($dbh,$base, "Edition", $_POST['csvFile'], $headers );
		            		break;
		            	case 5:
		            		$rez = csvInsertion($dbh,$base, "Ecriture", $_POST['csvFile'], $headers );
		            		break;
		            	default:
		            	echo "<p>It seems that this table does not exist.</p>";
		            	break;
		            }
		            $dbh = null;
		            if ($rez){
		            	echo "<td><p>Insertion effectuée à 100%!</p></td>";
		            }else{
		            	echo "<td><p>Insertion failed ! Some datas could have been already inserted.</p></td>";
		            }
	        	}

	    		//repondre en imprimant un truc, en disant si oui ou non ca a marche
	    	}
	    ?>
	</tr>
	<tr>
		<td><input id="headers" type="checkbox" name="headers" value="checked" checked> 
			<label for="headers">file with headers<br></label></td>
	</tr>
</form>

