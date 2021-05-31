<?php

    $userCode = UserType::$userCode;

    //$ordersCount = getNumOfAllOrders(); 

    $currentExecQueryResultObject = getNumOfAllOrders($userCode);
       
    // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
    // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
    if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function driver_all_orders -- tha kanw kati smarter soon edw!');
    }
    
    $ordersCount = $currentExecQueryResultObject -> numericResult;

    // h max page (an spasw to result set twn proiontwn se 4-ades)
    // to indexing moy ksekina apo to 0 
    $maxPage = calcMaxPage($ordersCount,10);

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
    $currentUrl = 'myOrders.php';
    $typeKey = null;
    $typeValue = null;
?>