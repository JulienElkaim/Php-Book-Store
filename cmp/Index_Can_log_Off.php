<script type="text/javascript">
	
	function dbDestroy()
	{
		jQuery.ajax({
		    type: "POST",
		    url: 'DB.php',
		    dataType: 'json',
		    data: {functionname: 'DestroyMYDB'},

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

<th>
<button id="btnDB" onclick="dbDestroy()" type="button" class="btn btn-danger">DB | Log Off</button> 
</th>