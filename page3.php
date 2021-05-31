<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>
<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_page3.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts\\menu_admin.php";
    } 
?>
	
	<div class="container-width mt-3" style="height:1100px;background-color:#e9d28c">
		
		<div class="row mt-2 mb-5" style="height:440px;">
		
<?php 
    if (! isset($_POST['cartSubmit'])) {
?>
			<!--το αριστερό column που περιέχει τον πίνακα με τα περιεχόμενα του καλαθιού -->
			<div class="col-5 border border-dark border-top-0 border-bottom-0 border-left-0 mr-5">
				<h4 class="font-weight-bolder ">Περιεχόμενα στο καλάθι</h4>
				<br>
				<table class="table table-sm table-striped ml-n3 mt-n2">
					<thead class="thead-dark">
						<tr>
							<th>Προϊόν</th>
							<th style="width:60px;">Τιμή</th>
							<th>Ποσότ.</th>
							<th>Σύνολο</th>
							<th>Del</th>
							<th>Edt</th>
						</tr>
					</thead>
					<tbody>
						<?php echoCartContent(); ?>
					</tbody>
				</table>
				<p class="tiny mt-n3 float-right ml-n5 pr-3">
					<br>
					<b id="totalValue" data-totalValue="<?php echo calcCartHeadAmountOrValue(2)?>">Κόστος Παραγγελίας: <?php echo calcCartHeadAmountOrValue(2)?> €</b>
				</p>
                <br><br>
                <div id ="totalValue_msg" class="mt-n3" style="text-align:right; display:none; color:red;">Δεν έχετε επιλέξει κανένα προϊον!</div>
			</div>
			
			<!--το δεξί column που περιέχει τη φόρμα που αφορά αποστολή και πληρωμή παραγγελίας -->
			<div class="col-6 ml-n2">
				<h4 class="font-weight-bolder mb-3 ">Αποστολή και πληρωμή</h4>
				<form action="page3.php" method="post">
					<div class="form-group">
						<div class="custom-control-inline mb-2">
								<label for="firstName" class="mr-1">Όνομα</label>
								<input type="text" class="form-control mr-2" id="firstName" name="firstName" style="width:260px" value="<?php echo UserType::$userFirst?>" readonly>
								<label for="lastName" class="mr-1">Επώνυμο</label>
								<input type="text" class="form-control" id="lastName" name="lastName" style="width:260px" value="<?php echo UserType::$userLast?>" readonly>
						</div>
						<div class="custom-control-inline mb-2">
								<label for="mobileNumber" class="mr-1">Κινητό</label>
								<input type="text" class="form-control mr-2" id="mobileNumber" name="mobileNumber" style="width:260px" value="<?php echo UserType::$userMobile;?>" readonly>
								<label for="email" class="pl-1 ml-4 mr-1">Email</label>
								<input type="text" class="form-control" id="email" name="email" style="width:260px" value="<?php echo UserType::$userEmail ;?>" readonly>
						</div>
						<div class="custom-control-inline mb-2 ml-n4 pr-1">
								<label class="mr-1">Διεύθυνση</label>
								<input type="text" class="form-control mr-1" id="adress" name="adress" style="width:170px" placeholder="Οδός, Αριθμός" value="<?php echo UserType::$userAdress ;?>" readonly>
								<input type="text" class="form-control mr-1" id="tk" name="tk" style="width:80px" placeholder="Τ.Κ" value="<?php echo UserType::$userTk ;?>" readonly>
								<input type="text" class="form-control mr-1" id="city" name="city" style="width:170px" placeholder="Πόλη/Περιοχή" value="<?php echo UserType::$userCity; ;?>" readonly>
								<input type="text" class="form-control" id="nomos" name="nomos" value="<?php echo UserType::$userNomos ;?>" style="width:170px" readonly>
						</div>
						<div class="row">
							<div class="col-2 ml-n4">
								Αποστολή
							</div>
							<div class="col-10 ml-n2">
                               <?php echoRadioButtons('shipment');?>	
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-2 ml-n4">
								Πληρωμή
							</div>
							<div class="col-10 ml-n2">
								<?php echoRadioButtons('payment');?>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-2 ml-n4">
								<label for="comment">Σχόλια</label>
							</div>
							<div class="col-10 ml-n2">
								<textarea data-limit="50" id="comment" name="comment"  rows="2"  cols="75"
									placeholder="π.χ Διαθεσιμότητα για ημερομηνία και ώρα παράδοσης"></textarea>
							</div>
                            <br>
                          <span id ="prodDescription_count" class="ml-5 pl-5" style="color:red;"></span>
						</div>
						<div class="row mt-2">
							<div class="col-1 ">
							</div>
							<div class="col-11">
								<div class="form-check">
									<label class="form-check-label ml-3" for="agree">
										<input type="checkbox" class="form-check-input" id="agree" name="agree" value="y">
										Συμφωνώ με τους όρους χρήσης και την πολιτική απορρήτου
									</label>
                                    <span id ="agree_msg" class="" style="display:none;color:red;">Πρέπει να συμφωνήσετε εδώ!</span>
								</div>
							</div>
						</div>
                        <br>
						<div class="row mt-2">
							<div class="col-2 ">
							</div>
							<div class="col-10">
								<button type="submit" class="btn btn-secondary ml-5" name="cartSubmit">Υποβολή</button>
                                <a href="index.php"><button type="button" class="btn btn-secondary ml-4">Επιστροφή</button></a>
							</div>
						</div>
					</div>
				</form>	
			</div>
<!--		</div>-->
		
<?php 
     }
     else {
                  
            $success = $registerSuccess;
          
            $successTitle = 'παραγγελία';
            $successMessage = null;
            $successLinksArray = [];
            $successLinksArray[0]= 'index.php';
            $successLinksArray[1]= 'myOrders.php';
            $successLinkTitlesArray = [];
            $successLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
            $successLinkTitlesArray[1]= 'Πατήστε εδώ για τις παραγγελίες.';
            
            $failTitle = 'παραγγελίας';
            $failMessage =null;
            $failLinksArray = [];
            $failLinksArray[0]= 'index.php';
            $failLinksArray[1]= 'page3.php';
            $failLinkTitlesArray = [];
            $failLinkTitlesArray[0]= 'Πατήστε εδώ για την αρχική σελίδα.';
            $failLinkTitlesArray[1]= 'Πατήστε εδώ για να επιχειρήσετε ξανά.';
           echoAttemptMessage($success,$successTitle,$successMessage,$successLinksArray,$successLinkTitlesArray,$failTitle,$failMessage,$failLinksArray,$failLinkTitlesArray);  
     }
?>	
      </div>
        
<!--       <div id="board">board</div> -->
        
	</div>
	
	<?php include "scripts\\footer.php" ?>

    <script src="js\\ajaxCaller.js"></script>

    <script src="js\\editCortSum.js"></script>
    <script src="js\\validate_textarea.js"></script>
    <script src="js\\validate_page3.js"></script>