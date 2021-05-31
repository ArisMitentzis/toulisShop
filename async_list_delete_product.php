<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php
        
    // otan einai orismeno to $_GET['del'] - pou shmainei 
    // oti otan ston pinaka pou apeikonizontai ta proionta (sto list_delete_product.php)
    // exei paththei to koumpi 'diagrafh' se kapoia grammh.

    // H function sbhnei ena sugkekrimeno kwdiko proiontos apo ton DB pinaka PRODUCTS
    if (isset($_GET['del'])) {
        
        deleteProduct($_GET['del']);
    }
        
?>