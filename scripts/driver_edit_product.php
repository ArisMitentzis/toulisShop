<?php

    if (isset($_POST['editProduct'])){
        
        // kalei thn back-end function editProduct - na to allaksw
       $successEdit = editProduct($_POST['prodCode'],$_POST['prodName'],$_POST['typeCode'],$_POST['filePInput'],$_POST['prodStock'],$_POST['prodValue'],$_POST['prodDescription']);
    }  
    elseif (UserType::$userType == UserType::admin && isset($_GET['act'])) {
        
        $actionId = substr($_GET['act'],3);
        
        //$selectedProduct = selectProduct($actionId);
        
        $currentExecQueryResultObject = selectProduct($actionId);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess || 
            $currentExecQueryResultObject -> logicalCheck == ExecQueryResult::logicalError){ 
            
            die('driver_edit_product -- tha kanw kati smarter soon edw!');
        }
        
        $selectedProduct = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
    }
?>