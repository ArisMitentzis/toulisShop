<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>
<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_add_product.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>
<?php include "scripts\\menu_admin.php" ?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:450px"><pre>     Προσθήκη Προϊόντος</pre></h2>
        
<?php if (! isset($_POST['createProduct'])) { 
?>
        <form action="add_product.php" method="post">
        
<!--            <div class="row mt-4 pt-3" style="height 700">-->
            
            <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:850px;width:800px;background-color:#e9d28c;">
            
				<div class="col-2"></div>
				
				<div class="col-9 ml-4  ">
					<div class="mx-auto pl-5 form-group ">
                        
                       <?php echoProductForm(false,null); ?>
						
						<div class="row mt-3">
							<div class="col-2 ">
							</div>
							<div class="col-10">
								<button type="submit" class="btn btn-secondary ml-5" name="createProduct">Δημιουργία</button>
								<a href="index.php">
								    <button type="button" class="btn btn-secondary ml-5">Ακύρωση</button>
								</a>
							</div>
						</div>
					</div>
				</div>
<!--                <div id="board">................board....................</div>-->
            </div>
        </form>
<?php
    }
    else { 
           
          $success = $successCreate;
          
          $successTitle = 'δημιουργία του προιόντος';
          $successMessage = null;
          $successLinksArray = [];
          $successLinksArray[0]= 'index.php';
          $successLinksArray[1]= 'add_product.php';
          $successLinkTitlesArray = [];
          $successLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
          $successLinkTitlesArray[1]= 'Πατήστε εδώ για να προσθέσετε κι άλλο προϊόν.';
            
          $failTitle = 'δημιουργία του προιόντος';
          $failMessage =null;
          $failLinksArray = [];
          $failLinksArray[0]= 'index.php';
          $failLinksArray[1]= 'add_product.php';
          $failLinkTitlesArray = [];
          $failLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
          $failLinkTitlesArray[1]= 'Πατήστε εδώ για να επιχειρήσετε ξανά.';
           echoAttemptMessage($success,$successTitle,$successMessage,$successLinksArray,$successLinkTitlesArray,$failTitle,$failMessage,$failLinksArray,$failLinkTitlesArray);
        } 
?>  
        
</div>



<script> setLinkActive('adm1')</script>
<script src="js\\fileChooser.js"></script>
<script src="js\\validate2.js"></script>
 <script src="js\\validate_textarea.js"></script>

<?php include "scripts\\footer.php" ?>