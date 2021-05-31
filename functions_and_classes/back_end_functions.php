
<?php
    // Aυτη η function εκτελεί όλα μου τα DB queries που παραγουν result set. 

    // Επιστρεφει τα ExecQueryResult object.
    // Σε αυτα περιέχεται εκτός απο το resultSet (εφοσον επιτυχής η εκτέλεση του query),
    // οι ιδιοτητες:
    // - querySuccess : εκφράζει την επιτυχια ή οχι της εκτέλεσης του query
    // - resultSetRows : εκφράζει τον αριθμό των records του query
    function execQueryWithResultSet($query){
        
        global $connection;
        $result = mysqli_query($connection,$query);
        
        $currentExecQueryResultObject = new ExecQueryResult();
        
        if (! $result) {
            $currentExecQueryResultObject -> querySuccess = false;
        } 
        else{
            $currentExecQueryResultObject -> querySuccess = true;
            $currentExecQueryResultObject -> resultSet = $result;
            $currentExecQueryResultObject -> resultSetRows = mysqli_num_rows($result);
        }
        
        return $currentExecQueryResultObject;
    }
?>
 
<?php
    // Aυτη η function εκτελεί όλα μου τα DB queries που δεν παραγουν result set. 
    // Επιστρεφει true ή false με βαση την επιτυχη ή μη έκβαση του query.
    function execQueryWithoutResultSet($query){
        
        global $connection;
        $result = mysqli_query($connection,$query);
        
        if (! $result) {
            
            return false;
        } 
        
        return true;
    }
?> 
   
     
<?php   
    // Aυτη η function θα ψαξει για τις πληροφορίες του χρήστη με το 
    // email τυπου ορίσματος. 
    // Το λογικά αποτελέσματα είναι το να επιστρέψει ένα resultset 
    // με 0 ή 1 rows (με βάση το αν υπάρχει ή δεν υπάρχει ο χρήστης).
    // Οπότε, ελέγχεται η περίπτωση λογικού σφάλματος να επιστραφεί 
    // resultset με πάνω από 2 rows.
    // Ενημερώνονται οι ιδιοτητες  logicalCheck,logicalErrorMessage
    function fetchUser($userEmail){
        
        $query = "SELECT usercode,password,firstname,lastname,email,admin FROM users ";
        $query .= "WHERE email = '$userEmail' ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
            
            return $currentExecQueryResultObject;
        }
        elseif ($currentExecQueryResultObject -> resultSetRows >1){
            
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logicalError;
            $currentExecQueryResultObject -> logicalErrorMessage = 'Found more than 1 record with the same email. Something went very bad.';
        }
        else {
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logiacalOk;
        }
        
        return $currentExecQueryResultObject;
    }
?>

<?php

    // Aυτη η function θα ψαξει για τις πληροφορίες του χρήστη με το 
    // usercode τυπου ορίσματος. 
    // Το λογικά αποτελέσματα είναι το να επιστρέψει ένα resultset 
    // με 1 row (καθως ο χρηστης ειναι ηδη συνδεδεμενος απο το σημειο που καλειται η function).
    // Οπότε, ελέγχεται η περίπτωση λογικού σφάλματος να επιστραφεί 
    // resultset που δεν εχει αυστηρα 1 row.
    // Ενημερώνονται οι ιδιοτητες  logicalCheck,logicalErrorMessage
    function fetchAccountDetails(){
       
        //global $connection;
        
        $usercode = UserType :: $userCode;
        
        $query = "SELECT mobile,email,adress,tk,city,nomos,birthdate FROM users ";
        $query .= "WHERE usercode = $usercode ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
            
            return $currentExecQueryResultObject;
        }
        elseif (! $currentExecQueryResultObject -> resultSetRows ==1){
            
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logicalError;
            $currentExecQueryResultObject -> logicalErrorMessage = 'Found more or less than 1 record for this usercode. Something went very bad.';
        }
        else {
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logiacalOk;
        }
        
        return $currentExecQueryResultObject;
    }

?>

<?php
    // Aυτη η function θα ψαξει για τις πληροφορίες του χρήστη με το 
    // συγκεκριμενο email (ορίσμα). 
    // Το λογικά αποτελέσματα είναι το να επιστρέψει ένα resultset 
    // με 0 ή 1 row (καθως ο χρηστης ειναι ηδη συνδεδεμενος απο το σημειο που καλειται η function).
    // Οπότε, ελέγχεται η περίπτωση λογικού σφάλματος να επιστραφεί 
    // resultset που δεν εχει αυστηρα 0 ή 1 row.
    // Ενημερώνονται οι ιδιοτητες  logicalCheck,logicalErrorMessage
    function checkEmailAlreadyExists($email) {
        
        global $connection;
        
        $query  = "SELECT * FROM users ";
        $query .= "WHERE email = '$email' ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
            
            return $currentExecQueryResultObject;
        }
        elseif ($currentExecQueryResultObject -> resultSetRows >1){
            
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logicalError;
            $currentExecQueryResultObject -> logicalErrorMessage = 'Found more than 1 record with the same email. Something went very bad.';
        }
        else {
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logiacalOk;
        }
        
        return $currentExecQueryResultObject;
    }
