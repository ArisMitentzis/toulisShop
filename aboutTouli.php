<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>
<?php include "scripts\\driver.php" ?>
<?php // include "scripts\\driver_account.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts\\menu_admin.php";
    } 
?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
    <h2 class="font-weight-bolder mx-auto   pl-4" style="width:800px"><pre>                 About Touli the cat</pre></h2>
             
        <div class="jumbotron mx-auto mjr-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:450px;width:1150px;background-color:#e9d28c;overflow-y: scroll;">
            
        <pre>
        This is the story of Toulis, the little cat that struggled to survive or maybe not...
        
        The story will be released soon...
        </pre>   
                     
        </div>
            
        <div class="row">         
            <div class="col-1"></div>
            <div class="col-10 ml-3"><a href="index.php" class="mx-auto"><button type="button" class="btn btn-secondary ml-n4  ">Επιστροφή</button></a></div>
        </div>
        
    
</div>

<?php include "scripts\\footer.php" ?>

<script src="js\\ajaxCaller.js"></script>
<script src="js\\initiateDB.js"></script>