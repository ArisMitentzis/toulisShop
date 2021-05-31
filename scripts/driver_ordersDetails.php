<?php

     if (isset($_GET['orderCode'])) {
        
         $orderCode = $_GET['orderCode'];
     }
     else {
         
         $orderCode=-1;
     }

     if (isset($_GET['from'])) {
         
         if ($_GET['from']=='mine'){
             
             $returnButton='myOrders';
             $allFlag=false;
         }
         
         else {
         
            $returnButton='allOrders';
            $allFlag=true;
         } 
     }

     if (isset($_GET['for'])) {
         
         
         $for = str_replace("_"," ",$_GET['for']);
     }
    else{
        
        $for = '';
    }
         
?>