?>
   
<?php
    // H function με την οποία γίνεται το insert νεου user
    function registerUser($firstName,$lastName,$email,$mobile,$password,$adress,$tk,$city,$nomos,$birthdate) {
        
        $query  = "INSERT INTO users(firstName,lastName,email,mobile,password,adress,tk,city,nomos,birthdate) ";
        $query .= "VALUES ('$firstName','$lastName','$email',$mobile,'$password','$adress',$tk,'$city','$nomos','$birthdate') ";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    } 
?>


<?php
    // H function με την οποία γίνεται το update καποιου user
    function updateUser($userCode,$firstName,$lastName,$email,$mobile//,$password
                        ,$adress,$tk,$city,$nomos,$birthdate) {
        
        $query  = "UPDATE users SET ";
        $query .= " firstname = '$firstName'";
        $query .= " ,lastname = '$lastName'";
        $query .= " ,email = '$email'";
        $query .= " ,mobile = $mobile";
        //$query .= " ,password = '$password'";
        $query .= " ,adress = '$adress'";
        $query .= " ,city = '$city'";
        $query .= " ,tk = $tk";
        $query .= " ,nomos = '$nomos'";
        $query .= " ,birthdate = '$birthdate'";
        $query .= " WHERE usercode=$userCode";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    } 
?>


<?php
    // H function με την οποία γίνεται το delete καποιου user
    function deleteUser($userCode) {
        
        $query  = "DELETE FROM users ";
        $query .= "WHERE usercode=$userCode";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    } 
?>


