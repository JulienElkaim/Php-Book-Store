<?php
	session_start();
	session_unset();
	session_destroy();
?>
<?php include("fct/DisplayErrors.php");?>
<?php include("fct/logDATAS.php");?>

<?php
	$strJsonFileContents = file_get_contents("ultraVar/DbUltraVar.json");
	// Convert json to array
	$DbUltraVar = json_decode($strJsonFileContents, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>B&B | Book Base</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style_format/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

<table class="Functionalities" cellspacing="10">
  <tr>
	<?php
	global $DbUltraVar;
		if (isset($DbUltraVar["db"])){
			if ($DbUltraVar["db"]){
				//It exists !
				include ("cmp/tablechoice.php");
				include ("cmp/requetebtn.php");
				include ("cmp/insertion.php");
				include ("cmp/Index_Can_log_Off.php");
				
			}else{
				//It doesn't exists !
				include ("cmp/Index_Have_To_Log_On.php");
			}
		}else{
			//Première ouvertur de la page
			include ("cmp/Index_Have_To_Log_On.php");

		}
	?>
  </tr>
</table>

</div>
<div class ="tableDisplayer">
	<?php 
		if (isset($_POST["tableChoiceIndex"]) )
			{include ("cmp/tabledisplayer.php");} 
	?>
</div>

</body>
</html>