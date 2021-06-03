
<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>

<?php include "scripts/driver.php" ?>
<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>

<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts/menu_admin.php";
    } 
?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
   <h2 class="font-weight-bolder mx-auto  pl-4 mjt-5" style="width:300px"><pre>Στατιστικά</pre></h2>
   
    <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:900px;width:800px;background-color:#e9d28c;">
               
        <h4 class="font-weight-bolder allign-left mt-n5" style="width:300px">Τζίρος</h4>
        <br/>        
        <table class="table table-bordered mt-n4" style="border:2px solid black;">
            <thead class="thead-dark">
              <tr>
                <th>Τζίρος τρέχουσας ημέρας</th>
                <th>Τζίρος τρέχουσας εβδομάδας</th>
                <th>Τζίρος τρέχοντος μήνα</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo getTurnover('today'); ?></td>
                <td><?php echo getTurnover('week'); ?></td>
                <td><?php echo getTurnover('month'); ?></td>
              </tr>
            </tbody>
        </table>
               
        <br><br><br>
                
<!--    </div>	-->
    
<!--    <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:400px;width:800px;background-color:#e9d28c;">-->
               
        <h4 class="font-weight-bolder allign-left mt-n5" style="width:500px">Δημοφιλέστερα Προϊόντα</h4>
        <br/>        
        <table class="table table-bordered mt-n4" style="border:2px solid black;">
            <thead class="thead-dark">
              <tr>
                <th>Κωδικός Προϊόντος</th>
                <th>Όνομα Προϊόντος</th>
                <th>Πωλήσεις</th>
              </tr>
            </thead>
            <tbody>
                 <?php echo5MostSaleProducts();?>
            </tbody>
        </table>
        <br><br><br>        
<!--    </div>	-->
    
<!--    <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:300px;width:800px;background-color:#e9d28c;">-->
               
        <h4 class="font-weight-bolder allign-left mt-n5" style="width:300px">Καλύτεροι Πελάτες</h4>
        <br/>        
        <table class="table table-bordered mt-n4" style="border:2px solid black;">
            <thead class="thead-dark">
              <tr>
                <th>Κωδικός</th>
                <th>Επώνυμο</th>
                <th>Όνομα</th>
                <th>Κατανάλωση</th>
              </tr>
            </thead>
            <tbody>
              <?php echoTop3Customers();?>
            </tbody>
        </table>
                
    </div>	
    
</div>

<script> setLinkActive('adm5')</script>

<?php include "scripts/footer.php" ?>