<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver_i.php" ?>
<?php include "scripts/driver_index.php" ?>
<?php include "scripts/driver_cortConnection.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>

<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts/menu_admin.php";
    } 
?>
    <!-- η γραμμή που περιέχει το banner διαφήμισης-προσφορων -->
	    <div class="row " style="height:140px;background-color:#e9d28c">
		    <img src="images\banner2.jpg" class="img-fluid rounded mx-auto py-2" alt="banner2" style="height:100%;">
	    </div>
	
	    <div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
            
    <?php if (! UserType::$wrongEmailAttempt && ! UserType::$wrongPasswordAttempt) { ?>
        
<!--    η φόρμα περιεχει τις 6 bitrines - (id="cortForm" - xrhsimopoieitai apo .js). 
        h logikh einai oti stelnontai oles oi plhrofories thw paraggelias me ena
        se post μεταβλητες (paragetai me serialize() kai stelnetai me ajax sto async_cort)    -->
        <form id="cortForm" data-userType="<?php echo UserType::$userType;?>" action="index.php" method="post">
		
        <h4 class="font-weight-bolder">Τελευταίες αφίξεις</h4>
		
		<!-- η γραμμή που περιέχει τα προϊόντα που αποτελούν τις τελευταίες αφίξεις (σε 3 columns)-->
		<div class="row mt-2 mb-5" style="height:220px;">
			
			<!-- αριστερό προϊόν τελευταίων αφίξεων-->
			<!-- μεσαίο προϊόν τελευταίων αφίξεων-->
			<!-- δεξιό προϊόν τελευταίων αφίξεων-->
			
			<?php echoRowOfProductBox(RowOfProductBoxPlace::last,$resultLastProducts,$lastPage,null); ?>
		
		</div>
		
		<!--div class="row mt-2" style="height:150px;">
        </div-->
		
        <?php // tupwse to pagination gia ta last products
              // To $currentPageIndex dinetai 0 dioti ta pages aforoyn to prwto index?>
        <?php echoPagination($pagesKeyArray,$pagesValueArray,0,$maxPage,$currentUrl,$typeKey,$typeValue,'last_page');?>	

		<br/>	
			
		<h4 class="font-weight-bolder ">Δημοφιλή προϊόντα</h4>
		
		<!-- η γραμμή που περιέχει τα προϊόντα που αποτελούν τα Δημοφιλή προϊόντα (σε 3 columns)-->
		<div class="row mt-2 mb-5" style="height:220px;">
			
			<!-- αριστερό προϊόν δημοφιλών προϊόντων-->
			<!-- μεσαίο προϊόν δημοφιλών προϊόντων-->
			<!-- δεξιό προϊόν δημοφιλών προϊόντων-->
				
        <?php //echoRowOfProductBox(RowOfProductBoxPlace::popular); ?>
        <?php echoRowOfProductBox(RowOfProductBoxPlace::popular,$resultPopProducts,$popPage,null); ?>
			
		</div>
		
		<!--div class="row mt-2" style="height:150px;">
        </div-->
		
		<?php // tupwse to pagination gia ta pop products
              // To $currentPageIndex dinetai 1 dioti ta pages aforoyn to deytero index?>
        <?php echoPagination($pagesKeyArray,$pagesValueArray,1,$maxPage,$currentUrl,$typeKey,$typeValue,'pop_page');?>
			
        <br/>
            </form>
<?php 
        } 
        else { 
              
              $title = 'Η προσπάθεια εισόδου απέτυχε';
              $linksArray = [];
              $linksArray[0]= 'sign_in.php';
              $linksArray[1]= 'sign_up.php';
              $linksArray[2]= 'index.php';
              $linkTitlesArray = [];
              $linkTitlesArray[0]= 'Πατήστε εδώ για να προσπαθήσετε ξανά.';
              $linkTitlesArray[1]= 'Δεν έχετε λογαριασμό; Πατήστε εδώ για να εγγραφείτε.';
              $linkTitlesArray[2]= 'Δεν έχετε λογαριασμό; Πατήστε εδώ για να συνεχίσετε ως guest.';
            
              if (UserType::$wrongEmailAttempt){
                  
                  $message = 'Δεν υπάρχει καταχωρημένος χρήστης με αυτό το email.Μήπως κάνατε λάθος;'; 
               }
               else {
                  
                  $message = 'Δεν δώσατε τον σωστό κωδικό πρόσβασης.Μήπως κάνατε λάθος;';
               }
              
               echoSingleMessage($title,$message,$linksArray,$linkTitlesArray);			
		    } 
?>
	
<!--<div id="board">................board....................</div>-->
            
</div>
	
    

    <script> setLinkActive('startLink')</script>

<!--   To scriptaki pou einai upeuthino gia to kalathi     -->
    <script src="js/cortBuy.js"></script>
<!--   To scriptaki pou einai upeuthino gia to pagination     -->
    <script src="js/pagination.js"></script>

<script src="js/synchronizeVitrines_index.js"></script>

<script src="js/ajaxCaller.js"></script>


    
	<?php include "scripts/footer.php" ?>