<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver.php" ?>
<?php include "scripts/driver_list_delete_product.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>
<?php include "scripts/menu_admin.php" ?>


<div id="tableDiv" class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:450px"><pre>     Λίστα Προϊόντων</pre></h2>
        
<?php if (! isset($_GET['act'])) { 
?>
        <form action="add_product.php" method="post">
            <table id="productTable" class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>κωδ.</th>
                    <th>Προϊόν</th>
                    <th>Τύπος</th>
                    <th>Ποσότητα</th>
                    <th>Τιμή</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php //echoAllProductsByCategoryAndName($page);?>
                  <?php echoAllProductsByCategoryAndName(-1);?>
                </tbody>
          </table>
        </form>
    
        <?php // tupwse to pagination gia ta pop products
               // To $currentPageIndex dinetai 0 dioti ta pages aforoyn to prwto index?>
          <?php //echoPagination($pagesKeyArray,$pagesValueArray,0,$maxPage,$currentUrl,$typeKey,$typeValue,'list_delete_product');?>
       
    
<?php
        }
        else { 
           
              $success = $successfulDelete;
          
              $successTitle = 'διαγραφή του προϊόντος';
              $successMessage = null;
              $successLinksArray = [];
              $successLinksArray[0]= 'index.php';
              $successLinksArray[1]= 'list_delete_product.php';
              $successLinkTitlesArray = [];
              $successLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
              $successLinkTitlesArray[1]= 'Πατήστε εδώ για να διαγράψετε κι άλλο προϊόν.';
            
              $failTitle = 'διαγραφής του προϊόντος';
              $failMessage =null;
              $failLinksArray = [];
              $failLinksArray[0]= 'index.php';
              $failLinksArray[1]= 'list_delete_product.php';
              $failLinkTitlesArray = [];
              $failLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
              $failLinkTitlesArray[1]= 'Πατήστε εδώ για να επιχειρήσετε ξανά.';
              echoAttemptMessage($success,$successTitle,$successMessage,$successLinksArray,$successLinkTitlesArray,$failTitle,$failMessage,$failLinksArray,$failLinkTitlesArray);
        } 
?> 
    
<!--    <div id="board">................board....................</div>-->
    
</div>

<script> setLinkActive('adm2')</script>

<!--   To scriptaki pou einai upeuthino gia to pagination     -->
    <script src="js/pagination_allOrders.js"></script>

    <script src="js/deleteProduct.js"></script>

<script src="js/ajaxCaller.js"></script>
<script src="js/datatable.js"></script>

<?php include "scripts/footer.php" ?>