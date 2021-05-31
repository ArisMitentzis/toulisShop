<?php

    if (isset($_POST['createProduct'])){
        
       //$picDir = $_POST['prodPic'];
        
       //if ($picDir == '')
          // $picDir='none.jpg';
        
       // kalei back-end function - na to allaksw
       $successCreate = createProduct($_POST['prodName'],$_POST['typeCode'],$_POST['filePInput'],$_POST['prodStock'],$_POST['prodValue'],$_POST['prodDescription']);
    }  
    
?>