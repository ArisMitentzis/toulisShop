<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_cortConnection.php" ?>


<?php
    if ($_GET['currentPage'] === 'allOrders'){

        echoAllOrders($_GET['page']);
    }
    elseif ($_GET['currentPage'] === 'list_delete_product'){

        echoAllProductsByCategoryAndName($_GET['page']);
    }
    elseif ($_GET['currentPage'] === 'allUsers'){

        echoAllUsersByLastName($_GET['page']);
    }
    elseif ($_GET['currentPage'] === 'myOrders'){

        echoMyOrdersById($_GET['page'],$_GET['userCode']);
    }
    
?>

<?php
    /*
    
    klhsh apo allOrders,list_delete_product,allUsers,myOrders --- se ola trexei to (pagination_allOrders.js)
    
    Otan o xrhsths pataei to koumpi "next" h "previous" sto pagination
    
    kaleitai o kwdikas pou ananewnei ton basiko pinaka
    
    */
?>