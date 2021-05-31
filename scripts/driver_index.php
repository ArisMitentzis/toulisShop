<?php 
    
    // kalei back-end function -- de moy aresei auto san design -na to allaksw
    $currentExecQueryResultObject = fetchAllProductsByIdDesc();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('driver_index -- tha kanw kati smarter soon edw!');
        }
    
    // fernei ola ta products vasei prosfatothtas -> apo to pio prosfato sto pio palio
    $resultLastProducts = $currentExecQueryResultObject -> resultSet;

    // kalei back-end function -- de moy aresei auto san design -na to allaksw
    $currentExecQueryResultObject = fetchAllProductsBySalesDesc();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('driver_index -- tha kanw kati smarter soon edw!');
        }
    
    // fernei ola ta products vasei pwlhsewn desc -> apo to pio eupwlhto sto ligotero eupwlhto
    $resultPopProducts = $currentExecQueryResultObject -> resultSet;

    // plhthos proiontwn
    $totalNoOfProducts = mysqli_num_rows($resultLastProducts);

    // h max page (an spasw to result set twn proiontwn se 3-ades) -- to max page koino gia ta $resultLastProducts kai $resultPopProducts
    // to indexing moy ksekina apo to 0 
    $maxPage = calcMaxPage($totalNoOfProducts,3);

    // An exei oristei h metablhth $_GET['last_page'] tote perna sth $lastPage
    // ton arithmo selidas pou thelw na apeikonisw sthn panw triada (ana prosfatothta)
    // an den exei oristei -> vale thn prwth selida (index=0)
    if (! isset($_GET['last_page'])){
        
        $lastPage = 0;
    }
    else {
        
        $lastPage = $_GET['last_page'];
    }
    
    // An exei oristei h metablhth $_GET['pop_page'] tote perna sth $popPage
    // ton arithmo selidas pou thelw na apeikonisw sthn katw triada (ana dhmotikothta)
    // an den exei oristei -> vale thn prwth selida (index=0)
    if (! isset($_GET['pop_page'])){
        
        $popPage = 0;
    }
    else {
        
        $popPage = $_GET['pop_page'];
    }

    // oi variables pou xrhsimopoiountai sth function gia to pagination
    $pagesKeyArray = [];
    $pagesKeyArray[0] = 'last_page';
    $pagesKeyArray[1] = 'pop_page';
    $pagesValueArray = [];
    $pagesValueArray[0] = $lastPage;
    $pagesValueArray[1] = $popPage;
    $currentUrl = 'index.php';
    $typeKey = null;
    $typeValue = null;
?>