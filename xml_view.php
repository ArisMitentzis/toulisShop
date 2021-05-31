<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\connect_to_db.php" ?>

<?php include "scripts\\driver.php" ?>
<?php include "scripts\\driver_xml_view.php" ?>

<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>

<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts\\menu_admin.php";
    } 
?>

<div class="container-width mt-1" style="height:1100px;background-color:#e9d28c">
	
<?php
    // Αν είναι valid το εύρος των ημερομηνιών και το xml file με βαση το σχετικό dtd file
     if ($datesAreValid && $XmlIsValid) {
?>
           <h2 class="font-weight-bolder mx-auto  pl-4 mt-3" style="width:900px">
               <pre>             Προβολή αρχειου παραγγελιών</pre>
           </h2> 
   
           <h5>
               <pre>                                       (<?php echo $dateFrom . ' έως ' . $dateTo ; ?> )</pre>
           </h5> 
           <br/>
    
            <pre style="font-size:18px;text-align:center">Συνολικός αριθμός Παραγγελιών:<b><?php echo $quantityOfOrders;?></b> --- Συνολική αξία Παραγγελιών:<b><?php echo $totalValueOfOrders;?></b></pre>
    
            <?php echoXSL();
            ?>
    
    <a href="xml_config.php"><button type="button" class="btn btn-secondary ml-5 ">Επιστροφή</button></a>
    
    <?php
    }
    // Κάποιο validation απέτυχε. Προβολή σχετικής ενημέρωσης στο χρήστη.
    else {
        
              $title = 'Η αναζήτηση παραγγελιών συγκεκριμένου εύρους απέτυχε';
              $linksArray = [];
              $linksArray[0]= 'xml_config.php';
              $linksArray[1]= 'index.php';
              $linkTitlesArray = [];
              $linkTitlesArray[0]= 'Πατήστε εδώ για να προσπαθήσετε ξανά.';
              $linkTitlesArray[1]= 'Πατήστε εδώ για να μεταφερθείτε στην αρχικη σελίδα.';
            
              if (! $datesAreValid){
                  
                  $message = 'Το εύρος ημερομηνιών δεν ήταν έγκυρο'; 
               }
               else {
                  
                  $message = 'Η προσπάθεια επικύρωσης του XML απέτυχε';
               }
              
               echoSingleMessage($title,$message,$linksArray,$linkTitlesArray);			
		  } 
?>
     
</div>

<script> setLinkActive('adm6')</script>

<?php include "scripts\\footer.php" ?>
<script src="js\\datatable.js"></script>