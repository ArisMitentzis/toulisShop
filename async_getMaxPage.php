<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php // include "scripts\\driver.php" ?>

<?php
    /*
    kaleitai apo to filters.js - page2
    
    epistrefei enan arithmo, opoios einai to neo max index gia tis
    vitrines tou epilegmenou neou typou proiontos apo to xrhsth.
    
    O kwdikos toy typou proiontos perneitai GET metablhth 'type'.
    An exei epilexthei to "ola", tote to value einai -1 
    */
?>

<?php 
    
    $typeCode = $_GET['type'];
    
    // an exei epilexthei to "ola"
    if ($typeCode != -1){
            
        $currentExecQueryResultObject = fetchAllProductsByIdFilteredByCategory($typeCode);
    }
    // an exei epilexthei sygkekrimenos typos proioontos
    else{
            
        $currentExecQueryResultObject = fetchAllProductsByIdDesc();
    }
        
    // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
    // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
    if (! $currentExecQueryResultObject -> querySuccess ){ 
            
        die('driver_index -- tha kanw kati smarter soon edw!');
    }
    
    $resultProducts = $currentExecQueryResultObject -> resultSet;

    // plhthos proiontwn
    $totalNoOfProducts = mysqli_num_rows($resultProducts);

    // h max page (an spasw to result set twn proiontwn se 4-ades) 
    // to indexing moy ksekina apo to 0 
   $maxPage = calcMaxPage($totalNoOfProducts,4);

    echo $maxPage;
?>