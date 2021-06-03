
<?php
    // καλειται μόνο στο driver_i που γίνεται include μονο στο index.php.
    // 
    // Σημ: Ο συνδεσμος logout, στέλνει πάντα στο index.php (από όποια σελιδα
    // και αν πατηθεί)
    // Σβηνει όλα τα data του χρήστη που ήταν signed in 
    // από το SESSION και από τη static (ως χρηση) κλαση UserType 

    function logOut(){
        
        // typika stelnw value=1 - δεν παιζει καποιο ρολο
        
            
        // katharizontai oles oi session metablites
            
        $_SESSION['userType'] = UserType::notLogged;
        $_SESSION['userCode'] = -1;
        $_SESSION['userFirst'] = "";
        $_SESSION['userLast'] = "";
            
        $_SESSION['cortTable']=[];
            
        // katharizontai oles ta attributes ths static klashs UserType
            
        UserType::$userType = UserType::notLogged;
        UserType::$userCode = -1;
        UserType::$userFirst = "";
        UserType::$userLast = "";
            
        UserType::$userEmail = "";
        UserType::$userAdress = "";
        UserType::$userTk = "";
        UserType::$userCity = "";
        UserType::$userNomos = "";
        UserType::$userBirthdate = "";     
    }
?>

<?php
    // καλειται μόνο στο driver_i που γίνεται include μονο στο index.php.
    // ελεγχει αν ειναι ορισμενη η μεταβλητή $_POST['loginButton'].
    // Σημ: To submit button του sign_in.php, στέλνει στο index.php 
    // Αν ειναι ορισμενη η $_POST['loginButton'], τότε φροντιζει 
    // για το signing in kai to staying signed in
    // SOS -> h function epistrefei true mono se epituxhmeno loggin
    // Αν δεν εχει πατηθεί loggin  
    // ή αν έχει δoθεί λάθος email (UserType::$wrongEmailAttempt = true)
    // ή αν έχει δoθεί λάθος κωδικός (UserType::$wrongPasswordAttempt = true),
    // επιστρέφεται false.
      
    function logInSubmit(){
        
        UserType::$wrongEmailAttempt = false;
        UserType::$wrongPasswordAttempt = false;
        
        // αν αυτη δεν ειναι ορισμενη, σημαίνει ότι το ανοιγμα της σελίδας index.php
        // δεν ηταν αποτελεσμα πατηματος του κουμπιου submit 
        // στη φόρμα sign_in. Αν συμβαίνει αυτό επιστρέφει false.
//        if (! isset($_POST['loginButton'])){
//            
//            return false;
//        }
        
        // κραταει εδω οτι περαστηκε ως post μεταβλητη
        $userEmail = $_POST['userEmail'];
        $userPassword = $_POST['userPassword'];
        
        // queries the DB για την υπαρξη record με where το email που δοθηκε ως post παραμετρος
        $currentExecQueryResultObject = fetchUser($userEmail);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess || 
            $currentExecQueryResultObject -> logicalCheck == ExecQueryResult::logicalError){ 
            
            die('function checkForLogInSubmit -- tha kanw kati smarter soon edw!');
        }
        
        // αφου εχουμε 0 ή 1 records
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        // αν κανένα record, δεν υπαρχει χρηστης με αυτο το email στη DB μας
        // και για αυτο κανω true τo σχετικo attribute στη static κλαση UserType.
        if (! $row ){
                
            UserType::$wrongEmailAttempt = true;
        }
        // υπαρχει αυτός ο χρηστης, οποτε τσεκάρω με το password του.
        // αν είναι ο χρήστης δεν έδωσε το σωστο κωδικό κανω true τo 
        // σχετικo attribute στη static κλαση UserType.
        else if ($userPassword != $row['password']){
            
            UserType::$wrongPasswordAttempt = true;
        }
        
        // Έχουμε επιτυχημένο sign in
        // pairniountai times stis metablhtes kai toy session kai ths klashs UserType
        else{   
            
            if ($row['admin']){
                UserType::$userType = UserType::admin;
                
                $_SESSION['userType'] = UserType::admin;
            }
            else {
                UserType::$userType = UserType::notAdmin;
                $_SESSION['userType'] = UserType::notAdmin;
            }
                
            UserType::$userCode = $row['usercode'];
            UserType::$userFirst = $row['firstname'];
            UserType::$userLast = $row['lastname'];
            
            $_SESSION['userCode'] = $row['usercode'];
            $_SESSION['userFirst'] = $row['firstname'];
            $_SESSION['userLast'] = $row['lastname'];
        }
    }

    // καλειται και στο driver_i (γίνεται include μόνο στο index.php) και στο driver (γίνεται include σε όλα πλην του index.php).
    // Ελέγχει αν ο χρήστης είναι signed in - τσεκαρει SESSION μεταβλητες και περναει κάποια δεδομενα
    // του χρήστη και στα attributes ths static class UserType.

    function defineTypeOfCurrentUser(){
        
        // an den yparxei orismenh h sygkekrimenh session metablhth,
        // o xrhsths einai guest
        if (! isset($_SESSION['userType'])){
            
            UserType::$userType = UserType::notLogged;
        }
        // h an einai orismenh h sygkekrimenh metablhth kai h timh ths einai 0,
        // pali o xrhsths einai guest -- na dw pote mporei na sumbei auto. meta apo logout logika.
        else if ($_SESSION['userType'] == 0){
            
            UserType::$userType = UserType::notLogged;
        }
        // απλα τσεκαρει οτι θα εχω σωστες τιμες - λογικα δνε πεφτει ποτε εξω
        else if($_SESSION['userType'] != UserType::notAdmin && $_SESSION['userType'] != UserType::admin){
            
            die ($_SESSION['userType'] . " is not a valid value for session link parameter -> userType");
        }
        // αν μπει εδω, σημαινει ότι υπαρχει signed in user kai perniountai ta data tou 
        // sta attributes toy UserType
        else{
            
            UserType::$userType = $_SESSION['userType'];
            UserType::$userCode = $_SESSION['userCode'];
            UserType::$userFirst = $_SESSION['userFirst'];
            UserType::$userLast = $_SESSION['userLast'];
        }
    }
    
    // sos tha htan wraio na ginetai live me jquery to check gia to an yparxei hdh xrhsths
    // me ayto to email

    // καλειται απο το driver_sign_up.php
    // αν η $_POST['createUser'] είναι ορισμένη, τοτε σημαινει οτι 
    // υπαρχει αιτηση εγγραφης που πρεπει να καταχωρηθει - στο τελος επιστρεφει true 
    // Αλλιως δεν υπαρχει αιτηση εγγραφης και απλά επιστρεφει false.
    function register() {
        
        // αν δεν εχει οριστει η μεταβλητη αυτή, σημαινει οτι δεν εχει ανοίξει
        // η σελιδα εξαιτιας πατηματος του submit button που προκαλει 
        // νεα εγγραφή
        // και επιστρεφει false
//        if (!isset($_POST['createUser'])){
//        
//            return false;
//        }
        
        // elegxei gia to an yparxei hdh xrhsths me to email poy dwthike sthn aithsh
        // an yparxei, h global $emailAlreadyExists ginetai true
        // kai epistrefetai true
        $email = $_POST['email'];
        
        $currentExecQueryResultObject = checkEmailAlreadyExists($email);
        
        if (! $currentExecQueryResultObject -> querySuccess ||
                        $currentExecQueryResultObject -> logicalCheck == ExecQueryResult :: logicalError){
            
            die('function register -- tha kanw kati smarter soon edw!');
        }
        
        if ($currentExecQueryResultObject -> resultSetRows == 1){
            
            global $emailAlreadyExists;
            $emailAlreadyExists=true;
            
            return;
        }
        
        // alliws ginetai h kataxwrhsh tou neou user
        
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $adress = $_POST['adress'];
        $city = $_POST['city'];
        $nomos = $_POST['nomos'];
        $birthdate = $_POST['birthdate'];
        
        if (isset($_POST['tk']) && $_POST['tk'] != ('')){
            $tk = $_POST['tk'];
        }
        else{
            $tk = 0;
        }
            
        
        
        $success = registerUser($firstName,$lastName,$email,$mobile,$password,$adress,$tk,$city,$nomos,$birthdate);
        
        if (! $success){
            
            die('function register -- tha kanw kati smarter soon edw!');
        }
    }

    //sos -> edw den ananewnw tis session metablhtes -lathos - na to allaksw

    // καλειται απο το driver_account.php όταν ειναι ορισμενη η $_POST['update']
    // κανει update sta stoixeia tou logariasmou toy syndedemenou xrhsth
    function update() {
        
        $userCode = UserType::$userCode;
        
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        //$password = $_POST['password'];
        $adress = $_POST['adress'];
        $tk = $_POST['tk'];
        $city = $_POST['city'];
        $nomos = $_POST['nomos'];
        $birthdate = $_POST['birthdate'];
        
        //sos edw na to anadiamorfwsw gia thetikh kai arnhtikh anatrofodothsh
        
        $result = updateUser($userCode,$firstName,$lastName,$email,$mobile//,$password
                             ,$adress,$tk,$city,$nomos,$birthdate);
        
        if (! $result){
            
            die('function update -- tha kanw kati smarter soon edw!');
        }
    }

    // καλειται απο το driver_account.php όταν ειναι ορισμενη η $_POST['delete']
    // κανει delete to logariasmo toy syndedemenou xrhsth
    function delete() {
        
        $userCode = UserType::$userCode;
        
        $success = deleteUser($userCode);
        
        if (! $success){
            
            die('function delete -- tha kanw kati smarter soon edw!');
        }
        
        // katharizei kai tis session metablhtes
        
        $_SESSION['userType'] = UserType::notLogged;
        $_SESSION['userCode'] = -1;
        $_SESSION['userFirst'] = "";
        $_SESSION['userLast'] = "";
    }


    // sos na to valw na kaleitai kai apo to driver_page3, opou kakws kalei kateutheian
    // to fetchAccountDetails()

    // καλειται απο το driver_account.php (panta)
    // fernei ola ta data tou sundedemenou user
    // kai ta anathetei sta antistoixa attributes ths UserType statikhs klashs
    // wste meta na mpoun sth forma ths diaxeirishs logariasmou (account.php)
    function assignAccountDetails() {
        
        $currentExecQueryResultObject = fetchAccountDetails();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess || 
            $currentExecQueryResultObject -> logicalCheck == ExecQueryResult::logicalError){ 
            
            die('function assignAccountDetails -- tha kanw kati smarter soon edw!');
        }
        
        // αφου εχουμε 0 ή 1 records
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        if (isset($row['mobile'])){
            UserType::$userMobile = $row['mobile'];
        }
        if (isset($row['email'])){
            UserType::$userEmail = $row['email'];
        }
        if (isset($row['adress'])){
            UserType::$userAdress = $row['adress'];
        }
        if (isset($row['tk'])){
            UserType::$userTk = $row['tk'];
        }
        if (isset($row['city'])){
            UserType::$userCity = $row['city'];
        }
        if (isset($row['nomos'])){
            UserType::$userNomos = $row['nomos'];
        }
        if (isset($row['birthdate'])){
            UserType::$userBirthdate = $row['birthdate'];
        }
    }
