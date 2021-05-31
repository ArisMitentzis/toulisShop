<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php
        
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
        
?>