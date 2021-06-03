<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver.php" ?>
<?php include "scripts/driver_ordersDetails.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts/menu_admin.php";
    } 
?>


<div class="container-width mt-2" style="height:1200px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-2" style="width:1150px"><pre>     Ανάλυση Παραγγελίας με κωδικό:<?php echo $orderCode;?><?php if ($for != '') {echo ", για τον πελάτη " . $for;}?></pre></h2>
        
        
            <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>κωδ.</th>
                    <th>Όνομα</th>
                    <th>Ποσότητα</th>
                    <th>Αξια</th>
                    <?php if ($allFlag){?> 
                    <th>Στοκ</th>
                    <?php }?>
                  </tr>
                </thead>
                <tbody>
                  <?php echoMySpecificOrderDetails( $orderCode,$allFlag);?>
                </tbody>
          </table>
        <br>
<?php
        $currentExecQueryResultObject = fetchOrderHeadOthers($orderCode);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echo5MostSaleProducts -- tha kanw kati smarter soon edw!');
        }
        
        $row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet);
    
?>
    <div class="custom-control-inline mb-2">
        <label for="firstName" class="mr-1">Αποστολή</label>
        <input type="text" class="form-control ml-2" id="firstName" style="width:260px" value="<?php echo $row['shortShip'];?>" required readonly>
        <label for="lastName" class="ml-5">Πληρωμή</label>
        <input type="text" class="form-control ml-2" id="lastName" style="width:260px" value="<?php echo $row['shortPay'];?>" required readonly>
    </div>
    <div class="row mt-2 ml-1">
        <label for="comment">Σχόλια</label>
        <textarea class="ml-4" id="comment" rows="2"  cols="75" readonly><?php echo $row['comment'];?></textarea>
    </div>
    <br><br>
    <a href="<?php echo "$returnButton";?>.php"><button class="btn btn-secondary">Επιστροφή</button></a>  
</div>

<?php include "scripts/footer.php" ?>


<script src="js/orderDetails.js"></script>