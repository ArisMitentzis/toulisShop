<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php
        
    //Καλείται η backend function initiateDB() που αρχικοποιει τη DB
            
    $success = initiateDB();  
    echo $success;
?>