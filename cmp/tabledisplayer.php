<?php
	include ("fct/tableDisplayerFcts.php");
	
	if (isset($_POST["tableChoiceIndex"]) ){
			
			$dbh = connexion_Server($host, $login, $password);
            switch($_POST["tableChoiceIndex"]){
            	case 1:
            		db_Displayer($dbh,$base, "Auteur");
            		break;
            	case 2:
            		db_Displayer($dbh,$base, "Editeur");
            		break;
            	case 3:
            		db_Displayer($dbh,$base, "Livre");
            		break;
            	case 4:
            		db_Displayer($dbh,$base, "Edition");
            		break;
            	case 5:
            		db_Displayer($dbh,$base, "Ecriture");
            		break;
            	default:
            	echo "<p>It seems that this table does not exist.</p>";
            	break;
            }

		}
?>