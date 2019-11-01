<?php include("fct/DisplayErrors.php");?>
<?php include("fct/logDATAS.php");?>
<?php include ("fct/insertionFcts.php");?>

<?php
	$strJsonFileContents = file_get_contents("ultraVar/DbUltraVar.json");
	// Convert json to array
	$DbUltraVar = json_decode($strJsonFileContents, true);

	//Make choice persistant when reloading the page
	session_start();
	if(!isset($_POST["tableChoiceIndex"])){
		//Pas de table deja choisie
		if(isset($_SESSION['tableChoiceIndex'])){
			$_POST["tableChoiceIndex"] = $_SESSION['tableChoiceIndex'];
		}

	}else{
		$_SESSION['tableChoiceIndex'] = $_POST["tableChoiceIndex"];
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>B&B | Insertion</title>
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
				echo '<table class="InsertBasic">';
					include ("cmp/tablechoice.php");
					include("cmp/indexcomeback.php");
				echo "</table>";
			}else{
				//It doesn't exists !
				echo 'It seems that you erased DbUltraVar.json from ultraVar folder. Please download back the zip file and keep the DbUltraVar file.';
			}
		}else{
			//Db not existing according to DbUltraVar.json
			echo '<p> Please create the database before inserting anything. <a href ="index.php">Click here.</a></p>';
			

		}
	?>
  </tr>
</table>
<table class="InsertInterfaces" cellspacing="10">
	<tr>
		<?php 
				if (isset($_POST["tableChoiceIndex"]) )
				{

					echo '<h2> Insertion par CSV :';
					echo '<table>';
					include ("cmp/insertCSV.php");
					echo "</table>";

					echo '<h2> Insertion/Modification :</h2>';
					echo '<table>';
					echo '<tr>';
					include ("cmp/insertMANUAL.php");
					echo '</tr>';
					echo "</table>";
				} 
		?>
	</tr>
</table>



</div>
<div class ="tableDisplayer">
	<?php 
		if (isset($_POST["tableChoiceIndex"]) )
			{
				include ("cmp/tabledisplayerINSERTION.php");
			} 
	?>
</div>

</body>
</html>