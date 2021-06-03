
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
        
        $query = "SELECT * FROM prodtypes";
        $query .= " ORDER BY TYPENAME";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία παιρνουμε ολες τις καταστασεις παραγγελιας
    function fetchOrderStates() {
        
        $query = "SELECT * FROM orderstates";
        $query .= " ORDER BY STATECODE";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία παιρνουμε ολες τις καταστασεις παραγγελιας
    function fetchShipmentStates() {
        
        $query = "SELECT * FROM shipment";
        $query .= " ORDER BY ID";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // H function με την οποία παιρνουμε ολες τις καταστασεις παραγγελιας
    function fetchPaymentStates() {
        
        $query = "SELECT * FROM payment";
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
        
        $query = "SELECT * FROM products";
        $query .= " INNER JOIN prodtypes ON products.typecode_fk = prodtypes.typecode";
        $query .= " ORDER BY TYPENAME,PRODNAME";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>


<?php
    // kaleitai apo driver_list_delete_product.php 

    // H function με την οποία γίνεται το delete καποιου προιοντος
    function deleteProduct($productId){
        
        $query  = "DELETE FROM products ";
        $query .= "WHERE prodcode=$productId";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }
?>

<?php
    // kaleitai apo driver_edit_product.php
    // fernei ena sugkekrimeno proion me baseh to id, joined με τον τυπο του
    function selectProduct($actionId){
        
        $query = "SELECT * FROM products";
        $query .= " INNER JOIN prodtypes ON products.typecode_fk = prodtypes.typecode";
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
        
        $query = "SELECT * FROM products";
        $query .= " ORDER BY PRODCODE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
// Φερνει όλα τα προιοντα ORDER BY αριθμό πωλήσεων DESC
    function fetchAllProductsBySalesDesc(){
        
        $query = "SELECT PRODCODE,PRODNAME,TYPECODE_FK,PRODDESCRIPTION,PRODPIC,PRODSTOCK,PRODVALUE,SUM(PRODQUANTITY) AS TOTALSOLDQUANTITY FROM ordersdetail";
        $query .= " INNER JOIN products ON ordersdetail.PRODCODE_FK = products.PRODCODE";
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
        
        $query = "SELECT * FROM products";
        $query .= " WHERE TYPECODE_FK=$typeCode_FK";
        $query .= " ORDER BY PRODCODE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // κανει insert to head mias paraggelias
    function insertOrdersHead($userCode,$now,$totalAmount,$totalValue,$shipment_id,$payment_id,$comment){
        
        $query  = "INSERT INTO ordershead (USERCODE_FK,ORDERDATE,STATE_FK,TOTALAMOUNT,TOTALVALUE,shipment_FK,payment_FK,COMMENT) ";
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
        
        $query = "SELECT * FROM ordershead";
        $query .= " INNER JOIN orderstates ON ordershead.STATE_FK = orderstates.STATECODE";
        $query .= " WHERE USERCODE_FK=$userCode";
        $query .= " ORDER BY ORDERDATE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php
    // φερε ολες τις παραγγελιες ολων των πελατων ORDER BY ORDERDATE DESC
    function fetchAllOrdersByDateDesc(){
        
        $query = "SELECT * FROM ordershead";
        $query .= " INNER JOIN orderstates ON ordershead.STATE_FK = orderstates.STATECODE";
        $query .= " INNER JOIN users ON ordershead.USERCODE_FK = users.USERCODE";
        $query .= " ORDER BY ORDERDATE DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>

<?php
    // kaleitai apo driver_allOrders.php
    // επιστρεφει το πληθος ολων των παραγγελιών
    function getNumOfAllOrders($userCode){
        
        $query = "SELECT COUNT(*) FROM ordershead";
        
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
        
        $query = "SELECT COUNT(*) FROM products";
    
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
        
        $query = "SELECT COUNT(*) FROM users";
    
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
        
        $query = "SELECT * FROM ordersdetail";
        $query .= " INNER JOIN products ON ordersdetail.PRODCODE_FK = products.PRODCODE";
        $query .= " WHERE ORDERCODE_FK=$orderCode";
        $query .= " ORDER BY PRODNAME DESC";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject; 
    }
?>


<?php
    // φερνει ολους τους χρηστες ORDER BY LASTNAME
    function fetchAllUsersByLast(){
        
        $query = "SELECT * FROM users";
        $query .= " ORDER BY LASTNAME";
    
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>


<?php
    // upologizei kai epistrefei to tziro hmeras/evdomadas/mhna
    function calcTurnOver($case){
        
        if ($case == 'today') {
            
            $query = "SELECT ROUND(SUM(TOTALVALUE),2) AS TURNOVER FROM ordershead";
            $query .= " WHERE DATE(ORDERDATE)=CURDATE()";
        }
        elseif ($case == 'week') {
            
            $query = "SELECT ROUND(SUM(TOTALVALUE),2) AS TURNOVER FROM ordershead";
            $query .= " WHERE YEARWEEK(DATE(ORDERDATE))=YEARWEEK(NOW())";
        }
        elseif ($case == 'month') {
            
            $query = "SELECT ROUND(SUM(TOTALVALUE),2) AS TURNOVER FROM ordershead";
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
        
        $query = "SELECT PRODCODE_FK,PRODNAME,SUM(PRODQUANTITY) AS TOTALSOLDQUANTITY FROM ordersdetail";
        $query .= " INNER JOIN products ON ordersdetail.PRODCODE_FK = products.PRODCODE";
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
        
        $query = "SELECT USERCODE,LASTNAME,FIRSTNAME,ROUND(SUM(TOTALVALUE),2) AS TOTALVALUE FROM                ordershead";
        $query .= " INNER JOIN users ON ordershead.USERCODE_FK = users.USERCODE";
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
        
        $query = "SELECT ORDERCODE,FIRSTNAME,LASTNAME,TOTALVALUE FROM ordershead";
        $query .= " INNER JOIN users ON ordershead.USERCODE_FK = users.USERCODE";
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
        
        $query = "SELECT PRODCODE_FK,PRODNAME,SUM(PRODQUANTITY) AS TOTALSOLDQUANTITY FROM ordersdetail";
        $query .= " INNER JOIN ordershead ON ordersdetail.ORDERCODE_FK = ordershead.ORDERCODE";
        $query .= " INNER JOIN products ON ordersdetail.PRODCODE_FK = products.PRODCODE";
        $query .= " WHERE ordershead.ORDERDATE BETWEEN '$frDt' AND '$toDt'";
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
        
        $query  = "UPDATE ordershead SET ";
        $query .= " STATE_FK = $currentNewState";
        $query .= " WHERE ORDERCODE=$currentOrderCode";
        
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }
?>

<?php

    function fetchOrderHeadOthers($orderCode){
       
        
        $query = "SELECT shipment.SHORTDESCRIPTION as shortShip,payment.SHORTDESCRIPTION as shortPay,ordershead.COMMENT as comment FROM ordershead ";
        $query .= " INNER JOIN shipment ON ordershead.shipment_FK = shipment.id";
        $query .= " INNER JOIN payment ON ordershead.payment_FK = payment.id";
        $query .= " WHERE ordercode = $orderCode ";
        $query .= " LIMIT 1 ";
        
        $currentExecQueryResultObject = execQueryWithResultSet($query);
        
        return $currentExecQueryResultObject;
    }
?>

<?php /*
    // kaleitai apo async_initiateDB.php 

    // H function με την οποία γίνεται initiate η DB
    function initiateDB(){
        
        //$query  = "CALL initiate_data";
        
        $query  = "DELETE FROM ordersdetail;
DELETE FROM ordershead;
DELETE FROM products;
DELETE FROM users;
DELETE FROM prodtypes;
DELETE FROM orderstates;
DELETE FROM payment;
DELETE FROM shipment;
INSERT INTO `orderstates` (`STATECODE`, `STATENAME`) VALUES
(1, 'Κατατέθηκε'),
(2, 'Σε Επεξεργασία'),
(3, 'Απεστάλη'),
(4, 'Ολοκληρωμένη');
INSERT INTO `payment` (`ID`, `FULLDESCRIPTION`, `SHORTDESCRIPTION`) VALUES
(1, 'Πιστωτική, χρεωστική ή προπληρωμένη κάρτα online', 'Κάρτα'),
(2, 'Τραπεζική κατάθεση', 'Κατάθεση');
INSERT INTO `shipment` (`ID`, `FULLDESCRIPTION`, `SHORTDESCRIPTION`) VALUES
(1, 'Παραλαβή από το κατάστημα', 'Κατάστημα'),
(2, 'Παράδοση με δική μας μεταφορική ή courier', 'Our courier'),
(3, 'Παράδοση με μεταφορική ή courier της επιλογής σας', 'Other courier');
INSERT INTO `prodtypes` (`TYPECODE`, `TYPENAME`) VALUES
(10, 'Τροφή'),
(11, 'Λιχουδιά'),
(12, 'Κολάρο'),
(13, 'Ρούχο'),
(14, 'Παιχνίδι');
INSERT INTO `users` (`USERCODE`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `MOBILE`, `EMAIL`, `ADMIN`, `ADRESS`, `TK`, `CITY`, `NOMOS`, `BIRTHDATE`) VALUES
(11, 'puser1234', 'Γιώργος', 'Πεκος', '6982314567', 'user@mail.com', b'0', 'Αρμαγου 41', 61100, 'Αθηνα', 'Ν. Αττικής', '1992-01-02'),
(12, 'padmin1234', 'Τακης', 'Τσαλτιδης', '2310789456', 'admin@mail.com', b'1', 'Κιτσοκρανια 3', 61200, 'Ζαλογγο', 'Ν. Ιωαννίνων', '2000-12-01'),
(14, '12345678', 'Δημος', 'Χιωλικιδης', '6981234567', 'mdime40000@live.com', b'0', 'κολοκοτρωνη 7', 61100, 'Αθηνα', 'Ν. Αττικής', '1997-12-01'),
(15, '12345678', 'Μιχάλης', 'Προβίδης', '6991234567', 'provialdo@hotmail.com', b'0', 'Κιτσου 79', 61900, 'Βολος', 'Ν. Μαγνησίας', '1980-01-29'),
(21, '12345678', 'Μπαμπης', 'Σουγιας', '6991234567', 'shortKnive@live.com', b'0', 'Καραισκακη 52', 61800, 'Κομοτηνή', 'Ν. Ροδόπης', '1989-05-05'),
(22, '12345678', 'Μαρια', 'Βελωνη', '6991234567', 'needle@live.com', b'0', 'Δημοκρατιας 9', 63000, 'Ματαλα', 'Ν. Ηρακλείου', '2000-04-07'),
(24, '12345678', 'Αννα', 'Κουτιδου', '6991234567', 'koutidou@mail.com', b'0', 'Σαλαμινας 79', 61900, 'Βόλος', 'Ν. Μαγνησίας', '2005-01-01'),
(28, '12345678', 'Ελενη', 'Μουρτακη', '6987654321', 'e.mourtakh@f', b'0', 'Δευκελειας 154', 61100, 'Αθηνα', 'Ν. Αττικής', '2002-02-13'),
(29, '12345678', 'Στεφανια', 'Γατου', '6987654321', 'stef@gmail.com', b'0', 'Αντιστασεως 68', 61100, 'Αθηνα', 'Ν. Αττικής', '2004-04-16'),
(30, '12345678', 'Σια', 'Μιαουνη', '6987654321', 'miaou@live.gr', b'0', 'Εγνατιας 116', 61100, 'Αθηνα', 'Ν. Αττικής', '2005-01-23'),
(31, '12345678', 'Δημητρης', 'Ποντικας', '6987654321', 'mouse@gmail.com', b'0', 'Βασ. Ολγας 251', 61100, 'Αθηνα', 'Ν. Αττικής', '1999-01-15'),
(33, '12345678', 'Στελιος', 'Κοκωνης', '6987654321', 'stel@live.com', b'0', 'Πατησιων 56', 61100, 'Αθηνα', 'Ν. Αττικής', '2001-01-16');
INSERT INTO `products` (`PRODCODE`, `PRODNAME`, `TYPECODE_FK`, `PRODDESCRIPTION`, `PRODPIC`, `PRODSTOCK`, `PRODVALUE`) VALUES
(9, 'Doggex Σνακ', 11, 'Σνακ σκύλου με Ω3, Ω4, Ω5 λιπαρά, κατάλληλα για ενήλικους σκύλους ως συμπλήρωμα διατροφής. ', 'doggex.jpg', 19, 7.6),
(10, 'Σκυλο-Μπαλάκι', 14, 'Παιχνίδι σκύλου μπάλα κόκκινη με μπλε διακοσμημένη με γατούλες, 16cm', 'skilobalex.jpg', 8, 5.3),
(11, 'Γιδοκονσέρβα', 10, 'Κονσέρβα σκύλου, πλήρες εκλεκτό γεύμα με κομμάτια από αρνάκι άσπρο και παχύ', 'gidokonserva.jpeg', 1, 14),
(12, 'Μοσχαροκροκέτες', 10, 'Κροκέτες με μοσχάρι για μικρόσωμες ράτσες με μέτρια δραστηριότητα, ηλικίας 1- 6 ετών.', 'mosxarokroketes.jpg', 22, 18.9),
(13, 'Redneck', 12, 'Περιλαίμιο σκύλου, κόκκινο με σχέδιο γάτα που κυνηγά σκύλο, xs, 15-23cm', 'redneck.jpg', 31, 4.9),
(14, 'Κοκκαλέξ', 14, 'Παιχνίδι σκύλου κόκκαλο μπλε, 12 cm, από μαλακό και ανθεκτικό υλικό.', 'kokkalex.jpg', 44, 2.5),
(15, 'Βρακέξ (20 τχ)', 13, 'Πάνα-βρακάκι σκύλου, με μεγάλη απορροφητικότητα και άρωμα δυόσμου, s, 20 τεμάχια', 'vrakeks.jpg', 55, 7.7),
(16, 'Mini sticks', 11, 'Mini sticks, λιχουδιά από μοσχάρι με χαμηλά λιπαρά και υψηλή θερμιδική αξία.', 'miniSticks.jpg', 1, 6),
(17, 'Πουλοβερεξ Σκύλου', 13, 'Ζεστό πουλόβερ σκύλου, ροζ πουά με στρας και σχέδιο κεραυνό, xl.', 'pullover.jpg', 1, 6.1),
(18, 'Τουμπανοκροκέτες (4kg)', 10, 'Κροκέτες ολοκληρωμένη και γευστική τροφή με κοτόπουλο και λαχανικά για ενήλικους σκύλους.', 'toumpanokroketes.jpg', 8, 28.7),
(19, 'Φτηνο-κολαρέξ', 12, 'Περιλαίμιο από υψηλής ποιότητας νάιλον με πλάτος 2,2cm και μήκος 39cm.', 'nailonPerilemio.jpg', 50, 2.1),
(20, 'Τουρμποκροκέτες (5 kg)', 10, 'Κροκέτες με βοδινό και μοσχάρι, πλήρης τροφή για σκύλους άνω των δέκα κιλών.', 'turbokroketes.jpg', 1, 49),
(21, 'Σκυλοπαιχνίδι Καρδιά', 14, 'Παιχνιδι για συναισθηματικούς σκύλους.', 'paixnidiSkilouKardia.jpeg', 1, 0.9),
(22, 'Σκυλοπαιχνίδι Σκαντζόχοιρος', 14, 'Ενας πολυτιμος πλην ακανθώδης φίλος για το κατοικίδιο σας.', 'PaixnidiSkilouSkantzoxoiros.jpeg', 30, 1.35),
(23, 'Mocdog', 10, 'Συνδυάζει καφέ εσπρέσσο με χοιρινή κροκέτα. Για σκύλους υποτονικούς που δεν ξυπνούν. Απαλό άρωμα.', 'mocdog.jpg', 35, 11),
(24, 'Skylo-news', 14, 'Είτε το πιστεύετε είτε όχι προσομοιώνει τον ήχο πραγματικής εφημερίδας. Καλό;', 'dogpaper.jpg', 15, 2.1);
INSERT INTO `ordershead` (`ORDERCODE`, `USERCODE_FK`, `ORDERDATE`, `STATE_FK`, `TOTALAMOUNT`, `TOTALVALUE`, `shipment_FK`, `payment_FK`, `COMMENT`) VALUES
(23, 11, '2020-03-05 02:26:25', 1, 10, 41.4, 2, 1, 'Visa, ωρες παραλαβης 6-8 μ.μ'),
(24, 11, '2020-03-18 02:27:37', 3, 3, 19.7, 1, 2, 'Αρ. Λογ:213/1234567'),
(25, 11, '2020-03-24 02:27:57', 2, 4, 75.6, 1, 1, NULL),
(26, 12, '2020-03-24 02:28:29', 1, 6, 13.6, 2, 2, 'Ωρες παραλαβής:6-9 μ.μ, Αρ.Λογ:979/123456'),
(27, 12, '2020-03-24 02:29:00', 4, 3, 13, 3, 2, 'Ωρες παραλαβής:6-9 μ.μ, Αρ.Λογ:979/123456,Ασσος Courier'),
(28, 11, '2020-03-24 02:29:49', 1, 10, 90.7, 1, 1, NULL),
(29, 14, '2020-03-25 00:01:15', 1, 7, 69.1, 3, 2, NULL),
(30, 14, '2020-03-25 00:01:31', 1, 1, 2.1, 2, 2, NULL),
(31, 14, '2020-03-25 00:01:50', 1, 5, 15.7, 1, 1, NULL),
(32, 12, '2020-03-25 00:02:18', 1, 6, 87.7, 2, 1, 'Ωρες παραλαβής:6-9 μ.μ'),
(33, 11, '2020-03-25 00:02:59', 1, 7, 26.2, 3, 1, NULL),
(34, 11, '2020-03-25 00:03:34', 1, 5, 13, 1, 2, 'Αρ. Λογ:213/1299567'),
(35, 12, '2020-03-25 00:24:37', 1, 6, 42.55, 2, 1, 'Ωρες παραλαβής:9-11 π.μ'),
(36, 12, '2020-03-25 00:24:50', 1, 1, 2.1, 1, 1, NULL),
(37, 14, '2020-03-25 00:25:24', 1, 4, 15.1, 3, 1, 'Ωρες παραλαβής:1-9 μ.μ,Βητα Courier'),
(38, 14, '2020-03-25 00:26:10', 1, 1, 1.35, 2, 2, NULL),
(39, 14, '2020-03-25 00:26:19', 1, 1, 4.9, 3, 2, NULL),
(40, 14, '2020-03-25 00:26:40', 1, 5, 36.1, 2, 2, NULL),
(41, 14, '2020-03-25 00:26:57', 1, 1, 1.35, 2, 1, 'Ωρες παραλαβής:12-3 μ.μ'),
(42, 11, '2020-03-25 00:27:23', 1, 4, 153.1, 1, 1, NULL),
(43, 11, '2020-03-25 00:28:02', 1, 1, 11, 1, 1, NULL),
(44, 11, '2020-04-06 00:28:19', 1, 4, 106.2, 1, 2, 'Αρ. Λογ:212/1277567'),
(45, 11, '2020-04-08 00:28:48', 1, 4, 39, 2, 1, 'Ωρες παραλαβής:7-9 μ.μ'),
(46, 11, '2020-04-10 00:29:18', 1, 2, 21.7, 1, 1, NULL),
(47, 15, '2020-04-12 04:40:30', 1, 5, 15.9, 2, 2, 'Ωρες παραλαβής:7-9 μ.μ, Αρ.Λογ:999/166456'),
(48, 15, '2020-04-13 04:41:02', 1, 13, 89, 1, 1, NULL),
(49, 12, '2020-04-13 22:17:56', 1, 4, 25.45, 1, 1, NULL),
(51, 11, '2020-04-14 20:43:15', 1, 5, 29.4, 3, 2, NULL),
(52, 11, '2020-04-18 18:04:31', 1, 2, 13.1, 3, 1, 'Ωρες παραλαβής:3-9 μ.μ,Ητα Courier'),
(53, 11, '2020-04-18 18:04:58', 1, 4, 24.7, 2, 2, 'Ωρες παραλαβής:5-7 μ.μ, Αρ.Λογ:179/123459'),
(54, 11, '2020-04-26 18:42:28', 1, 3, 4.8, 2, 1, 'Ωρες παραλαβής:6-10 μ.μ'),
(55, 11, '2020-04-26 18:42:54', 1, 8, 228.7, 1, 1, NULL),
(56, 15, '2020-04-26 18:44:19', 1, 8, 86.9, 1, 1, NULL),
(57, 15, '2020-04-26 18:44:47', 1, 6, 19.8, 3, 2, NULL),
(58, 14, '2020-04-26 18:45:40', 1, 5, 33, 3, 1, 'Ωρες παραλαβής:8-9 μ.μ,Βητα Courier'),
(59, 14, '2020-04-26 18:46:21', 1, 4, 64.8, 2, 1, 'Ωρες παραλαβής:8-10 μ.μ'),
(60, 14, '2020-04-26 18:46:37', 1, 2, 7, 1, 2, NULL),
(61, 14, '2020-04-26 18:47:07', 1, 4, 51.9, 1, 1, NULL),
(62, 11, '2020-04-26 18:47:46', 1, 4, 6.15, 3, 2, 'Ωρες παραλαβής:6-9 μ.μ,Βητα Courier'),
(63, 11, '2020-04-26 18:48:17', 1, 11, 93.9, 1, 1, NULL),
(64, 12, '2020-10-08 23:07:11', 1, 7, 38.25, 2, 1, 'Ωρες παραλαβής:4-6 μ.μ'),
(65, 12, '2020-10-09 20:43:44', 1, 4, 25.45, 1, 2, 'Αρ. Λογ:313/1234567'),
(66, 12, '2020-10-19 21:03:09', 1, 3, 4.05, 2, 2, 'τεστ'),
(67, 12, '2020-10-19 21:03:41', 1, 1, 2.1, 1, 1, ''),
(68, 11, '2020-10-24 15:35:29', 1, 4, 25.45, 2, 2, 'geia sou dhmo'),
(69, 12, '2020-10-25 16:35:49', 1, 4, 25.45, 1, 1, ''),
(70, 33, '2020-10-25 19:02:39', 1, 6, 59.2, 2, 2, ''),
(71, 33, '2020-10-25 19:03:09', 1, 5, 16.4, 3, 1, ''),
(72, 33, '2020-10-25 19:03:56', 1, 7, 53.5, 3, 1, 'Ωρες παραλαβής:8-9 μ.μ,Βητα Courier'),
(73, 29, '2020-10-25 19:10:43', 1, 7, 145.9, 1, 1, ''),
(74, 29, '2020-10-25 19:10:58', 1, 4, 25.45, 1, 2, 'Αρ. Λογ:313/1234567'),
(75, 29, '2020-10-25 19:12:56', 1, 4, 10.85, 1, 1, ''),
(76, 21, '2020-10-25 19:18:18', 1, 16, 122.8, 2, 1, 'Ωρες παραλαβής:4-6 μ.μ'),
(77, 21, '2020-10-25 19:18:34', 1, 1, 2.1, 1, 1, ''),
(78, 21, '2020-10-25 19:18:46', 1, 10, 81.05, 3, 2, 'Ωρες παραλαβής:6-9 μ.μ,Βητα Courier'),
(79, 11, '2020-10-25 19:19:04', 1, 4, 25.45, 1, 1, '');
INSERT INTO `ordersdetail` (`ORDERCODE_FK`, `PRODCODE_FK`, `PRODQUANTITY`, `ORDERPRODVALUE`) VALUES
(23, 21, 4, 3.6),
(23, 22, 2, 2.7),
(23, 23, 3, 33),
(23, 24, 1, 2.1),
(24, 15, 1, 7.7),
(24, 16, 2, 12),
(25, 12, 4, 75.6),
(26, 17, 1, 6.1),
(26, 19, 1, 2.1),
(26, 22, 4, 5.4),
(27, 16, 1, 6),
(27, 17, 1, 6.1),
(27, 21, 1, 0.9),
(28, 22, 2, 2.7),
(28, 23, 8, 88),
(29, 11, 2, 28),
(29, 16, 1, 6),
(29, 23, 3, 33),
(29, 24, 1, 2.1),
(30, 24, 1, 2.1),
(31, 13, 2, 9.8),
(31, 14, 2, 5),
(31, 21, 1, 0.9),
(32, 12, 4, 75.6),
(32, 16, 1, 6),
(32, 17, 1, 6.1),
(33, 13, 2, 9.8),
(33, 22, 4, 5.4),
(33, 23, 1, 11),
(34, 17, 1, 6.1),
(34, 19, 1, 2.1),
(34, 22, 2, 2.7),
(34, 24, 1, 2.1),
(35, 15, 1, 7.7),
(35, 18, 1, 28.7),
(35, 22, 3, 4.05),
(35, 24, 1, 2.1),
(36, 19, 1, 2.1),
(37, 16, 1, 6),
(37, 17, 1, 6.1),
(37, 21, 1, 0.9),
(37, 24, 1, 2.1),
(38, 22, 1, 1.35),
(39, 13, 1, 4.9),
(40, 16, 2, 12),
(40, 23, 2, 22),
(40, 24, 1, 2.1),
(41, 22, 1, 1.35),
(42, 17, 1, 6.1),
(42, 20, 3, 147),
(43, 23, 1, 11),
(44, 17, 1, 6.1),
(44, 19, 1, 2.1),
(44, 20, 2, 98),
(45, 9, 2, 15.2),
(45, 12, 1, 18.9),
(45, 13, 1, 4.9),
(46, 11, 1, 14),
(46, 15, 1, 7.7),
(47, 16, 2, 12),
(47, 21, 2, 1.8),
(47, 24, 1, 2.1),
(48, 10, 5, 26.5),
(48, 14, 3, 7.5),
(48, 23, 5, 55),
(49, 22, 1, 1.35),
(49, 23, 2, 22),
(49, 24, 1, 2.1),
(51, 9, 2, 15.2),
(51, 16, 1, 6),
(51, 17, 1, 6.1),
(51, 24, 1, 2.1),
(52, 23, 1, 11),
(52, 24, 1, 2.1),
(53, 22, 2, 2.7),
(53, 23, 2, 22),
(54, 22, 2, 2.7),
(54, 24, 1, 2.1),
(55, 12, 4, 75.6),
(55, 17, 1, 6.1),
(55, 20, 3, 147),
(56, 11, 5, 70),
(56, 13, 1, 4.9),
(56, 16, 2, 12),
(57, 10, 3, 15.9),
(57, 21, 2, 1.8),
(57, 24, 1, 2.1),
(58, 9, 3, 22.8),
(58, 14, 1, 2.5),
(58, 15, 1, 7.7),
(59, 10, 1, 5.3),
(59, 18, 2, 57.4),
(59, 19, 1, 2.1),
(60, 17, 1, 6.1),
(60, 21, 1, 0.9),
(61, 12, 1, 18.9),
(61, 23, 3, 33),
(62, 22, 3, 4.05),
(62, 24, 1, 2.1),
(63, 13, 2, 9.8),
(63, 16, 2, 12),
(63, 17, 1, 6.1),
(63, 23, 6, 66),
(64, 21, 2, 1.8),
(64, 22, 1, 1.35),
(64, 23, 3, 33),
(64, 24, 1, 2.1),
(65, 22, 1, 1.35),
(65, 23, 2, 22),
(65, 24, 1, 2.1),
(66, 22, 3, 4.05),
(67, 24, 1, 2.1),
(68, 22, 1, 1.35),
(68, 23, 2, 22),
(68, 24, 1, 2.1),
(69, 22, 1, 1.35),
(69, 23, 2, 22),
(69, 24, 1, 2.1),
(70, 10, 2, 10.6),
(70, 15, 1, 7.7),
(70, 17, 2, 12.2),
(70, 18, 1, 28.7),
(71, 9, 1, 7.6),
(71, 14, 1, 2.5),
(71, 19, 3, 6.3),
(72, 9, 1, 7.6),
(72, 11, 2, 28),
(72, 13, 2, 9.8),
(72, 16, 1, 6),
(72, 24, 1, 2.1),
(73, 13, 1, 4.9),
(73, 17, 2, 12.2),
(73, 18, 1, 28.7),
(73, 19, 1, 2.1),
(73, 20, 2, 98),
(74, 22, 1, 1.35),
(74, 23, 2, 22),
(74, 24, 1, 2.1),
(75, 15, 1, 7.7),
(75, 21, 2, 1.8),
(75, 22, 1, 1.35),
(76, 9, 1, 7.6),
(76, 10, 5, 26.5),
(76, 11, 1, 14),
(76, 12, 2, 37.8),
(76, 13, 3, 14.7),
(76, 14, 1, 2.5),
(76, 15, 1, 7.7),
(76, 16, 2, 12),
(77, 24, 1, 2.1),
(78, 22, 3, 4.05),
(78, 23, 7, 77),
(79, 22, 1, 1.35),
(79, 23, 2, 22),
(79, 24, 1, 2.1);";
                
        $success = execQueryWithoutResultSet($query);
        
        return $success;
    }*/
?>

<?php
    // kaleitai apo async_initiateDB.php 

    // H function με την οποία γίνεται initiate η DB
    function initiateDB(){
        
        //$query  = "CALL initiate_data";
        
        $query  = "DELETE FROM ordersdetail";
        execQueryWithoutResultSet($query);
        
        $query  = "DELETE FROM ordershead";
        execQueryWithoutResultSet($query);
        
        $query  = "DELETE FROM products";
        execQueryWithoutResultSet($query);
        
        $query  = "DELETE FROM users";
        execQueryWithoutResultSet($query);
        
        $query  = "DELETE FROM prodtypes";
        execQueryWithoutResultSet($query);
        
        $query  = "DELETE FROM orderstates";
        execQueryWithoutResultSet($query);
        
        $query  = "DELETE FROM payment";
        execQueryWithoutResultSet($query);

        $query  = "DELETE FROM shipment";
        execQueryWithoutResultSet($query);

        $query  = "INSERT INTO `orderstates` (`STATECODE`, `STATENAME`) VALUES ";
        $query .= "(1, 'Κατατέθηκε'), ";
        $query .= "(2, 'Σε Επεξεργασία'), ";
        $query .= "(3, 'Απεστάλη'), ";
        $query .= "(4, 'Ολοκληρωμένη') ";
        execQueryWithoutResultSet($query);

        $query  = "INSERT INTO `payment` (`ID`, `FULLDESCRIPTION`, `SHORTDESCRIPTION`) VALUES ";
        $query .= "(1, 'Πιστωτική, χρεωστική ή προπληρωμένη κάρτα online', 'Κάρτα'), ";
        $query .= "(2, 'Τραπεζική κατάθεση', 'Κατάθεση') ";
        execQueryWithoutResultSet($query);

        $query  = "INSERT INTO `shipment` (`ID`, `FULLDESCRIPTION`, `SHORTDESCRIPTION`) VALUES ";
        $query .= "(1, 'Παραλαβή από το κατάστημα', 'Κατάστημα'), ";
        $query .= "(2, 'Παράδοση με δική μας μεταφορική ή courier', 'Our courier'), ";
        $query .= "(3, 'Παράδοση με μεταφορική ή courier της επιλογής σας', 'Other courier')";
        execQueryWithoutResultSet($query);

        $query  = "INSERT INTO `prodtypes` (`TYPECODE`, `TYPENAME`) VALUES ";
        $query .= "(10, 'Τροφή'), ";
        $query .= "(11, 'Λιχουδιά'), ";
        $query .= "(12, 'Κολάρο'), ";
        $query .= "(13, 'Ρούχο'), ";
        $query .= "(14, 'Παιχνίδι')";
        execQueryWithoutResultSet($query);

        
        $query  = "INSERT INTO `users` (`USERCODE`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `MOBILE`, `EMAIL`, `ADMIN`, `ADRESS`, `TK`, `CITY`, `NOMOS`, `BIRTHDATE`) VALUES ";
        $query .= "(11, 'puser1234', 'Γιώργος', 'Πεκος', '6982314567', 'user@mail.com', b'0', 'Αρμαγου 41', 61100, 'Αθηνα', 'Ν. Αττικής', '1992-01-02'), ";
        $query .= "(12, 'padmin1234', 'Τακης', 'Τσαλτιδης', '2310789456', 'admin@mail.com', b'1', 'Κιτσοκρανια 3', 61200, 'Ζαλογγο', 'Ν. Ιωαννίνων', '2000-12-01'), ";
        $query .= "(14, '12345678', 'Δημος', 'Χιωλικιδης', '6981234567', 'mdime40000@live.com', b'0', 'κολοκοτρωνη 7', 61100, 'Αθηνα', 'Ν. Αττικής', '1997-12-01'), ";
        $query .= "(15, '12345678', 'Μιχάλης', 'Προβίδης', '6991234567', 'provialdo@hotmail.com', b'0', 'Κιτσου 79', 61900, 'Βολος', 'Ν. Μαγνησίας', '1980-01-29'), ";
        $query .= "(21, '12345678', 'Μπαμπης', 'Σουγιας', '6991234567', 'shortKnive@live.com', b'0', 'Καραισκακη 52', 61800, 'Κομοτηνή', 'Ν. Ροδόπης', '1989-05-05'), ";
        $query .= "(22, '12345678', 'Μαρια', 'Βελωνη', '6991234567', 'needle@live.com', b'0', 'Δημοκρατιας 9', 63000, 'Ματαλα', 'Ν. Ηρακλείου', '2000-04-07'), ";
        $query .= "(24, '12345678', 'Αννα', 'Κουτιδου', '6991234567', 'koutidou@mail.com', b'0', 'Σαλαμινας 79', 61900, 'Βόλος', 'Ν. Μαγνησίας', '2005-01-01'), ";
        $query .= "(28, '12345678', 'Ελενη', 'Μουρτακη', '6987654321', 'e.mourtakh@f', b'0', 'Δευκελειας 154', 61100, 'Αθηνα', 'Ν. Αττικής', '2002-02-13'), ";
        $query .= "(29, '12345678', 'Στεφανια', 'Γατου', '6987654321', 'stef@gmail.com', b'0', 'Αντιστασεως 68', 61100, 'Αθηνα', 'Ν. Αττικής', '2004-04-16'), ";
        $query .= "(30, '12345678', 'Σια', 'Μιαουνη', '6987654321', 'miaou@live.gr', b'0', 'Εγνατιας 116', 61100, 'Αθηνα', 'Ν. Αττικής', '2005-01-23'), ";
        $query .= "(31, '12345678', 'Δημητρης', 'Ποντικας', '6987654321', 'mouse@gmail.com', b'0', 'Βασ. Ολγας 251', 61100, 'Αθηνα', 'Ν. Αττικής', '1999-01-15'), ";
        $query .= "(33, '12345678', 'Στελιος', 'Κοκωνης', '6987654321', 'stel@live.com', b'0', 'Πατησιων 56', 61100, 'Αθηνα', 'Ν. Αττικής', '2001-01-16'); ";
        execQueryWithoutResultSet($query);
        
        

        $query  = "INSERT INTO `products` (`PRODCODE`, `PRODNAME`, `TYPECODE_FK`, `PRODDESCRIPTION`, `PRODPIC`, `PRODSTOCK`, `PRODVALUE`) VALUES ";
        $query .= "(9, 'Doggex Σνακ', 11, 'Σνακ σκύλου με Ω3, Ω4, Ω5 λιπαρά, κατάλληλα για ενήλικους σκύλους ως συμπλήρωμα διατροφής. ', 'doggex.jpg', 19, 7.6), ";
        $query .= "(10, 'Σκυλο-Μπαλάκι', 14, 'Παιχνίδι σκύλου μπάλα κόκκινη με μπλε διακοσμημένη με γατούλες, 16cm', 'skilobalex.jpg', 8, 5.3), ";
        $query .= "(11, 'Γιδοκονσέρβα', 10, 'Κονσέρβα σκύλου, πλήρες εκλεκτό γεύμα με κομμάτια από αρνάκι άσπρο και παχύ', 'gidokonserva.jpeg', 1, 14), ";
        $query .= "(12, 'Μοσχαροκροκέτες', 10, 'Κροκέτες με μοσχάρι για μικρόσωμες ράτσες με μέτρια δραστηριότητα, ηλικίας 1- 6 ετών.', 'mosxarokroketes.jpg', 22, 18.9), ";
        $query .= "(13, 'Redneck', 12, 'Περιλαίμιο σκύλου, κόκκινο με σχέδιο γάτα που κυνηγά σκύλο, xs, 15-23cm', 'redneck.jpg', 31, 4.9), ";
        $query .= "(14, 'Κοκκαλέξ', 14, 'Παιχνίδι σκύλου κόκκαλο μπλε, 12 cm, από μαλακό και ανθεκτικό υλικό.', 'kokkalex.jpg', 44, 2.5), ";
        $query .= "(15, 'Βρακέξ (20 τχ)', 13, 'Πάνα-βρακάκι σκύλου, με μεγάλη απορροφητικότητα και άρωμα δυόσμου, s, 20 τεμάχια', 'vrakeks.jpg', 55, 7.7), ";
        $query .= "(16, 'Mini sticks', 11, 'Mini sticks, λιχουδιά από μοσχάρι με χαμηλά λιπαρά και υψηλή θερμιδική αξία.', 'miniSticks.jpg', 1, 6), ";
        $query .= "(17, 'Πουλοβερεξ Σκύλου', 13, 'Ζεστό πουλόβερ σκύλου, ροζ πουά με στρας και σχέδιο κεραυνό, xl.', 'pullover.jpg', 1, 6.1), ";
        $query .= "(18, 'Τουμπανοκροκέτες (4kg)', 10, 'Κροκέτες ολοκληρωμένη και γευστική τροφή με κοτόπουλο και λαχανικά για ενήλικους σκύλους.', 'toumpanokroketes.jpg', 8, 28.7), ";
        $query .= "(19, 'Φτηνο-κολαρέξ', 12, 'Περιλαίμιο από υψηλής ποιότητας νάιλον με πλάτος 2,2cm και μήκος 39cm.', 'nailonPerilemio.jpg', 50, 2.1), ";
        $query .= "(20, 'Τουρμποκροκέτες (5 kg)', 10, 'Κροκέτες με βοδινό και μοσχάρι, πλήρης τροφή για σκύλους άνω των δέκα κιλών.', 'turbokroketes.jpg', 1, 49), ";
        $query .= "(21, 'Σκυλοπαιχνίδι Καρδιά', 14, 'Παιχνιδι για συναισθηματικούς σκύλους.', 'paixnidiSkilouKardia.jpeg', 1, 0.9), ";
        $query .= "(22, 'Σκυλοπαιχνίδι Σκαντζόχοιρος', 14, 'Ενας πολυτιμος πλην ακανθώδης φίλος για το κατοικίδιο σας.', 'PaixnidiSkilouSkantzoxoiros.jpeg', 30, 1.35), ";
        $query .= "(23, 'Mocdog', 10, 'Συνδυάζει καφέ εσπρέσσο με χοιρινή κροκέτα. Για σκύλους υποτονικούς που δεν ξυπνούν. Απαλό άρωμα.', 'mocdog.jpg', 35, 11), ";
        $query .= "(24, 'Skylo-news', 14, 'Είτε το πιστεύετε είτε όχι προσομοιώνει τον ήχο πραγματικής εφημερίδας. Καλό;', 'dogpaper.jpg', 15, 2.1) ";   
        execQueryWithoutResultSet($query);


        $query  = " INSERT INTO `ordershead` (`ORDERCODE`, `USERCODE_FK`, `ORDERDATE`, `STATE_FK`, `TOTALAMOUNT`, `TOTALVALUE`, `shipment_FK`, `payment_FK`, `COMMENT`) VALUES ";
        $query .= "(23, 11, '2020-03-05 02:26:25', 1, 10, 41.4, 2, 1, 'Visa, ωρες παραλαβης 6-8 μ.μ'), ";
        $query .= "(24, 11, '2020-03-18 02:27:37', 3, 3, 19.7, 1, 2, 'Αρ. Λογ:213/1234567'), ";
        $query .= "(25, 11, '2020-03-24 02:27:57', 2, 4, 75.6, 1, 1, NULL), ";
        $query .= "(26, 12, '2020-03-24 02:28:29', 1, 6, 13.6, 2, 2, 'Ωρες παραλαβής:6-9 μ.μ, Αρ.Λογ:979/123456'), ";
        $query .= "(27, 12, '2020-03-24 02:29:00', 4, 3, 13, 3, 2, 'Ωρες παραλαβής:6-9 μ.μ, Αρ.Λογ:979/123456,Ασσος Courier'), ";
        $query .= "(28, 11, '2020-03-24 02:29:49', 1, 10, 90.7, 1, 1, NULL), ";
        $query .= "(29, 14, '2020-03-25 00:01:15', 1, 7, 69.1, 3, 2, NULL), ";
        $query .= "(30, 14, '2020-03-25 00:01:31', 1, 1, 2.1, 2, 2, NULL), ";
        $query .= "(31, 14, '2020-03-25 00:01:50', 1, 5, 15.7, 1, 1, NULL), ";
        $query .= "(32, 12, '2020-03-25 00:02:18', 1, 6, 87.7, 2, 1, 'Ωρες παραλαβής:6-9 μ.μ'), ";
        $query .= "(33, 11, '2020-03-25 00:02:59', 1, 7, 26.2, 3, 1, NULL), ";
        $query .= "(34, 11, '2020-03-25 00:03:34', 1, 5, 13, 1, 2, 'Αρ. Λογ:213/1299567'), ";
        $query .= "(35, 12, '2020-03-25 00:24:37', 1, 6, 42.55, 2, 1, 'Ωρες παραλαβής:9-11 π.μ'), ";
        $query .= "(36, 12, '2020-03-25 00:24:50', 1, 1, 2.1, 1, 1, NULL), ";
        $query .= "(37, 14, '2020-03-25 00:25:24', 1, 4, 15.1, 3, 1, 'Ωρες παραλαβής:1-9 μ.μ,Βητα Courier'), ";
        $query .= "(38, 14, '2020-03-25 00:26:10', 1, 1, 1.35, 2, 2, NULL), ";
        $query .= "(39, 14, '2020-03-25 00:26:19', 1, 1, 4.9, 3, 2, NULL), ";
        $query .= "(40, 14, '2020-03-25 00:26:40', 1, 5, 36.1, 2, 2, NULL), ";
        $query .= "(41, 14, '2020-03-25 00:26:57', 1, 1, 1.35, 2, 1, 'Ωρες παραλαβής:12-3 μ.μ'), ";
        $query .= "(42, 11, '2020-03-25 00:27:23', 1, 4, 153.1, 1, 1, NULL), ";
        $query .= "(43, 11, '2020-03-25 00:28:02', 1, 1, 11, 1, 1, NULL), ";
        $query .= "(44, 11, '2020-04-06 00:28:19', 1, 4, 106.2, 1, 2, 'Αρ. Λογ:212/1277567'), ";
        $query .= "(45, 11, '2020-04-08 00:28:48', 1, 4, 39, 2, 1, 'Ωρες παραλαβής:7-9 μ.μ'), ";
        $query .= "(46, 11, '2020-04-10 00:29:18', 1, 2, 21.7, 1, 1, NULL), ";
        $query .= "(47, 15, '2020-04-12 04:40:30', 1, 5, 15.9, 2, 2, 'Ωρες παραλαβής:7-9 μ.μ, Αρ.Λογ:999/166456'), ";
        $query .= "(48, 15, '2020-04-13 04:41:02', 1, 13, 89, 1, 1, NULL), ";
        $query .= "(49, 12, '2020-04-13 22:17:56', 1, 4, 25.45, 1, 1, NULL), ";
        $query .= "(51, 11, '2020-04-14 20:43:15', 1, 5, 29.4, 3, 2, NULL), ";
        $query .= "(52, 11, '2020-04-18 18:04:31', 1, 2, 13.1, 3, 1, 'Ωρες παραλαβής:3-9 μ.μ,Ητα Courier'), ";
        $query .= "(53, 11, '2020-04-18 18:04:58', 1, 4, 24.7, 2, 2, 'Ωρες παραλαβής:5-7 μ.μ, Αρ.Λογ:179/123459'), ";
        $query .= "(54, 11, '2020-04-26 18:42:28', 1, 3, 4.8, 2, 1, 'Ωρες παραλαβής:6-10 μ.μ'), ";
        $query .= "(55, 11, '2020-04-26 18:42:54', 1, 8, 228.7, 1, 1, NULL), ";
        $query .= "(56, 15, '2020-04-26 18:44:19', 1, 8, 86.9, 1, 1, NULL), ";
        $query .= "(57, 15, '2020-04-26 18:44:47', 1, 6, 19.8, 3, 2, NULL), ";
        $query .= "(58, 14, '2020-04-26 18:45:40', 1, 5, 33, 3, 1, 'Ωρες παραλαβής:8-9 μ.μ,Βητα Courier'), ";
        $query .= "(59, 14, '2020-04-26 18:46:21', 1, 4, 64.8, 2, 1, 'Ωρες παραλαβής:8-10 μ.μ'), ";
        $query .= "(60, 14, '2020-04-26 18:46:37', 1, 2, 7, 1, 2, NULL), ";
        $query .= "(61, 14, '2020-04-26 18:47:07', 1, 4, 51.9, 1, 1, NULL), ";
        $query .= "(62, 11, '2020-04-26 18:47:46', 1, 4, 6.15, 3, 2, 'Ωρες παραλαβής:6-9 μ.μ,Βητα Courier'), ";
        $query .= "(63, 11, '2020-04-26 18:48:17', 1, 11, 93.9, 1, 1, NULL), ";
        $query .= "(64, 12, '2020-10-08 23:07:11', 1, 7, 38.25, 2, 1, 'Ωρες παραλαβής:4-6 μ.μ'), ";
        $query .= "(65, 12, '2020-10-09 20:43:44', 1, 4, 25.45, 1, 2, 'Αρ. Λογ:313/1234567'), ";
        $query .= "(66, 12, '2020-10-19 21:03:09', 1, 3, 4.05, 2, 2, 'τεστ'), ";
        $query .= "(67, 12, '2020-10-19 21:03:41', 1, 1, 2.1, 1, 1, ''), ";
        $query .= "(68, 11, '2020-10-24 15:35:29', 1, 4, 25.45, 2, 2, 'geia sou dhmo'), ";
        $query .= "(69, 12, '2020-10-25 16:35:49', 1, 4, 25.45, 1, 1, ''), ";
        $query .= "(70, 33, '2020-10-25 19:02:39', 1, 6, 59.2, 2, 2, ''), ";
        $query .= "(71, 33, '2020-10-25 19:03:09', 1, 5, 16.4, 3, 1, ''), ";
        $query .= "(72, 33, '2020-10-25 19:03:56', 1, 7, 53.5, 3, 1, 'Ωρες παραλαβής:8-9 μ.μ,Βητα Courier'), ";
        $query .= "(73, 29, '2020-10-25 19:10:43', 1, 7, 145.9, 1, 1, ''), ";
        $query .= "(74, 29, '2020-10-25 19:10:58', 1, 4, 25.45, 1, 2, 'Αρ. Λογ:313/1234567'), ";
        $query .= "(75, 29, '2020-10-25 19:12:56', 1, 4, 10.85, 1, 1, ''), ";
        $query .= "(76, 21, '2020-10-25 19:18:18', 1, 16, 122.8, 2, 1, 'Ωρες παραλαβής:4-6 μ.μ'), ";
        $query .= "(77, 21, '2020-10-25 19:18:34', 1, 1, 2.1, 1, 1, ''), ";
        $query .= "(78, 21, '2020-10-25 19:18:46', 1, 10, 81.05, 3, 2, 'Ωρες παραλαβής:6-9 μ.μ,Βητα Courier'), ";
        $query .= "(79, 11, '2020-10-25 19:19:04', 1, 4, 25.45, 1, 1, ''); ";
        execQueryWithoutResultSet($query);   


        $query  = "INSERT INTO `ordersdetail` (`ORDERCODE_FK`, `PRODCODE_FK`, `PRODQUANTITY`, `ORDERPRODVALUE`) VALUES ";
        $query .= "(23, 21, 4, 3.6), ";
        $query .= "(23, 22, 2, 2.7), ";
        $query .= "(23, 23, 3, 33), ";
        $query .= "(23, 24, 1, 2.1), ";
        $query .= "(24, 15, 1, 7.7), ";
        $query .= "(24, 16, 2, 12), ";
        $query .= "(25, 12, 4, 75.6), ";
        $query .= "(26, 17, 1, 6.1), ";
        $query .= "(26, 19, 1, 2.1), ";
        $query .= "(26, 22, 4, 5.4), ";
        $query .= "(27, 16, 1, 6), ";
        $query .= "(27, 17, 1, 6.1), ";
        $query .= "(27, 21, 1, 0.9), ";
        $query .= "(28, 22, 2, 2.7), ";
        $query .= "(28, 23, 8, 88), ";
        $query .= "(29, 11, 2, 28), ";
        $query .= "(29, 16, 1, 6), ";
        $query .= "(29, 23, 3, 33), ";
        $query .= "(29, 24, 1, 2.1), ";
        $query .= "(30, 24, 1, 2.1), ";
        $query .= "(31, 13, 2, 9.8), ";
        $query .= "(31, 14, 2, 5), ";
        $query .= "(31, 21, 1, 0.9), ";
        $query .= "(32, 12, 4, 75.6), ";
        $query .= "(32, 16, 1, 6), ";
        $query .= "(32, 17, 1, 6.1), ";
        $query .= "(33, 13, 2, 9.8), ";
        $query .= "(33, 22, 4, 5.4), ";
        $query .= "(33, 23, 1, 11), ";
        $query .= "(34, 17, 1, 6.1), ";
        $query .= "(34, 19, 1, 2.1), ";
        $query .= "(34, 22, 2, 2.7), ";
        $query .= "(34, 24, 1, 2.1), ";
        $query .= "(35, 15, 1, 7.7), ";
        $query .= "(35, 18, 1, 28.7), ";
        $query .= "(35, 22, 3, 4.05), ";
        $query .= "(35, 24, 1, 2.1), ";
        $query .= "(36, 19, 1, 2.1), ";
        $query .= "(37, 16, 1, 6), ";
        $query .= "(37, 17, 1, 6.1), ";
        $query .= "(37, 21, 1, 0.9), ";
        $query .= "(37, 24, 1, 2.1), ";
        $query .= "(38, 22, 1, 1.35), ";
        $query .= "(39, 13, 1, 4.9), ";
        $query .= "(40, 16, 2, 12), ";
        $query .= "(40, 23, 2, 22), ";
        $query .= "(40, 24, 1, 2.1), ";
        $query .= "(41, 22, 1, 1.35), ";
        $query .= "(42, 17, 1, 6.1), ";
        $query .= "(42, 20, 3, 147), ";
        $query .= "(43, 23, 1, 11), ";
        $query .= "(44, 17, 1, 6.1), ";
        $query .= "(44, 19, 1, 2.1), ";
        $query .= "(44, 20, 2, 98), ";
        $query .= "(45, 9, 2, 15.2), ";
        $query .= "(45, 12, 1, 18.9), ";
        $query .= "(45, 13, 1, 4.9), ";
        $query .= "(46, 11, 1, 14), ";
        $query .= "(46, 15, 1, 7.7), ";
        $query .= "(47, 16, 2, 12), ";
        $query .= "(47, 21, 2, 1.8), ";
        $query .= "(47, 24, 1, 2.1), ";
        $query .= "(48, 10, 5, 26.5), ";
        $query .= "(48, 14, 3, 7.5), ";
        $query .= "(48, 23, 5, 55), ";
        $query .= "(49, 22, 1, 1.35), ";
        $query .= "(49, 23, 2, 22), ";
        $query .= "(49, 24, 1, 2.1), ";
        $query .= "(51, 9, 2, 15.2), ";
        $query .= "(51, 16, 1, 6), ";
        $query .= "(51, 17, 1, 6.1), ";
        $query .= "(51, 24, 1, 2.1), ";
        $query .= "(52, 23, 1, 11), ";
        $query .= "(52, 24, 1, 2.1), ";
        $query .= "(53, 22, 2, 2.7), ";
        $query .= "(53, 23, 2, 22), ";
        $query .= "(54, 22, 2, 2.7), ";
        $query .= "(54, 24, 1, 2.1), ";
        $query .= "(55, 12, 4, 75.6), ";
        $query .= "(55, 17, 1, 6.1), ";
        $query .= "(55, 20, 3, 147), ";
        $query .= "(56, 11, 5, 70), ";
        $query .= "(56, 13, 1, 4.9), ";
        $query .= "(56, 16, 2, 12), ";
        $query .= "(57, 10, 3, 15.9), ";
        $query .= "(57, 21, 2, 1.8), ";
        $query .= "(57, 24, 1, 2.1), ";
        $query .= "(58, 9, 3, 22.8), ";
        $query .= "(58, 14, 1, 2.5), ";
        $query .= "(58, 15, 1, 7.7), ";
        $query .= "(59, 10, 1, 5.3), ";
        $query .= "(59, 18, 2, 57.4), ";
        $query .= "(59, 19, 1, 2.1), ";
        $query .= "(60, 17, 1, 6.1), ";
        $query .= "(60, 21, 1, 0.9), ";
        $query .= "(61, 12, 1, 18.9), ";
        $query .= "(61, 23, 3, 33), ";
        $query .= "(62, 22, 3, 4.05), ";
        $query .= "(62, 24, 1, 2.1), ";
        $query .= "(63, 13, 2, 9.8), ";
        $query .= "(63, 16, 2, 12), ";
        $query .= "(63, 17, 1, 6.1), ";
        $query .= "(63, 23, 6, 66), ";
        $query .= "(64, 21, 2, 1.8), ";
        $query .= "(64, 22, 1, 1.35), ";
        $query .= "(64, 23, 3, 33), ";
        $query .= "(64, 24, 1, 2.1), ";
        $query .= "(65, 22, 1, 1.35), ";
        $query .= "(65, 23, 2, 22), ";
        $query .= "(65, 24, 1, 2.1), ";
        $query .= "(66, 22, 3, 4.05), ";
        $query .= "(67, 24, 1, 2.1), ";
        $query .= "(68, 22, 1, 1.35), ";
        $query .= "(68, 23, 2, 22), ";
        $query .= "(68, 24, 1, 2.1), ";
        $query .= "(69, 22, 1, 1.35), ";
        $query .= "(69, 23, 2, 22), ";
        $query .= "(69, 24, 1, 2.1), ";
        $query .= "(70, 10, 2, 10.6), ";
        $query .= "(70, 15, 1, 7.7), ";
        $query .= "(70, 17, 2, 12.2), ";
        $query .= "(70, 18, 1, 28.7), ";
        $query .= "(71, 9, 1, 7.6), ";
        $query .= "(71, 14, 1, 2.5), ";
        $query .= "(71, 19, 3, 6.3), ";
        $query .= "(72, 9, 1, 7.6), ";
        $query .= "(72, 11, 2, 28), ";
        $query .= "(72, 13, 2, 9.8), ";
        $query .= "(72, 16, 1, 6), ";
        $query .= "(72, 24, 1, 2.1), ";
        $query .= "(73, 13, 1, 4.9), ";
        $query .= "(73, 17, 2, 12.2), ";
        $query .= "(73, 18, 1, 28.7), ";
        $query .= "(73, 19, 1, 2.1), ";
        $query .= "(73, 20, 2, 98), ";
        $query .= "(74, 22, 1, 1.35), ";
        $query .= "(74, 23, 2, 22), ";
        $query .= "(74, 24, 1, 2.1), ";
        $query .= "(75, 15, 1, 7.7), ";
        $query .= "(75, 21, 2, 1.8), ";
        $query .= "(75, 22, 1, 1.35), ";
        $query .= "(76, 9, 1, 7.6), ";
        $query .= "(76, 10, 5, 26.5), ";
        $query .= "(76, 11, 1, 14), ";
        $query .= "(76, 12, 2, 37.8), ";
        $query .= "(76, 13, 3, 14.7), ";
        $query .= "(76, 14, 1, 2.5), ";
        $query .= "(76, 15, 1, 7.7), ";
        $query .= "(76, 16, 2, 12), ";
        $query .= "(77, 24, 1, 2.1), ";
        $query .= "(78, 22, 3, 4.05), ";
        $query .= "(78, 23, 7, 77), ";
        $query .= "(79, 22, 1, 1.35), ";
        $query .= "(79, 23, 2, 22), ";
        $query .= "(79, 24, 1, 2.1) ";
        execQueryWithoutResultSet($query);

                
        //$success = execQueryWithoutResultSet($query);
        //$successend = true;
        return true;
    }
?>
