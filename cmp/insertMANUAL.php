<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<script type="text/javascript">
	
	function insertManual(myArray) //Recuperer dans myArray les titres
	{
		// Recuperer en JS les valeurs des input
		var tmpArray = [];
		for(var i= 2; i < myArray.length; i++){
     		var myInput = document.getElementById(myArray[i]);
			if (myInput && myInput.value) {
  				tmpArray.push(myInput.value);
			}else{
				//Le champs est vide, on arrete tout !!!
				alert("Le champs " + myArray[i] +" est manquant ! Remplissez tous les champs avant d'insérer.");
				return false;
			}
		}
		var AllArray = myArray.concat(tmpArray);
		console.log(AllArray);
		
		jQuery.ajax({
		    type: "POST",
		    url: 'fct/DBInsert.php',
		    dataType: 'json',
		    data: {functionname: 'InsertMano', wtd: AllArray},
		    success: function (obj, textstatus) {
		                  if( !('error' in obj) ) {
		                      // On a reussi le insert !
		                      alert(obj.success);
		                      location.reload();
		                  }else {
		                  		//Une erreur sest produite
		                      alert(obj.error);
		                  }
		            }
		});

	}
</script>

<?php


	if (isset($_POST["tableChoiceIndex"]) ){
			
			$dbh = connect_Serv($host, $login, $password);
            switch($_POST["tableChoiceIndex"]){
            	case 1:
            		field_Insertion($dbh,$base, "Auteur");
            		break;
            	case 2:
            		field_Insertion($dbh,$base, "Editeur");
            		break;
            	case 3:
            		field_Insertion($dbh,$base, "Livre");
            		break;
            	case 4:
            		field_Insertion($dbh,$base, "Edition");
            		break;
            	case 5:
            		field_Insertion($dbh,$base, "Ecriture");
            		break;
            	default:
            	echo "<p>It seems that this table does not exist.</p>";
            	break;
            }
            $dbh = null;

		}
?>