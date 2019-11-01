
<?php include("fct/createDBFcts.php");?>
<?php include("cmp/logDATAS.php");?>

<?php
    header('Content-Type: application/json');

    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function requested!'; }

    if( !isset($aResult['error']) ) { // Si on m'a bien fait une demande de fonction

        switch($_POST['functionname']) {
            case 'CreateMYDB':
                //On me demande de creer la base !

                $dbh = connexion_Server($host, $login, $password);
                create_Database($dbh, $base);
                create_ALL_Table($dbh,$base);
                $ultraVar = array();
                $ultraVar["db"] = TRUE;
                file_put_contents("ultraVar/DbUltraVar.json", json_encode($ultraVar));
                $aResult['result'] = "Done guy !";
               
               break;

            case 'DestroyMYDB':
                //On me demande de DESTROY la base !

                $dbh = connexion_Server($host, $login, $password);
                destroy_Database($dbh, $base);
                $ultraVar = array();
                $ultraVar["db"] = FALSE;
                file_put_contents("ultraVar/DbUltraVar.json", json_encode($ultraVar));
                $aResult['result'] = "Done guy !";
               
               break;

            default:
               $aResult['error'] = 'Not found function: '.$_POST['functionname'].' ! Please verify on your side.';
               break;
        }

    }

    echo json_encode($aResult);

?>