?>

<?php
    // kaleitai sth front-end function echoProductBox()
    // epistrefei gia ena sugkekrimeno kwdiko proiontos, thn posothta  poy yparxei sto kalathi
    // sto kouti tou proiontos vazei thn timh poy uparxei sto kalathi

    function getQuantityOfSpecificProdCodeCart($currentProdCode){
        
        foreach($_SESSION['cortTable'] as $currentProduct){
            
            if ($currentProduct['prodCode'] == $currentProdCode and $currentProduct['deleted'] == false) {
                
                return $currentProduct['quantity'];
            }
        }
        return 0;
    }
?>

<?php
    // pleon kaleitai apo to onclick ths cortBuy.js (sto koumpi kalathiou)
    // kai apotrepetai me preventDefault h epanafortwsei ths selidas (submit koumpi)

    // kaleitai apo to driver_cortConnection pou ginetai include sta
    // index.php kai page2.php (einai oi 2 selides apo tis opoies
    // mporei o xrhsths na prosthesei proionta sto session kalathi ($_SESSION['cortTable']))
    // To $_SESSION['cortTable'] einai enas pinakas poy periexei allous pinakes.
    // Oi mesa pinakes anaparistoun ta proionta (sthles einai oi idiothtes twn proiontwn)
    // O eksw pinakas einai to kalathi

    // exoyn ginei allages se deutero xrono 2020-08-30
    // arxika me POST apo thn php otan etrexe h synarthsh, yphrxe h plhroforia
    // mono enos proiontos (autou poy paththike to koumpi).
    // Pleon, oles oi vitrines exoun ndiaforetiko id kai fortwnontai oles
    // opote eginan kai kapoies mikroallages sth function
    function cortDrive(){
        
        // an o xrhsths einai guest (mh syndedemenos): vale sth $_SESSION['cortTable'] ena keno pinaka
        // kai kane return
        if (UserType::$userType != UserType::notAdmin && UserType::$userType != UserType::admin){
        
            $_SESSION['cortTable']=[];
        
            return;
        }
        
        // an den einai orismenh h $_SESSION['cortTable'], arxikopoihsete thn me keno pinaka
        if (! isset($_SESSION['cortTable'])){
        
            $_SESSION['cortTable']=[];
        }
        
        // ta koumpia kalathiou exoyn html name btnPr_i,opou i anhkei [0,1,2,3]. h arithmish
        // mpainei apo aristera pros deksia. Antistoixa einai ta name twn allwn elements
        // ths kathe formas
        // etsi diatrexontai ola ta parathira proiontwn - tsekarete an to post aforouse auta
        // kai sth synexeia diatrexontai ola ta elements ths formas kai kataxwroyntai 
        // ston pinaka me onoma $product
        // Se kathe anoigma selidas me koumpi submit kalathiou, mono ena apo ta $_POST['btnPr_' . $i]
        // tha einai orismeno
        // Opote se kathe anoigma ths selidas, an den einai guest o xrhsths
        // tha dhmiourghthei 0 h 1 $product
        
        $products =[];
        
        for ($i=0;$i<6;$i++){
        
//            if (isset($_POST['btnPr_' . $i])){
            if (isset($_POST['prodCode_' . $i])){
            
                $product = ["prodCode"=>$_POST['prodCode_' . $i],
                            "quantity"=>$_POST['quantity_' . $i],
                            "prodValue"=>$_POST['prodValue_' . $i],
                            "deleted" => false, // auto exei mpei gia thn periptwsh pou kapoio proion
                                                // pou exei mpei sto kalathi, mhdenistei h posothta toy
                            "prodName" => $_POST['prodName_' . $i],
                            "prodStock" => $_POST['prodStock_' . $i]
                           ];
                
                $products [] = $product;
            }
        }

        //print_r($products);
        
        
        
//        if (isset($product)){
//            //echo "yes ";
//        }
//        else{
//            //echo "no";
//        }

        // an dhmiourghthike ena proion
        foreach ($products as $product){
        
            // arxika tha psaksei an o sugkekrimenos kwdikos proiontos
            // uparxei ston pinaka $_SESSION['cortTable']
            
            // an yparxei, 
            // tote an to $product['quantity'] einai 0, tha kanei to deleted bit true, enw
            // an to $product['quantity'] einai <> tou 0, tha kanei to deleted bit false kai tha 
            // thesei to $_SESSION['cortTable'][$i]['quantity'] = $product['quantity']
            
            $found=false;
            $nextIndex = count($_SESSION['cortTable']);
        
            for($i=0;$i<$nextIndex;$i++){
            
                if ($_SESSION['cortTable'][$i]['prodCode'] == $product['prodCode']){
                    
                    if ($product['quantity'] != 0){
                    
                        $_SESSION['cortTable'][$i]['quantity'] = $product['quantity'];
                        $_SESSION['cortTable'][$i]['deleted'] = false;
                    }
                
                    else {
                    
                        //unset($_SESSION['cortTable'][$i]);
                        //$_SESSION['cortTable'] = array_values($_SESSION['cortTable']);
                    
                        $_SESSION['cortTable'][$i]['deleted'] = true;
                    }
                
                $found=true;
                }
            }
        
            // an den yparxei o sugkekrimenos kwdikos proiontos
            // ston pinaka $_SESSION['cortTable'] kai to $product['quantity']!=0
            // tote vale ston pinaka $_SESSION['cortTable'], ws epomeno element
            // ton pinaka $product
            
            if ($found==false && ($product['quantity']!=0)){
            
                $_SESSION['cortTable'][$nextIndex]=$product;
            } 
        }
    }
