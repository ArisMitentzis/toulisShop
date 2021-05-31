<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php
      
    
    //echo 'paok';
   
    if (isset($_GET['orderCode']) && isset($_GET['newState']) && isset($_GET['oldState'])) {
        
       // echo 'paok@@';
        
        
       $currentOrderCode =$_GET['orderCode'];
       $currentNewState =$_GET['newState'];
       $currentOldState =$_GET['oldState'];
        
        //echo $currentOrderCode;
        //echo '@@';
        //echo $currentNewState;
        //echo '@@';
        //echo $currentOldState;
        //echo '<br><br><br>';
        
    
       $currentExecQueryResultObject = MySpecificOrderDetails($currentOrderCode);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoMySpecificOrderDetails -- tha kanw kati smarter soon edw!');
        }
        
        if($currentNewState == 3 && $currentOldState < 3){
            
            //echo 'aek@@';
        
            while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
        
                $currentProdcode = $row['PRODCODE_FK'];
                $currentProdQuantity = $row['PRODQUANTITY'];
                $currentOrderProdStock = $row['PRODSTOCK'];
            
                if ($currentProdQuantity > $currentOrderProdStock){
                
                    echo 'false';
                    return;
                 }
             }
             
             updateStockProductsOfOrder($currentOrderCode);
             
        }
        updateOrderState($currentOrderCode,$currentNewState);
                 
        echo 'true';
    }
?>