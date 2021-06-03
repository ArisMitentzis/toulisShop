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
	
    <?php //echo UserType::$userTk;?>
    <h2 class="font-weight-bolder mx-auto   pl-4" style="width:550px"><pre>    Διαχείριση Λογαριασμού</pre></h2>
        
<?php if (!isset($_POST['update']) && !isset($_POST['delete'])) { ?>
    
        <form action="account.php" method="post">
        
<!--            <div class="row mt-4 pt-3" style="height 700">-->
            
            <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:770px;width:800px;background-color:#e9d28c;">
            
				<div class="col-2"></div>
				
				<div class="col-9 ml-4  ">
					<div class="mx-auto ml-3 form-group">
                        
                        <?php echoAccountForm(true);?>
						
						
						<div class="row mt-3">
							<div class="col-1 ">
							</div>
							<div class="col-10">
								<button type="submit" class="btn btn-secondary mκl-3" name="update">Τροποποίηση</button>
								<a href="menu_account.php">
								    <button type="button" class="btn btn-secondary ml-4">Επιστροφή</button>
								</a>
								<button type="submit" class="btn btn-secondary ml-4" name="delete">Διαγραφή</button>
							</div>
						</div>
					</div>
				</div>
            </div>
        </form>
<?php 
        }
        else {
           
              if ((isset($_POST['update']))){
                  
                    $success = true;
          
                    $successTitle = 'ανανέωση των στοιχείων';
                    $successMessage = null;
                    $successLinksArray = [];
                    $successLinksArray[0]= 'index.php';
                    $successLinkTitlesArray = [];
                    $successLinkTitlesArray[0]= 'Πατήστε εδώ για να συνεχίσετε.';
            
                    $failTitle = null;
                    $failMessage =null;
                    $failLinksArray = [];
                    $failLinkTitlesArray = [];
             }
            
             elseif (isset($_POST['delete'])) {
                  
                    $success = true;
          
                    $successTitle = 'διαγραφή';
                    $successMessage = null;
                    $successLinksArray = [];
                    $successLinksArray[0]= 'sign_in.php';
                    $successLinksArray[1]= 'index.php';
                    $successLinkTitlesArray = [];
                    $successLinkTitlesArray[0]= 'Πατήστε εδώ για να συνδεθείτε.';
                    $successLinkTitlesArray[1]= 'Πατήστε εδώ για να συνεχίσετε ως guest.';
            
                    $failTitle = null;
                    $failMessage = null;
                    $failLinksArray = [];
                    $failLinkTitlesArray = [];
             }
            echoAttemptMessage($success,$successTitle,$successMessage,$successLinksArray,$successLinkTitlesArray,$failTitle,$failMessage,$failLinksArray,$failLinkTitlesArray); 

      }  
?>   
       
</div>

<?php include "scripts/footer.php" ?>

<script src="js/validate2.js"></script>