?>

<?php 
    // kaleitai apo thn controller function registerOrder() -- pou kataxwrei kapoia paraggelia
    // kai apo th front-end function echoCartMessage() - pou tupwnei to mhnuma tou kalathiou

    // An dothei orisma = 1, epistrefei thn posothta twn proiontwn (se temaxia) tou kalathiou
    // Enw an dothei orisma <> 1 (2 vazw egw), epistrefei thn aksia ths agoras twn proiontwn tou kalathiou
    function calcCartHeadAmountOrValue($amountOrValue){
        
        $sum=0;
        
        foreach($_SESSION['cortTable'] as $currentProduct){
            
            if ($currentProduct['deleted'] == 0){
                
                if ($amountOrValue == 1){
            
                    $sum += $currentProduct['quantity'];
                }
                else{
            
                    $sum += $currentProduct['quantity'] * $currentProduct['prodValue'];
                }
            }
        }
        return $sum;
    }
?>


<?php
    // kaleitai sto driver_page3.php, otan einai orismeno to $_GET['del'] - pou shmainei 
    // oti otan ston pinaka pou apeikonizetai to kalathi (sto page3.php)
    // exei paththei to koumpi 'diagrafh' se kapoia grammh.

    // H function sbhnei ena sugkekrimeno kwdiko proiontos apo to kalathi
    function deleteRow($delProdCode) {
        
        $length = count($_SESSION['cortTable']);
        
        for($i=0;$i<$length;$i++){
            
            if ($_SESSION['cortTable'][$i]['prodCode'] == $delProdCode){
                
                $_SESSION['cortTable'][$i]['deleted'] = 1;
            }
        }
    }
