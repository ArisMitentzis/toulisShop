<?php
    
    // an den einai orismenh h $_GET['type'], tote tha apeikonisei xwris filtrarisma ana kathgoria proiontos
    if (! isset($_GET['type'])){
         
        // kalei back-end function -- de moy aresei auto san design -na to allaksw
        $currentExecQueryResultObject = fetchAllProductsByIdDesc();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('driver_page2.php -- tha kanw kati smarter soon edw!');
        }
    
        // fernei ola ta products vasei prosfatothtas -> apo to pio prosfato sto pio palio
        $resultProducts = $currentExecQueryResultObject -> resultSet;
        
        $typeKey = null;
        $typeValue = null;
    }
    // an einai orismenh h $_GET['type'], tote tha apeikonisei me 
    // filtrarisma gia thn  kathgoria proiontos $_GET['type']
    else {
        
        // kalei back-end function -- de moy aresei auto san design -na to allaksw
        $currentExecQueryResultObject = fetchAllProductsByIdFilteredByCategory($_GET['type']);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('driver_page2.php -- tha kanw kati smarter soon edw!');
        }
        
        // fernei ola ta products vasei prosfatothtas (fitrarisma gia mia kathgoria) -> 
        // apo to pio prosfato sto pio palio
        $resultProducts = $currentExecQueryResultObject -> resultSet;
        
        $typeKey = 'type';
        $typeValue = $_GET['type'];
    }
    
    // plhthos proiontwn
    $totalNoOfProducts = mysqli_num_rows($resultProducts);
    
    // h max page (an spasw to result set twn proiontwn se 4-ades)
    // to indexing moy ksekina apo to 0 
    $maxPage = calcMaxPage($totalNoOfProducts,4);

    // An exei oristei h metablhth $_GET['page'] tote perna sth page
    // ton arithmo selidas pou thelw na apeikonisw sthn tetrada (ana prosfatothta)
    // an den exei oristei -> vale thn prwth selida (index=0)
    if (! isset($_GET['page'])){
        
        $page = 0;
    }
    else {
        
        $page = $_GET['page'];
    }

    $pagesKeyArray = [];
    $pagesKeyArray[0] = 'page';
    $pagesValueArray = [];
    $pagesValueArray[0] = $page;
    $currentUrl = 'page2.php';
    
    // orizontai sto prwto if-else
    //$typeKey = ;
    //$typeValue = ;
?>