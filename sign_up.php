<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>

<?php include "scripts/driver_sign_up.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
     
    <h2 class="font-weight-bolder mx-auto  pl-4" style="width:150px">Sign up</h2>
        
<?php if (! isset($_POST['createUser'])) { ?>
    
        <form action="sign_up.php" method="post">
        
<!--            <div class="row mt-4 pt-3" style="height 700">-->
            
             <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:770px;width:800px;background-color:#e9d28c;">
            
				<div class="col-2"></div>
				
				<div class="col-9 ml-4  ">
					<div class="mx-auto ml-3 form-group" style="width:600px">
                        
					<?php echoAccountForm(false);?>	
                        
						<div class="row mpt-4">
							<div class="col-2 ">
							</div>
							<div class="col-10">
								<button type="submit" class="btn btn-secondary ml-5" name="createUser">Δημιουργία</button>
								<a href="index.php">
								    <button type="button" class="btn btn-secondary ml-5">Ακύρωση</button>
								</a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </form>

<?php    
        }
        else { 
                 
              $success = ! $emailAlreadyExists;
          
              $successTitle = 'εγγραφή';
              $successMessage = 'Μπορείτε να συνδεθείτε δίνοντας το email σας και τον κωδικό σας.';
              $successLinksArray = [];
              $successLinksArray[0]= 'sign_in.php';
              $successLinksArray[1]= 'index.php';
              $successLinkTitlesArray = [];
              $successLinkTitlesArray[0]= 'Πατήστε εδώ για να συνδεθείτε.';
              $successLinkTitlesArray[1]= 'Πατήστε εδώ για να συνεχίσετε ως guest.';
            
              $failTitle = 'εγγραφης';
              $failMessage ='Υπάρχει ήδη εγγεγραμμένος χρήστης για το email ' .  $_POST['email'] . '.';
              $failLinksArray = [];
              $failLinksArray[0]= 'sign_up.php';
              $failLinksArray[1]= 'sign_in.php';
              $failLinksArray[2]= 'index.php';
              $failLinkTitlesArray = [];
              $failLinkTitlesArray[0]= 'Πατήστε εδώ για να εγγραφείτε.';
              $failLinkTitlesArray[1]= 'Πατήστε εδώ για να συνδεθείτε.';
              $failLinkTitlesArray[2]= 'Πατήστε εδώ για να συνεχίσετε ως guest.';
              
             echoAttemptMessage($success,$successTitle,$successMessage,$successLinksArray,$successLinkTitlesArray,$failTitle,$failMessage,$failLinksArray,$failLinkTitlesArray); 

            } 
?> 
         
</div>

<script src="js/validate2.js"></script>

<?php include "scripts/footer.php" ?>