?>

<?php
    // kaleitai sto driver_page3.php, otan einai orismeno to $_GET['edt'] - pou shmainei 
    // oti otan ston pinaka pou apeikonizetai to kalathi (sto page3.php)
    // exei paththei to koumpi 'edit' se kapoia grammh gia na parei thn nea posothta tou textbox pososthtas

    // H function allazei thn posothta se ena sugkekrimeno kwdiko proiontos sto kalathi
    function editRow($editProdCode,$quantity){
    
        $length = count($_SESSION['cortTable']);
        
        for($i=0;$i<$length;$i++){
            
            if ($_SESSION['cortTable'][$i]['prodCode'] == $editProdCode){
                
                $_SESSION['cortTable'][$i]['quantity'] = $quantity;
            }
        } 
    }
    
?>

<?php
    // kaleitai apo to statistics.php
    // epistrefei to tziro hmeras/evdomadas/mhna (parametroi 'today','week','month')
    
    function getTurnOver($case){
    
        $currentExecQueryResultObject = calcTurnOver($case);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function getTurnOver -- tha kanw kati smarter soon edw!');
        }
        
        return $currentExecQueryResultObject -> numericResult;
    }
    
?>

<?php
    // kaleitai apo to driver_page3.php

    // an o xrhsths exei pathsei to submit button sto page3.php (ypobolh paraggelias ousiastika), 
    // tote einai orismenh h metablhth $_POST['cartSubmit'] 

    // kataxwrei thn paraggelia tou xrhsth opws exei diamorfwthei sto kalathi
    // kai sto telos katharizei to kalathi

    function registerOrder($shipment_id,$payment_id,$comment){
        
        //global $connection;
        
        $userCode = UserType::$userCode;
        $now = date("Y-m-d H:i:s");
        $totalAmount = calcCartHeadAmountOrValue(1);
        $totalValue = calcCartHeadAmountOrValue(2);
        
        // kataxwrei to head ths paraggelias
        $currentExecQueryResultObject = insertOrdersHead($userCode,$now,$totalAmount,$totalValue,$shipment_id,$payment_id,$comment);
        
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function registerOrder -- tha kanw kati smarter soon edw!');
        }
        
        // pairnei to identity pedio ths eggrafhs tou head pou molis kataxwrithike
        $currentOrderCode = $currentExecQueryResultObject -> numericResult;
           
        // kataxwrei ta epimerous proionta ths paraggelias apo to kalathi
        // dinontas kai to identity pedio tou head
        foreach($_SESSION['cortTable'] as $currentProduct){
            
            if ($currentProduct['deleted'] == 0){
                
                $currentValue = $currentProduct['quantity'] * $currentProduct['prodValue'];
                $currentProdCode = $currentProduct['prodCode'];
                $currentQuantity = $currentProduct['quantity'];
                
                $success = insertOrdersDetail($currentOrderCode,$currentProdCode,$currentQuantity,$currentValue);
                
                if (! $success ){ 
            
                    //die('function registerOrder -- tha kanw kati smarter soon edw!');
                    return false;
                }
            }
        }
        
        // telos katharizei to kalathi
        $_SESSION['cortTable']=[];
        
        return true;
    }
