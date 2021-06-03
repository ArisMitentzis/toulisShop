<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver.php" ?>
<?php include "scripts/driver_allOrders.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>
<?php include "scripts/menu_admin.php" ?>


<div id="tableDiv" class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:600px"><pre>     Λίστα όλων των Παραγγελιών</pre></h2>
        
            <table id="ordersTable" class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>Πελάτης</th>
                    <th>Κωδ. Παραγγελίας</th>
                    <th>Ημερομηνία</th>
                    <th>Ποσότητα</th>
                    <th>Τιμή</th>
                    <th>Κατάσταση</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php echoAllOrders(-1);?>
                </tbody>
          </table>
<!--          <b>test</b>-->
          <?php // tupwse to pagination gia ta pop products
               // To $currentPageIndex dinetai 0 dioti ta pages aforoyn to prwto index?>
          <?php //echoPagination($pagesKeyArray,$pagesValueArray,0,$maxPage,$currentUrl,$typeKey,$typeValue,'allOrders');?>
    <br> 
<!--    <a href="menu_account.php"><button class="btn btn-secondary">Επιστροφή</button></a>  -->
<!--    <div id="board">................board....................</div>-->
</div>

<script> setLinkActive('adm3')</script>

<?php include "scripts/footer.php" ?>

<!--   To scriptaki pou einai upeuthino gia to pagination     -->
    <script src="js/pagination_allOrders.js"></script>

<script src="js/ajaxCaller.js"></script>
<script src="js/datatable.js"></script>
<script src="js/orderState.js"></script>