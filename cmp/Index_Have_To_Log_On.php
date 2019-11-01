<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<script type="text/javascript">
	
	function dbCreate()
	{
		jQuery.ajax({
		    type: "POST",
		    url: 'DB.php',
		    dataType: 'json',
		    data: {functionname: 'CreateMYDB'},

		    success: function (obj, textstatus) {
		    			
		                  if( !('error' in obj) ) {
		                  	// Le resultat a marché car pas de erreur dans obj!
		                  	//Le resultat est dans obj.result
		                    
		                      // Se connecter a la page indexcanlogogg
		      
								        location.reload();  
								
		                      
		                  }
		                  else {
		                      console.log(obj.error);
		                  }
		            }
		});

	}
</script>

<body>
	<th>
		<p>Welcome in the Book Base B&B!! Please click the log in button to open the database :</p>
	</th>
	<th>
		<button id="btnDB" onclick="dbCreate()" type="button" class="btn btn-success">DB | Log In</button>
	</th>
</body>