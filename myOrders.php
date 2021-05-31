<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>
<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_myOrders.php" ?>


<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts\\menu_admin.php";
    } 
?>


<div id="tableDiv" data-userCode="<?php echo UserType::$userCode;?>" class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:600px"><pre>     Λίστα των Παραγγελιών μου</pre></h2>
        
            <table id="myOrdersTable" class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>κωδ.</th>
                    <th>Ημερομηνία</th>
                    <th>Ποσότητα</th>
                    <th>Τιμή</th>
                    <th>Κατάσταση</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php echoMyOrdersById(-1,UserType::$userCode);?>
                </tbody>
          </table>
    
    <?php // tupwse to pagination gia ta pop products
               // To $currentPageIndex dinetai 0 dioti ta pages aforoyn to prwto index?>
    <?php //echoPagination($pagesKeyArray,$pagesValueArray,0,$maxPage,$currentUrl,$typeKey,$typeValue,'myOrders');?>
       
    <a href="menu_account.php"><button class="btn btn-secondary">Επιστροφή</button></a>  
</div>



<?php include "scripts\\footer.php" ?>


<!--   To scriptaki pou einai upeuthino gia to pagination     -->
    <script src="js\\pagination_allOrders.js"></script>

<script src="js\\ajaxCaller.js"></script>
<script src="js\\datatable.js"></script>