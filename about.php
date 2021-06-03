<?php include "functions_and_classes/front_end_functions.php" ?>
<?php include "functions_and_classes/controller_functions.php" ?>
<?php include "functions_and_classes/back_end_functions.php" ?>
<?php include "functions_and_classes/classes.php" ?>

<?php include "scripts/connect_to_db.php" ?>
<?php include "scripts/driver.php" ?>
<?php // include "scripts/driver_account.php" ?>

<?php include "scripts/header.php" ?>
<?php include "scripts/menu.php" ?>
<?php 
    if (UserType::$userType == UserType::admin){
        
        include "scripts/menu_admin.php";
    } 
?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	<br/><br/>
    <h2 class="font-weight-bolder mx-auto   pl-4" style="width:800px"><pre>                 About this project</pre></h2>
             
        <div class="jumbotron mx-auto mjr-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:900px;width:1150px;background-color:#e9d28c;overflow-y: scroll;">
            
            <p class="mt-n5">Created by <a href="https://www.linkedin.com/in/mitentzisaristeidis/">Mitentzis Aristeidis </a>.<br><br>The current CV project implements an imaginary pet e-shop. It was created in the context of a university assignment under a short notice and aimed at familiarizing myself with the most common web technologies and not necessarily creating the most efficient design. Only the dog category of products is fully realized and text is written in Greek because of the assignment instructions but plan (maybe) to translate it in English sometime in the future.<br/><br/> A signed-in user may have a look at the
                products and add anything to the cart. He could also edit his cart and
                finalize his order. Of course, he can view all his orders. An admin user has
                the choice of adding any new product. He can view, edit or delete the
                existing products. He could also view all the orders and edit their state.
                Finally, he may view all the user accounts and some statistics. It is hosted
                at Heroku and its DB at remotemysql.com.  
               <br></p>
           
            <p><u>Technical description:</u><br>
               <b>Back-end:</b>
                   <pre class="mt-n3">    - MySql database   - Functional PHP</pre>
               <b class="pt-n4">Front-end:</b><br>
                   <pre >   - HTML,CSS,Bootstrap   - Javascript,JQuery,Ajax</pre>
            <p/>
            
            <br/>
            <pre>Click here to initiate the DB with some dummy data.     <button id="initDBbutton" type="button" class="btn btn-secondary">Αρχικοποίηση DB</button>  <span id="initializedText" style="color:red;"></span> </pre>
            
            <br/>
            
            <pre>@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@</pre>
            
            <p class="mt-n1">Το συγκεκριμένο CV project υλοποιεί ένα ηλεκτρονικό κατάστημα Pet Shop. Δημιουργήθηκε ως εργασία, στα πλαίσια της ενότητας ΠΛΗ23.  Στόχος ήταν η εξοικείωση με βασικές web τεχνολογίες και όχι η βέλτιστη σχεδίαση, καθώς υπήρχε στενό και αυστηρό deadline. Υλοποιημένη είναι μόνο η κατηγορία των σκύλων. Οι υπόλοιπες είναι εικονικές. Επιπλέον, οι σελίδες είναι γραμμένες στα ελληνικά διότι έτσι ζητήθηκε αλλά πρόκειται να μεταφραστεί και στα αγγλικά. 
               <br></p>
            
               <p>
                     
            <u>Βασική λειτουργική περιγραφή:</u><br>
               Υπαρχουν 3 τυποι user:<br> 
                   <pre>   -<u>Guest</u>,δηλαδη not logged in.     -<u>Simple user</u>,δηλαδη logged in but not admin.    - <u>Admin</u>,δηλαδη logged in  and admin.</pre>
               Κάποιος <b>guest</b> μπορεί:<br>
                   - να δει τα προϊόντα χωρίς να τα προσθέσει στο καλάθι <a href="index.php">(index.php)</a> και <a href="page2.php">(page2.php)</a>.<br>
                   - να συνδεθει αν διαθέτει λογαριασμό <a href="sign_in.php">(sign_in.php)</a> ή να δημιουργήσει λογαριασμό αν δεν εχει <a href="sign_up.php">(sign_up.php)</a>.<br><br>
               Κάποιος <b>simple user</b> μπορεί:<br>
                    - να δει τα προϊόντα και να προσθέσει στο καλάθι οτι επιθυμει να αγορασει <a href="index.php">(index.php)</a> και <a href="page2.php">(page2.php)</a>.<br>
                    - να δει και να επεξεργαστεί το καλάθι του και να οριστικοποιήσει την παραγγελία του. <a href="page3.php">(page3.php)</a>.<br>
                    - να τροποποιησει ή να διαγράψει τον λογαριασμό του.<a href="account.php">(account.php)</a>.<br>
                    - να δει το σύνολο των παραγγελιών του. <a href="myOrders.php">(myOrders.php)</a>.<br><br>
               Κάποιος <b>admin</b> μπορεί:<br>
                    - να προσθέσει προϊόν <a href="add_product.php">(add_product.php)</a>, καθώς και να δει πίνακα όλων των προϊόντων με δυνατότητα επεξεργασίας και διαγραφής του καθενός <a href="list_delete_product.php">(list_delete_product.php)</a>.<br>
                    - να δει το σύνολο όλων των παραγγελιών και για καθεμία, να αλλάξει την κατασταση της, καθώς και να δει την ανάλυση της <a href="allOrders.php">(allOrders.php)</a>.<br>
                    - να αναζητήσει παραγγελίες φιλτράροντας για κάποιο χρονικό διάστημα <a href="xml_config.php">(xml_config.php)</a>.Η συγκεκριμένη λειτουργία ζητήθηκε να γίνει με παραγωγή xml και η παρουσίαση με χρήση αρχείου xsl. Οπότε, όταν ο χρήστης εκτελεί αναζήτηση για συγκεκριμένο χρονικό διαστημά παράγεται ένα αρχείο xml με τα σχετικά δεδομένα,το οποίο αποθηκεύεται στον φάκελο με όνομα xml. Γίνεται έλεγχος αν το xml είναι valid με κριτήριο το αρχείο 'xml\aboutOrders.dtd'. Η παρουσίαση των αποτελεσμάτων γίνεται στη σελίδα xml_view.php με χρηση του αρχείου 'xml\allOrdersAndTop5SalesProducts.xsl'. <br>
                    - να δει το σύνολο των λογαριασμών των χρηστών. <a href="allUsers.php">(allUsers.php)</a>.<br>
                    - να δει μια στατιστική επισκόπηση (τζίρος, δημοφιλέστερα προϊόντα,καλύτεροι πελάτες). <a href="statistics.php">(statistics.php)</a>.<br><br>
                <u>Λίγες λεπτές παρατηρήσεις:</u><br>
                - Τα τετράγωνα με τα προϊόντα και το pagination στις σελίδες  <a href="index.php">(index.php)</a> και <a href="page2.php">(page2.php)</a>  εχουν δημιουργηθεί from scratch αντί να χρησιμοποιηθει π.χ το jquery owlCarousel. Αυτή η επιλογή έγινε για εκπαιδευτικούς λόγους, αν και αισθητικά - όπως είναι λογικό - υπολείπεται αρκετα. Αντίθετα, όπου υπάρχουν πίνακες έχει χρησιμοποιηθεί το mainstream plug-in Datatables, όπως π.χ στη σελίδα <a href="allOrders.php">(allOrders.php)</a>.<br>
                - Στις σελίδες  <a href="index.php">(index.php)</a> και <a href="page2.php">(page2.php)</a>, όταν ο χρήστης ανεβάζει την ποσότητα κάποιου προϊόντος, η σελίδα του επιτρέπει να φθάσει μέχρι το στοκ που υπάρχει τη στιγμή που φορτώθηκε η σελίδα.<br>
                - Σε όλες τις φόρμες (π.χ στο <a href="sign_up.php">sign_up.php</a>) υπάρχει έλεγχος validation με σαφή μηνύματα στα πεδία όπου υπάρχει invalid input.<br>
                - Στη σελίδα <a href="allOrders.php">(allOrders.php)</a>, όταν ο χρήστης αλλάξει την κατάσταση σε 'Απεστάλη', ελέχγεται αν σε κάποιο από τα προϊόντα της παραγγελίας δεν επαρκεί το στοκ. Εφόσον υπάρχει έλλειψη σε τουλάχιστον ένα προϊόν, το κουμπί της ανάλυσης κοκκινίζει και εμφανίζει ένα καμπανακι. Επιπλέον, όταν ο χρήστης δει την ανάλυση, το πεδίο που απεικονίζει το σχετικό στοκ θα είναι κοκκινισμένο.
           </p>
                     
        </div>
            
        <div class="row">         
            <div class="col-1"></div>
            <div class="col-10 ml-3"><a href="index.php" class="mx-auto"><button type="button" class="btn btn-secondary ml-n4  ">Επιστροφή</button></a></div>
        </div>
        
    
</div>

<?php include "scripts/footer.php" ?>

<script src="js/ajaxCaller.js"></script>
<script src="js/initiateDB.js"></script>