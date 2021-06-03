<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver.php" ?>
<?php include "scripts/driver_account.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts/menu_admin.php";
    } 
?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
    <h2 class="font-weight-bolder mx-auto   pl-4" style="width:550px"><pre>       Επιλογές Λογαριασμού</pre></h2>
             
        <div class="jumbotron mx-auto mjt-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:200px;width:540px;background-color:#e9d28c;">
            
           <div class="row">         
                    <a href="account.php" class="mx-auto" style="text-decoration:none;">
                        <p class="font-weight-bold">Πατήστε εδώ για να επεξεργαστείτε τον λογαριασμό σας.</p>
                    </a>
                </div>
                
                <div class="row mt-4">         
                    <a href="myOrders.php" class="mx-auto" style="text-decoration:none;">
                        <p class="font-weight-bold">Πατήστε εδώ για να δείτε τις παραγγελίες σας.</p>
                    </a>
                </div>  
                     
        </div>
            
        <div class="row">         
            <div class="col-3"></div>
            <div class="col-8 ml-3"><a href="index.php" class="mx-auto"><button type="button" class="btn btn-secondary ml-n4  ">Επιστροφή</button></a></div>
        </div>
        
    
</div>

<?php include "scripts/footer.php" ?>