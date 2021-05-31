<?php $root = __DIR__ . "/../"; ?>

<?php include $root . "functions_and_classes\\controller_functions.php" ?>
<?php include $root . "functions_and_classes\\back_end_functions.php" ?>
<?php include $root . "functions_and_classes\\front_end_functions.php" ?>
<?php include $root . "functions_and_classes\\classes.php" ?>

<?php include $root . "scripts\\connect_to_db.php" ?>

<?php
    /*
    Kaleitai apo ta pagination.js,filter.js ma ajax call

    Sta index kai page2 (pagination.js):
    Kata th xrhsh, otan sta pagination twn proiontwn pathsei o xrhsths 
    to koumpi "previous" h "next" ananewnontai oi vitrines me ta proionta.
    Apo to index dinontai oi GET metablhtes 
        -> last_page: afora klik sta prosfata proionta - exei ws value to neo index
        -> pop_page:afora klik sta dhmofilh proionta - exei ws value to neo index
    Apo to page2 dinontai oi GET metablhtes 
        -> page: exei ws value to neo index
        -> type: exei ws value ton typo ton opoio vlepei o xrhsths (den exei oristei otan  exei epileksei "ola")

    Mono sto page2 (filter.js):
    Kata th xrhsh, otan sth lista me tous typous proiontwn, klikarei o xrhsths 
    kapoion typo, ananewnontai oi vitrines me ta proionta (emfanizetai h to prwto index vitrinas me proionta tou epilegmenou typoy).
    Dinontai oi GET metablhtes 
        -> page: exei ws value to neo index -> edw einai panta to 0 (1h selida proiontwn)
        -> type: exei ws value ton typo ton opoio molis epelekse o xrhsths (den exei oristei otan exei epileksei "ola")
    
    Ayto to arxeio, ypologizei kai epistrefei se morfh json
    ta info twn products ths epomenhs emfanishs se kapoia vitrina kai sthn 
    opoia exei zhththei apo ton xrhsth

    Pio sygkekrimena dhmiourgeitai enas pinakas pou se kathe thesh toy
    periexei enan assoc array me ta info tou proiontos ths sugkekrimenhs theshs
    kai sth synexeia metatrepetai se JSON
    */
?>

<?php 
    
    // krataei to posa proionta periexei kathe row me vitrines
    // sto index: kai ta last kai ta pop sxhmatizoyn 3-ades
    // sto page2: sxhmatizoyn 4-ada
    $grouping = 3;
    
    // an afora ploghsh sta prosfata proionta (index)
    if (isset($_GET['last_page'])){
        
        $currentExecQueryResultObject = fetchAllProductsByIdDesc();
        $page = $_GET['last_page'];
    }
    // an afora ploghsh sta dhmofilh proionta (index)
    elseif (isset($_GET['pop_page'])){
        
        $currentExecQueryResultObject = fetchAllProductsBySalesDesc();
        $page = $_GET['pop_page'];
    }
    // an afora ploghsh sta proionta ana typo (page2)
    elseif (isset($_GET['page'])){
        
    // krataei to posa proionta periexei kathe row me vitrines
    // sto index: kai ta last kai ta pop sxhmatizoyn 3-ades
    // sto page2: sxhmatizoyn 4-ada
         $grouping = 4;
        
        // an den exei epilegei to "Ola" - opote exei epileksei sygkekrimeno typo
        if (isset($_GET['type'])){
            
            $currentExecQueryResultObject = fetchAllProductsByIdFilteredByCategory($_GET['type']);
        }
        else{
            
            $currentExecQueryResultObject = fetchAllProductsByIdDesc();
        }
        
        
        $page = $_GET['page'];
    }

        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('driver_index -- tha kanw kati smarter soon edw!');
        }
    
    $resultProducts = $currentExecQueryResultObject -> resultSet;

    // pinakas ston opoio tha mpoun ta proionta
    $products = [];
    
    // o poionter ths diatrekshs topotheteitai sto katallhlo index gia th zhtoymenh selida
    mysqli_data_seek($resultProducts,($page * $grouping));
            
    // diatreksh kai dhmiourgia assoc array pou periexei tis info tou trexontos product
    for($counter = 0; $counter < $grouping; $counter++){
                    
            if ($row = mysqli_fetch_assoc($resultProducts)){
                        
                $products[] = [
                                "prodcode" => $row['PRODCODE'],
                                "prodname" => $row['PRODNAME'],
                                "proddescription" => $row['PRODDESCRIPTION'],
                                "prodpic" => $row['PRODPIC'],
                                "prodvalue" => $row['PRODVALUE'],
                                "prodstock" => $row['PRODSTOCK'],
                                "quantity" => getQuantityOfSpecificProdCodeCart($row['PRODCODE'])
                              ];
            }
        // an den yparxei row, vale to string 'empty' gia na mpei empty vitrina kata thn typwsh apo to katallhlo js scriptaki
            else{
                $products[] = 'empty';
                }
    }
    // typwse to ws JSON
    echo json_encode($products);
?>