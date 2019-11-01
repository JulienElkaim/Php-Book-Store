
<?php include("insertionFcts.php");?>

<?php
    header('Content-Type: application/json');

    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function requested!'; }

    if( !isset($aResult['error']) ) { // Si on m'a bien fait une demande de fonction

        include("logDATAS.php");
        $myServer = connect_Serv($host, $login, $password);
        switch($_POST['functionname']) {
            case 'InsertMano':
                if(isset($_POST['wtd'])){
                    
                    //$aResult['success'] = launchDBInsertion($myServer , $_POST['wtd']);
                    if(launchDBInsertion($myServer, $_POST['wtd'])){
                        // Reussi insert
                        $aResult['success'] = "OK ! Database : ".$_POST['wtd'][0].", Table : ".$_POST['wtd'][1]." updated.";
                    }else{
                        $aResult['error'] = 'I was unable to insert it in the database! Please verify your data type.';
                    }
                }else{
                    //On peut pas procéder a l'insert, on dit fuck
                    $aResult['error'] = 'I did not received the datas to process. I cant do my job and insert !';
                }
            
               
               break;
            case 'SupprMano':
                if(isset($_POST['wtd'])){

                    //$aResult['success'] = launchDBSuppr($base, $myServer, $_POST['wtd']);

                    if(launchDBSuppr($base,$myServer, $_POST['wtd'])){
                        // Reussi supprr
                        $aResult['success'] = "OK ! Database : ".$_POST['wtd'][0].", Table : ".$_POST['wtd'][1]." updated.";
                    }else{
                        $aResult['error'] = 'I was unable to delete it from the database! The error should be due to a foreign key constraint .';
                    }
                }else{  //On peut pas procéder a l'insert, on dit fuck
                    $aResult['error'] = 'Impossible to delete as I did not receied the datas !';
                }
                break;

            default:
               $aResult['error'] = 'Not found function: '.$_POST['functionname'].' ! Please verify on your side.';
               break;
        }

    }

    echo json_encode($aResult);

?>

