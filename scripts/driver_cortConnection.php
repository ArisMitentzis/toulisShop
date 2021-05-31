
<?php cortDrive();?>


<?php
//    
//    if (!isset($_SESSION['cortTable'])){
//        
//        $_SESSION['cortTable']=[];
//    }
//
//    for ($i=0;$i<4;$i++){
//        
//        if (isset($_POST['btnPr_' . $i])){
//            
//            $product=["prodCode"=>$_POST['prodCode_' . $i],
//                      "quantity"=>$_POST['quantity_' . $i],
//                      "prodValue"=>$_POST['prodValue_' . $i],
//                      "deleted" => false
//                     ];
//        }
//    }
//
//    if (isset($product)){
//        echo "yes ";
//    }
//    else{
//        echo "no";
//    }
//
//    if (isset($product)){
//        
////        $_SESSION['cortTable'][0]=$product;
////        print_r($_SESSION['cortTable'][0]);
//        
//        $found=false;
//        $nextIndex = count($_SESSION['cortTable']);
//        
//        for($i=0;$i<$nextIndex;$i++){
//            
//            if ($_SESSION['cortTable'][$i]['prodCode'] == $product['prodCode']){
//                
//                if ($product['quantity'] != 0){
//                    
//                    $_SESSION['cortTable'][$i]['quantity'] = $product['quantity'];
//                    $_SESSION['cortTable'][$i]['deleted'] = false;
//                }
//                
//                else {
//                    
//                    //unset($_SESSION['cortTable'][$i]);
//                    //$_SESSION['cortTable'] = array_values($_SESSION['cortTable']);
//                    
//                    $_SESSION['cortTable'][$i]['deleted'] = true;
//                }
//                
//                $found=true;
//            }
//        }
//        
//        if ($found==false && ($product['quantity']!=0)){
//            
//            
//            $_SESSION['cortTable'][$nextIndex]=$product;
//        } 
//    }
//
//    //testing
////        foreach($_SESSION['cortTable'] as $currentProduct){
////            
////            
////            print_r($currentProduct);
////        }
//    print_r ($_SESSION['cortTable']);
?>