?>

<?php 
    // kaleitai apo index.php,page2.php,allOrders.php

    // Ypologizei to max dynato page sto current pagination
    // pairnei ws parametroys to plhthos twn proiontwn tou result set kai ton arithmo twn 
    // productBoxes ana vitrina
    
    function calcMaxPage($totalNoOfProducts,$noOfProductBoxesPerPage){

        // h max page (an spasw to result set twn proiontwn se 3-ades)
        // to indexing moy ksekina apo to 0 
        $maxPage = (floor($totalNoOfProducts / $noOfProductBoxesPerPage)) - 1;
    
        // to plhthos twn proiontwn sthn teleutai selida
        $numberOfProductsInLastPage = $totalNoOfProducts % $noOfProductBoxesPerPage;
    
        // an sto telos tou result set exw ypoloipo, exw allh mia skarth selida
        if ($numberOfProductsInLastPage > 0){
        
            $maxPage = $maxPage + 1;
        }
        
        return $maxPage;
    }
?>

<?php
    // kaleitai apo to driver_add_product
    function createProduct ($prodName,$typeCode,$prodPic,$prodStock,$prodValue,
                         $prodDescription){
        
        return insertProduct ($prodName,$typeCode,$prodPic,$prodStock,$prodValue,
                         $prodDescription);
    }
