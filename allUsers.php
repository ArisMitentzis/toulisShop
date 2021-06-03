<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver.php" ?>
<?php include "scripts/driver_allUsers.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>
<?php include "scripts/menu_admin.php" ?>


<div id="tableDiv" class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:600px"><pre>           Λίστα Χρηστών</pre></h2>
        
            <table id="usTable" class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>κωδικός</th>
                    <th>Επίθετο</th>
                    <th>Όνομα</th>
                    <th>Κινητό</th>
                    <th>Email</th>
                    <th>Διεύθυνση</th>
                    <th>Τ.Κ</th>
                    <th>Πόλη</th>
                    <th>Νομός</th>
                    <th>Γέννηση</th>
                  </tr>
                </thead>
                <tbody>
                  <?php echoAllUsersByLastName(-1);?>
                </tbody>
          </table>
          
    <?php // tupwse to pagination gia ta pop products
               // To $currentPageIndex dinetai 0 dioti ta pages aforoyn to prwto index?>
          <?php //echoPagination($pagesKeyArray,$pagesValueArray,0,$maxPage,$currentUrl,$typeKey,$typeValue,'allUsers');?>

       
<!--    <a href="index.php"><button class="btn btn-secondary">Επιστροφή</button></a>  -->
</div>


<script> setLinkActive('adm4')</script>

<!--   To scriptaki pou einai upeuthino gia to pagination     -->
    <script src="js/pagination_allOrders.js"></script>

<script src="js/ajaxCaller.js"></script>
<script src="js/datatable.js"></script>

<?php include "scripts/footer.php" ?>