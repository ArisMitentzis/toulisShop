<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>
<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_edit_product.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>
<?php include "scripts\\menu_admin.php" ?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:450px"><pre>     Επεξεργασία Προϊόντος</pre></h2>
        
<?php if (UserType::$userType == UserType::admin && isset($_GET['act'])) { 
?>
        <form action="edit_product.php" method="post">
        
<!--            <div class="row mt-4 pt-3" style="height 700">-->
           
            <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:950px;width:800px;background-color:#e9d28c;">
            
				<div class="col-2"></div>
				
				<div class="col-9 ml-4  ">
					<div class="mx-auto pl-5 form-group ">
                        
                    <div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">  
						<div class="custom-control-inline">
								<label for="prodCode" class="mr-1">Κωδικός Προϊόντος</label>
								<input type="text" class="form-control mr-2" id="prodCode" name="prodCode" style="width:50px" value="<?php echo $selectedProduct['PRODCODE'];?>" required>
						</div>
                    </div>
                       
						<?php echoProductForm(true,$selectedProduct);?>
                        
						<div class="row mt-3">
							<div class="col-2 ">
							</div>
							<div class="col-10">
								<button type="submit" class="btn btn-secondary ml-5" name="editProduct">Επεξεργασία</button>
								<a href="list_delete_product.php">
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
           
              $success = $successEdit;
          
              $successTitle = 'ανανέωση του προιόντος';
              $successMessage = null;
              $successLinksArray = [];
              $successLinksArray[0]= 'index.php';
              $successLinksArray[1]= 'list_delete_product.php';
              $successLinkTitlesArray = [];
              $successLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
              $successLinkTitlesArray[1]= 'Πατήστε εδώ για να ανανεώσετε κι άλλο προϊόν.';
            
              $failTitle = 'ανανέωσης του προιόντος';
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
</div>

<script src="js\\fileChooser.js"></script>
<script src="js\\validate2.js"></script>
 <script src="js\\validate_textarea.js"></script>

<?php include "scripts\\footer.php" ?>