?>

<?php
    // καλείται στο driver_xml_view

    // Κατασκευάζει το ζητούμενο XML
    // το όνομα του κατασκευασμένου XML file ειναι allOrdersAndTop5SalesProducts + ημερομηνια και ώρα
    // αποθηκεύεται στο φάκελο XML
    function constructOrdersBetweenDatesAndTop5MostSalesProductsXML($frDt,$toDt){
        
        $DOMImplementationObject = new DOMImplementation;
        
        // προσθήκη αναφοράς του dtd file στο xml file.
        $myDtd = $DOMImplementationObject->createDocumentType('aboutOrders', '', 'aboutOrders.dtd');
        
        $domdcObject = $DOMImplementationObject->createDocument("", "", $myDtd);
        
        // κατασκευή του root node
        $totalRtNd = $domdcObject -> appendChild($domdcObject -> createElement('aboutOrders'));
        
        // προσθήκη attribute στον root node
        $frDtAttribute = $domdcObject->createAttribute('dateFrom');

        $date=date_create($frDt);
        $frDtAttribute->value = date_format($date,"d-m-Y");//$frDt;

        $totalRtNd->appendChild($frDtAttribute);
        
        // προσθήκη attribute στον root node
        $toDtAttribute = $domdcObject->createAttribute('dateTo');

        $date=date_create($toDt);
        $toDtAttribute->value = date_format($date,"d-m-Y");//$toDt;

        $totalRtNd->appendChild($toDtAttribute);
        
        // προσθήκη του node allOrders και κατασκευή του εσωτερικού του
        $rtNd = $totalRtNd -> appendChild($domdcObject -> createElement('allOrders'));

        $currentExecQueryResultObjectOrders = fetchAllOrdersBetweenDates($frDt,$toDt);
       
//         εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
//         αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObjectOrders -> querySuccess ){ 
            
            die('function constructOrdersBetweenDatesAndTop5MostSalesProductsXML -- tha kanw kati smarter soon edw!');
        }
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObjectOrders -> resultSet)){
            
            //print_r($row);
            $ordNode = $rtNd ->appendChild($domdcObject -> createElement('order'));
            $ordNode -> appendChild($domdcObject -> createElement('orderCode',$row['ORDERCODE']));
            $ordNode -> appendChild($domdcObject -> createElement('lastName',$row['LASTNAME']));
            $ordNode -> appendChild($domdcObject -> createElement('firstName',$row['FIRSTNAME']));
            $ordNode -> appendChild($domdcObject -> createElement('totalValue',$row['TOTALVALUE']));
        }  
        
        // προσθήκη του node popProducts και κατασκευή του εσωτερικού του
        $rtNd = $totalRtNd -> appendChild($domdcObject -> createElement('popProducts'));
        
        $currentExecQueryResultObjectTop5Products = get5MostSaleProductsBetweenDates($frDt,$toDt);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObjectTop5Products -> querySuccess ){ 
            
            die('function constructOrdersBetweenDatesAndTop5MostSalesProductsXML -- tha kanw kati smarter soon edw!');
        }
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObjectTop5Products -> resultSet)){
            
            //print_r($row);
            $ordNode = $rtNd ->appendChild($domdcObject -> createElement('product'));
            $ordNode -> appendChild($domdcObject -> createElement('prodCode',$row['PRODCODE_FK']));
            $ordNode -> appendChild($domdcObject -> createElement('prodName',$row['PRODNAME']));
            $ordNode -> appendChild($domdcObject -> createElement('totalSoldQuantity',$row['TOTALSOLDQUANTITY']));
        }  
        
        $domdcObject->formatOutput=true;
        $domdcObject->encoding="UTF-8";
        
        // αποθηκευση του xml file
        $now = date("Y-m-d H:i:s");
        $now = str_replace(array(':','-',' '), '',$now);
        
        global $currentXmlFile;
        $currentXmlFile = "xml/allOrdersAndTop5SalesProducts" . $now . ".xml";
        
        $domdcObject->save($currentXmlFile);
    }
