<script type="text/javascript">
      
      function modManual(myArray) //Recuperer dans myArray les titres
      {
            // Recuperer en JS les valeurs des input
            var titleArray = [];
            var stop = myArray.length/2;
            for(var i= 0; i < stop; i++){
                  titleArray.push(myArray[i]);
            }
            var valuesArray =[];
            for(var i= stop; i < myArray.length; i++){
                  valuesArray.push(myArray[i]);
            }

            for(var i= 0; i < titleArray.length; i++){
                  document.getElementById(titleArray[i]).value = valuesArray[i];
            }
            
            
            

      }

      function suprrManual(myArray){
            //Doit envoyer au php l'array qu'il a recu
            tmpArray = [document.getElementById("TableName").innerHTML];
            var AllArray = tmpArray.concat(myArray);
            console.log(AllArray);
            jQuery.ajax({
                type: "POST",
                url: 'fct/DBInsert.php',
                dataType: 'json',
                data: {functionname: 'SupprMano', wtd: AllArray},
                success: function (obj, textstatus) {
                              
                              if( !('error' in obj) ) {
                                  // On a reussi le insert !
                                  alert(obj.success);
                                  location.reload();

                              }
                              else {
                                          //Une erreur sest produite
                                  alert(obj.error);
                              }
                        }
            });
      }

</script>
<?php
	include ("fct/tableDisplayerFcts.php");
	
	if (isset($_POST["tableChoiceIndex"]) ){
			
		$dbh = connexion_Server($host, $login, $password);
            switch($_POST["tableChoiceIndex"]){
            	case 1:
            		db_DisplayerINSERT($dbh,$base, "Auteur");
            		break;
            	case 2:
            		db_DisplayerINSERT($dbh,$base, "Editeur");
            		break;
            	case 3:
            		db_DisplayerINSERT($dbh,$base, "Livre");
            		break;
            	case 4:
            		db_DisplayerINSERT($dbh,$base, "Edition");
            		break;
            	case 5:
            		db_DisplayerINSERT($dbh,$base, "Ecriture");
            		break;
            	default:
            	echo "<p>It seems that this table does not exist.</p>";
            	break;
            }

	}
?>