<?php
    // H function με την οποία παιρνουμε ολους τους τυπους προιοντων
    function fetchProdTypes() {
        
        $query = "SELECT * FROM PRODTYPES";
        $query .= " ORDER BY TYPENAME";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία παιρνουμε ολες τις καταστασεις παραγγελιας
    function fetchOrderStates() {
        
        $query = "SELECT * FROM ORDERSTATES";
        $query .= " ORDER BY STATECODE";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία παιρνουμε ολες τις καταστασεις παραγγελιας
    function fetchShipmentStates() {
        
        $query = "SELECT * FROM SHIPMENT";
        $query .= " ORDER BY ID";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία παιρνουμε ολες τις καταστασεις παραγγελιας
    function fetchPaymentStates() {
        
        $query = "SELECT * FROM PAYMENT";
        $query .= " ORDER BY ID";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία γινεται το insert νεου προιοντος
    function insertProduct ($prodName,$typeCode,$prodPic,$prodStock,$prodValue,
                         $prodDescription){
        
        $query  = "INSERT INTO products (prodName,typeCode_fk,prodPic,prodStock,prodValue,
                         prodDescription) ";
        $query .= "VALUES ('$prodName',$typeCode,'$prodPic',$prodStock,'$prodValue','$prodDescription') ";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    } 
?>

<?php
    // Φερνει όλα τα προιοντα με τις κατηγοριες του, ORDER BY TYPENAME,PRODNAME
    function fetchAllProductsByCategoryAndName(){
        
        global $connection;
        
        $query = "SELECT * FROM PRODUCTS";
        $query .= " INNER JOIN PRODTYPES ON PRODUCTS.typecode_fk = PRODTYPES.typecode";
        $query .= " ORDER BY TYPENAME,PRODNAME";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>


<?php
    // kaleitai apo driver_list_delete_product.php 

    // H function με την οποία γίνεται το delete καποιου προιοντος
    function deleteProduct($productId){
        
        $query  = "DELETE FROM PRODUCTS ";
        $query .= "WHERE prodcode=$productId";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }
?>

<?php
    // kaleitai apo driver_edit_product.php
    // fernei ena sugkekrimeno proion me baseh to id, joined με τον τυπο του
    function selectProduct($actionId){
        
        $query = "SELECT * FROM PRODUCTS";
        $query .= " INNER JOIN PRODTYPES ON PRODUCTS.typecode_fk = PRODTYPES.typecode";
        $query .= " WHERE PRODCODE=$actionId";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
            
            return $currentExecQueryResultObject;
        }
        elseif ($currentExecQueryResultObject -> resultSetRows >1){
            
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logicalError;
            $currentExecQueryResultObject -> logicalErrorMessage = 'Found more than 1 record with the same productid. Something went very bad.';
        }
        else {
            $currentExecQueryResultObject -> logicalCheck = ExecQueryResult::logiacalOk;
        }
        
        return $currentExecQueryResultObject;
    }     
?>

<?php
    // kaleitai apo driver_edit_product.php
    // Κανει update ενα συγκεκριμενο product (βασει prodcode)
    function editProduct ($prodCode,$prodName,$typeCode,$prodPic,$prodStock,$prodValue,
                         $prodDescription){
        
        $query  = "UPDATE products SET ";
        $query .= " prodName = '$prodName'";
        $query .= " ,typeCode_fk = $typeCode";
        $query .= " ,prodPic = '$prodPic'";
        $query .= " ,prodStock = $prodStock";
        $query .= " ,prodValue = $prodValue";
        $query .= " ,prodDescription = '$prodDescription'";
        $query .= " WHERE prodCode=$prodCode";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    } 
?>

<?php
    // kaleitai apo driver_index.php kai driver_page2.php
    // Φερνει όλα τα προιοντα ORDER BY PRODCODE DESC
    function fetchAllProductsByIdDesc(){
        
        $query = "SELECT * FROM PRODUCTS";
        $query .= " ORDER BY PRODCODE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
// Φερνει όλα τα προιοντα ORDER BY αριθμό πωλήσεων DESC
    function fetchAllProductsBySalesDesc(){
        
        $query = "SELECT PRODCODE,PRODNAME,TYPECODE_FK,PRODDESCRIPTION,PRODPIC,PRODSTOCK,PRODVALUE,SUM(PRODQUANTITY) AS TOTALSOLDQUANTITY FROM ORDERSDETAIL";
        $query .= " INNER JOIN PRODUCTS ON ORDERSDETAIL.PRODCODE_FK = PRODUCTS.PRODCODE";
        $query .= " GROUP BY PRODCODE_FK";
        $query .= " ORDER BY TOTALSOLDQUANTITY DESC";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // kaleitai apo driver_page2.php
    // Φερνει όλα τα προιοντα ORDER BY PRODCODE DESC για μια συγκεκριμενη κατηγορια
    function fetchAllProductsByIdFilteredByCategory($typeCode_FK){
        
        $query = "SELECT * FROM PRODUCTS";
        $query .= " WHERE TYPECODE_FK=$typeCode_FK";
        $query .= " ORDER BY PRODCODE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // κανει insert to head mias paraggelias
    function insertOrdersHead($userCode,$now,$totalAmount,$totalValue,$shipment_id,$payment_id,$comment){
        
        $query  = "INSERT INTO ordershead (USERCODE_FK,ORDERDATE,STATE_FK,TOTALAMOUNT,TOTALVALUE,SHIPMENT_FK,PAYMENT_FK,COMMENT) ";
        $query .= "VALUES ($userCode,'$now',1,$totalAmount,$totalValue,$shipment_id,$payment_id,'$comment') ";
        
        $success = execQueryWithoutResultSet($query);
        
        if (! $success ){ 
            
            $currentExecQueryResultObject = new ExecQueryResult();
            $currentExecQueryResultObject -> querySuccess = false;
            
            return $currentExecQueryResultObject;
        } 
        
        $query = "SELECT ORDERCODE FROM ordershead ";
        $query .= "WHERE USERCODE_FK = $userCode and ORDERDATE='$now'  ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            return $currentExecQueryResultObject;
        }
        
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        $currentExecQueryResultObject -> numericResult = $row['ORDERCODE'];
        
        return $currentExecQueryResultObject;
        
    }
?>
       
<?php
    // kanei insert 1 row of detail sxetizomeno me kapoio head paraggelias
     function insertOrdersDetail($currentOrderCode,$currentProdCode,$currentQuantity,$currentValue){
        
            $query  = "INSERT INTO ordersdetail (ORDERCODE_FK,PRODCODE_FK,PRODQUANTITY,ORDERPRODVALUE) ";
            $query .= "VALUES ($currentOrderCode,$currentProdCode,$currentQuantity,$currentValue) ";
                
            $success = execQueryWithoutResultSet($query);
        
            return $success; 
    }
?>

<?php
    // φερνει ολες τις παραγγελιες του συνδεδεμενου χρηστη
    function fetchAllMyOrdersByDateDesc($userCode){
        
        $query = "SELECT * FROM ORDERSHEAD";
        $query .= " INNER JOIN ORDERSTATES ON ORDERSHEAD.STATE_FK = ORDERSTATES.STATECODE";
        $query .= " WHERE USERCODE_FK=$userCode";
        $query .= " ORDER BY ORDERDATE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // φερε ολες τις παραγγελιες ολων των πελατων ORDER BY ORDERDATE DESC
    function fetchAllOrdersByDateDesc(){
        
        $query = "SELECT * FROM ORDERSHEAD";
        $query .= " INNER JOIN ORDERSTATES ON ORDERSHEAD.STATE_FK = ORDERSTATES.STATECODE";
        $query .= " INNER JOIN USERS ON ORDERSHEAD.USERCODE_FK = USERS.USERCODE";
        $query .= " ORDER BY ORDERDATE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // kaleitai apo driver_allOrders.php
    // επιστρεφει το πληθος ολων των παραγγελιών
    function getNumOfAllOrders($userCode){
        
        $query = "SELECT COUNT(*) FROM ORDERSHEAD";
        
        if ($userCode !== -1){
            
            $query .= " WHERE USERCODE_FK = $userCode";
        }
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
           
            return $currentExecQueryResultObject;
        }
        
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        $currentExecQueryResultObject -> numericResult = $row['COUNT(*)'];
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // kaleitai apo driver_list_delete_product.php
    // επιστρεφει το πληθος ολων των προϊόντων
    function getNumOfAllProducts(){
        
        $query = "SELECT COUNT(*) FROM PRODUCTS";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
           
            return $currentExecQueryResultObject;
        }
        
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        $currentExecQueryResultObject -> numericResult = $row['COUNT(*)'];
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // kaleitai apo driver_users.php
    // επιστρεφει το πληθος ολων των χρηστων
    function getNumOfAllUsers(){
        
        $query = "SELECT COUNT(*) FROM USERS";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
           
            return $currentExecQueryResultObject;
        }
        
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        $currentExecQueryResultObject -> numericResult = $row['COUNT(*)'];
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // φερνει το detail για ενα συγκεκριμενο κωδικο παραγγελιας
    function MySpecificOrderDetails($orderCode){
        
        $query = "SELECT * FROM ORDERSDETAIL";
        $query .= " INNER JOIN PRODUCTS ON ORDERSDETAIL.PRODCODE_FK = PRODUCTS.PRODCODE";
        $query .= " WHERE ORDERCODE_FK=$orderCode";
        $query .= " ORDER BY PRODNAME DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>


<?php
    // φερνει ολους τους χρηστες ORDER BY LASTNAME
    function fetchAllUsersByLast(){
        
        $query = "SELECT * FROM USERS";
        $query .= " ORDER BY LASTNAME";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>


<?php
    // upologizei kai epistrefei to tziro hmeras/evdomadas/mhna
    function calcTurnOver($case){
        
        if ($case == 'today') {
            
            $query = "SELECT ROUND(SUM(TOTALVALUE),2) AS TURNOVER FROM ORDERSHEAD";
            $query .= " WHERE DATE(ORDERDATE)=CURDATE()";
        }
        elseif ($case == 'week') {
            
            $query = "SELECT ROUND(SUM(TOTALVALUE),2) AS TURNOVER FROM ORDERSHEAD";
            $query .= " WHERE YEARWEEK(DATE(ORDERDATE))=YEARWEEK(NOW())";
        }
        elseif ($case == 'month') {
            
            $query = "SELECT ROUND(SUM(TOTALVALUE),2) AS TURNOVER FROM ORDERSHEAD";
            $query .= " WHERE MONTH(DATE(ORDERDATE))=MONTH(CURDATE())";
        }
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        if (! $currentExecQueryResultObject -> querySuccess){
           
            return $currentExecQueryResultObject;
        }
        
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
        
        $currentExecQueryResultObject -> numericResult = $row['TURNOVER'];
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
// edw tha mporousa na kanw mia wraia sql function pou se periptwsh isovathmias tha mou eferne kai osa
// isovathmoun
// φέρνει τα 5 προιοντα με τις περισσοτερες πωλησεις
    function get5MostSaleProducts(){
        
        $query = "SELECT PRODCODE_FK,PRODNAME,SUM(PRODQUANTITY) AS TOTALSOLDQUANTITY FROM ORDERSDETAIL";
        $query .= " INNER JOIN PRODUCTS ON ORDERSDETAIL.PRODCODE_FK = PRODUCTS.PRODCODE";
        $query .= " GROUP BY PRODCODE_FK";
        $query .= " ORDER BY TOTALSOLDQUANTITY DESC";
        $query .= " LIMIT 5 ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // φερνει τους πελατες με τη μεγαλυτερη χρηματικη καταναλωση
    function getTop3Customers(){
        
        $query = "SELECT USERCODE,LASTNAME,FIRSTNAME,ROUND(SUM(TOTALVALUE),2) AS TOTALVALUE FROM                ORDERSHEAD";
        $query .= " INNER JOIN USERS ON ORDERSHEAD.USERCODE_FK = USERS.USERCODE";
        $query .= " GROUP BY USERCODE";
        $query .= " ORDER BY TOTALVALUE DESC";
        $query .= " LIMIT 3 ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // καλείται από τη controller function constructOrdersBetweenDatesAndTop5MostSalesProductsXML

    // φέρνει ολες τις παραγγελιες ολων των πελατων με ημερομηνια παραγγελίας αναμεσα σε $frDt
    // και $toDt, με ταξινομηση με βαση την τιμη παραγγελιας με φθινοντα τροπο
    function fetchAllOrdersBetweenDates($frDt,$toDt){
        
        $query = "SELECT ORDERCODE,FIRSTNAME,LASTNAME,TOTALVALUE FROM ORDERSHEAD";
        $query .= " INNER JOIN USERS ON ORDERSHEAD.USERCODE_FK = USERS.USERCODE";
        $query .= " WHERE ORDERDATE BETWEEN '$frDt' AND '$toDt'";
        $query .= " ORDER BY TOTALVALUE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // καλείται από τη controller function constructOrdersBetweenDatesAndTop5MostSalesProductsXML

    // φέρνει τα 5 προιοντα με τις περισσοτερες πωλησεις
    // με ημερομηνια παραγγελιας αναμεσα σε $frDt και $toDt
    function get5MostSaleProductsBetweenDates($frDt,$toDt){
        
        $query = "SELECT PRODCODE_FK,PRODNAME,SUM(PRODQUANTITY) AS TOTALSOLDQUANTITY FROM ORDERSDETAIL";
        $query .= " INNER JOIN ORDERSHEAD ON ORDERSDETAIL.ORDERCODE_FK = ORDERSHEAD.ORDERCODE";
        $query .= " INNER JOIN PRODUCTS ON ORDERSDETAIL.PRODCODE_FK = PRODUCTS.PRODCODE";
        $query .= " WHERE ORDERSHEAD.ORDERDATE BETWEEN '$frDt' AND '$toDt'";
        $query .= " GROUP BY PRODCODE_FK";
        $query .= " ORDER BY TOTALSOLDQUANTITY DESC";
        $query .= " LIMIT 5 ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // καλείται από τη controller function constructOrdersBetweenDatesAndTop5MostSalesProductsXML

    // φέρνει τα 5 προιοντα με τις περισσοτερες πωλησεις
    // με ημερομηνια παραγγελιας αναμεσα σε $frDt και $toDt
    function updateStockProductsOfOrder($currentOrderCode){
        
        $query ="UPDATE products";
        $query .=" INNER JOIN ordersdetail ON products.PRODCODE = ordersdetail.PRODCODE_FK";
        $query .=" SET products.PRODSTOCK = products.PRODSTOCK - ordersdetail.PRODQUANTITY";
        $query .=" where  ordersdetail.ORDERCODE_FK = $currentOrderCode";
        //echo $query;
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }
?>

<?php
    // καλείται από τη controller function constructOrdersBetweenDatesAndTop5MostSalesProductsXML

    // φέρνει τα 5 προιοντα με τις περισσοτερες πωλησεις
    // με ημερομηνια παραγγελιας αναμεσα σε $frDt και $toDt
    function updateOrderState($currentOrderCode,$currentNewState){
        
        $query  = "UPDATE ORDERSHEAD SET ";
        $query .= " STATE_FK = $currentNewState";
        $query .= " WHERE ORDERCODE=$currentOrderCode";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }
?>

<?php

    function fetchOrderHeadOthers($orderCode){
       
        
        $query = "SELECT shipment.SHORTDESCRIPTION as shortShip,payment.SHORTDESCRIPTION as shortPay,ORDERShead.COMMENT as comment FROM ORDERShead ";
        $query .= " INNER JOIN shipment ON ORDERShead.SHIPMENT_FK = shipment.id";
        $query .= " INNER JOIN payment ON ORDERShead.PAYMENT_FK = payment.id";
        $query .= " WHERE ordercode = $orderCode ";
        $query .= " LIMIT 1 ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // kaleitai apo async_initiateDB.php 

    // H function με την οποία γίνεται initiate η DB
    function initiateDB(){
        
        $query  = "CALL initiate_data";
                
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }
?>


