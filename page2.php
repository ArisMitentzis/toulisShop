<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>
<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_page2.php" ?>
<?php include "scripts\\driver_cortConnection.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts\\menu_admin.php";
    } 
?>
	
	<div class="container-width mt-3" style="height:1100px;background-color:#e9d28c">
		
		<div class="row mt-2 mb-5" style="height:440px;"</div>
		
			<!-- η στήλη που περιέχει τις κατηγορίες-φίλτρα -->
            <!-- exei prostethei to attribute data type pou deixnei to id toy typou  -->
			<div id="filter_div" class="col-4 border border-dark border-top-0 border-bottom-0 border-left-0 mr-5" data-type=<?php if (!is_null($typeValue)){ echo $typeValue;} else {echo -1;}?>>
				<h4 class="font-weight-bolder ">Κατηγορίες (Φίλτρα)</h4>
				<div id="filtersDiv" class="list-group list-group-flush" style="width:80%">
					<a data-typeCode="-1" href="page2.php" class="type list-group-item list-group-item-action" style="background-color:<?php if (! isset($_GET['type'])){?>#f0ad4e<?php } else{?>#e9d28c<?php }?>">Όλα</a>
					
					<?php echoProductTypes();?>
					
				</div>
			</div>
			
			<!-- η δεξιά περιοχή-στήλη που παρουσιάζει τα σχετικά προϊόντα -->
			<div class="col-7 mr-n4">
				<h4 class="font-weight-bolder ">Σκύλοι</h4>
				
                <form id="cortForm" data-userType="<?php echo UserType::$userType;?>" action="index.php" method="post">

                
				<!-- η πάνω γραμμή με τα σχετικά προϊόντα -->
				<div class="row mt-2 mb-5" style="height:220px;">
				    <?php $isDown=0; echoRowOfProductBox(RowOfProductBoxPlace::byType,$resultProducts,$page,$isDown); ?>		
				</div>
				
				<br/>
				
				<!-- η κάτω γραμμή με τα σχετικά προϊόντα -->
				<div class="row mt-2 mb-5" style="height:220px;">
				    <?php $isDown=1; echoRowOfProductBox(RowOfProductBoxPlace::byType,$resultProducts,$page,$isDown); ?>	
				</div>
				
				<br/>
				
				<?php echoPagination($pagesKeyArray,$pagesValueArray,0,$maxPage,$currentUrl,$typeKey,$typeValue,'type');?>
                    
                </form>

			</div>
		</div>

	</div>

<!--<div id="board">................board....................</div>-->
		
    <script> setLinkActive('dogLink')</script>

    <!--   To scriptaki pou einai upeuthino gia to kalathi     -->
    <script src="js\\cortBuy.js"></script>
    <!--   To scriptaki pou einai upeuthino gia to pagination     -->
    <script src="js\\pagination.js"></script>

    <script src="js\\filters.js"></script>

    <script src="js\\ajaxCaller.js"></script>
		
<?php include "scripts\\footer.php" ?>