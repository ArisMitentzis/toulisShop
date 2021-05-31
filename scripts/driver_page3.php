<?php

    date_default_timezone_set('Europe/Athens') ;

    if (UserType::$userType == UserType::notAdmin || UserType::$userType == UserType::admin){
        
        // otan einai orismeno to $_GET['del'] - pou shmainei 
        // oti otan ston pinaka pou apeikonizetai to kalathi (sto page3.php)
        // exei paththei to koumpi 'diagrafh' se kapoia grammh.

        // H function sbhnei ena sugkekrimeno kwdiko proiontos apo to kalathi
        if (isset($_GET['del'])) {
        
            deleteRow($_GET['del']);
        }
        
        // otan einai orismeno to $_GET['edt'] - pou shmainei 
        // oti otan ston pinaka pou apeikonizetai to kalathi (sto page3.php)
        // exei paththei to koumpi 'edit' se kapoia grammh gia na parei thn nea posothta tou textbox pososthtas

        // H function allazei thn posothta se ena sugkekrimeno kwdiko proiontos sto kalathi
        if (isset($_POST['edt'])) {
        
            editRow($_POST['edt'],$_POST['newQuantity']);
        }
        
//        // na to allaksw edw -> kalutera na kalei thn assignAccountDetails
//        $currentExecQueryResultObject = fetchAccountDetails();
//       
//        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
//        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
//        if (! $currentExecQueryResultObject -> querySuccess || 
//            $currentExecQueryResultObject -> logicalCheck == ExecQueryResult::logicalError){ 
//            
//            die('driver_page3 -- tha kanw kati smarter soon edw!');
//        }
//        
//        // αφου εχουμε 0 ή 1 records
//        $userInfoResult = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        // fernei ola ta data tou sundedemenou user
        // kai ta anathetei stis antistoixa attributes ths UserType statikhs klashs
        // wste meta na mpoun sth forma ths diaxeirishs logariasmou (account.php)
        assignAccountDetails();
        
        // an o xrhsths exei pathsei to submit button sto page3.php (ypobolh paraggelias ousiastika), 
        // tote einai orismenh h metablhth $_POST['cartSubmit'] kai
        // kaleitai h function h opoia tha kataxwrhsei thn paraggelia kai tha kathariseito kalathi
        if (isset($_POST['cartSubmit'])) {
        
            $registerSuccess = registerOrder($_POST['shipment'],$_POST['payment'],$_POST['comment']);
        }
    }
?>