?>

<?php
    // καλείται στο driver_xml_view

    // Αφού πρώτα κατασκευαστεί το XML file,
    // διατρέχεται το XML file που μόλις κατασκευάστηκε και υπολογίζονται 
    // 2 μεγέθη: 
    //          - $quantityOfOrders = η ποσότητα των παραγγελιών του XML file
    //          - $totalValueOfOrders = Η συνολική αξία όλων των παραγγελιών του XML file
    function calcValuesAndGetDatesFromXML(){
        
        global $quantityOfOrders;
        global $totalValueOfOrders;
        
        global $currentXmlFile;
        global $dateFrom;
        global $dateTo;
        
        $myXml=simplexml_load_file($currentXmlFile) or die("!!!error: Sthing gone wrong with xml file loading");
        
        $dateFrom = $myXml['dateFrom'];
        $dateTo = $myXml['dateTo'];
        
        $quantityOfOrders = 0;
        $totalValueOfOrders = 0;
        
        foreach($myXml->allOrders->children() as $currentOrder) {
            
           $totalValueOfOrders += $currentOrder->totalValue;
           $quantityOfOrders++;
        }
    }
?>

<?php
    // καλείται στο driver_xml_view

    // Ελέγχεται ότι το μόλις κατασκευασμένο  XML file είναι valid.
    // Ελέγχεται με βάση το dtd file aboutOrders.dtd που βρίσκεται μέσα στο φάκελο xml
    function checkXmlIsValid(){
        
        global $currentXmlFile;
        
        $DOMDocumentObject = new DOMDocument;
        $DOMDocumentObject->load($currentXmlFile);
        
        $isValid = $DOMDocumentObject->validate();
        
        return $isValid; 
        //return true;
    }
?>
