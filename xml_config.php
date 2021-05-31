<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php include "scripts\\driver.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>

<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts\\menu_admin.php";
    } 
?>

<!-- Οθόνη για παραγωγή XML που απεικονίζει όλες τις παραγγελίες συγκεκριμένου
     εύρους ημερομηνιών. Επιπλέον, το xml θα απεικονίζει τα 5 πιο δημοφιλή προιόντα
     σε αυτή τη χρονική περίοδο. -->

<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
   <h2 class="font-weight-bolder mx-auto  pl-4 mjt-5" style="width:600px"><pre>Ημερομηνίες αρχειου παραγγελιών</pre></h2>
    
    <div class="jumbotron mx-auto mt-3" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:300px;width:800px;background-color:#e9d28c;">
               
        <h4 class="font-weight-bolder allign-left mt-n5" style="width:500px">Επιλογή χρονικού εύρους</h4>
        <br/> 
        <div>
        <input type="radio" id="custom" name="date" checked>
        <label for="custom">Custom</label>
        <input type="radio" id="lastWeek" name="date">
        <label for="lastWeek">Last Week</label>
        <input type="radio" id="lastMonth" name="date">
        <label for="lastMonth">Last Month</label>
        </div>
        <br/>       
        <form action="xml_view.php" method="get">
           <div class="custom-control-inline mb-2">
                <label for="frDt" class="mr-2">Από:</label>
				<input type="date" class="dtPick form-control mr-3" id="frDt" name="frDt" style="width:260px"  required>
                <label for="toDt" class="ml-5">Εώς:</label>
				<input  type="date" class="dtPick form-control ml-3" id="toDt" name="toDt" style="width:260px"  required>
            </div>
            <br/><br/><br/><br/>
            <div class="custom-control-inline mb-2">
				<button type="submit" class="btn btn-secondary ml-5" name="xmlView" value="1">Προβολή</button>
				<a href="index.php">
				    <button type="button" class="btn btn-secondary ml-5">Επιστροφή</button>
				</a>
            </div>
        </form>
                
    </div>	
<!--     <div id="board">................board....................</div>-->
</div>

<script> setLinkActive('adm6')</script>
<script src="js\\xmlDate.js"></script>

<?php include "scripts\\footer.php" ?>