<?php  
    // Οι ημερομηνίες του current ευρους περνιούνται ως GET παράμετροι
    if (isset($_GET['xmlView']) and isset($_GET['frDt']) and isset($_GET['toDt'])){
        
        // αρχικά γίνεται ένας έλεγχος για το αν το ευρος των ημερομηνιών είναι valid
        // Θεωρώ πως η ημερομηνια frDt πρεπει να ειναι μικρότερη από την toDt
        // Δε θεωρώ valid το να είναι ίσες γιατί τοτε ουσιαστικά
        // μιλάμε για μηδενικό εύρος
        $frDtTimestamp = strtotime($_GET['frDt']); 
        $toDtTimestamp = strtotime($_GET['toDt']); 
    
        if ($frDtTimestamp >= $toDtTimestamp){
            
            $datesAreValid = false;
        } 
        else{
            
            $datesAreValid = true;
        }
    }

    // εφόσον το ευρος των ημερομηνιών είναι valid
    if ($datesAreValid){
        
        // κατασκευή του XML
        constructOrdersBetweenDatesAndTop5MostSalesProductsXML($_GET['frDt'],$_GET['toDt']);
    
        // Ελεγχος για το αν το XML είναι valid με βάση το σχετικό DTD file
        $XmlIsValid = checkXmlIsValid();

        if ($XmlIsValid){
            
        // υπολογίζονται 2 μεγέθη: 
        //                       - $quantityOfOrders = η ποσότητα των παραγγελιών του XML file
        //                       - $totalValueOfOrders = Η συνολική αξία όλων των παραγγελιών του XML file
            calcValuesAndGetDatesFromXML();
        }
    }
?>