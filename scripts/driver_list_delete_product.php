<?php

    if (UserType::$userType == UserType::admin && isset($_GET['act'])){
        
        $actionId = substr($_GET['act'],3);
        
        // καλεί την back-end function deleteProduct -- na to allaksw
        $successfulDelete = deleteProduct($actionId);
    }  

?>

<?php

    //$ordersCount = getNumOfAllOrders(); 

    $currentExecQueryResultObject = getNumOfAllProducts();
       
    // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
    // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
    if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function driver_all_orders -- tha kanw kati smarter soon edw!');
    }
    
    $productsCount = $currentExecQueryResultObject -> numericResult;

    // h max page (an spasw to result set twn proiontwn se 4-ades)
    // to indexing moy ksekina apo to 0 
    $maxPage = calcMaxPage($productsCount,10);

    if (! isset($_GET['page'])){
        
        $page=0;
    }
    else {
        
        $page=$_GET['page'];
    }
    
    // oi variables pou xrhsimopoiountai sth function gia to pagination
    $pagesKeyArray = [];
    $pagesKeyArray[0] = 'page';
    $pagesValueArray = [];
    $pagesValueArray[0] = $page;
    $currentUrl = 'list_delete_product.php';
    $typeKey = null;
    $typeValue = null;
?>