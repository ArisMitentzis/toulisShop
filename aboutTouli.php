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
    <h2 class="font-weight-bolder mx-auto   pl-4" style="width:800px"><pre>                 About Touli the cat</pre></h2>
             
        <div class="jumbotron mx-auto mjr-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:550px;width:1000px;background-color:#e9d28c;">
            
        <pre>
        This is the story of Toulis, the little cat that struggled to survive or maybe not...
        
        Με λένε τούλι και είμαι ένας άκρως γοητευτικός γατούλης. 
        
        Παλιά έμενα στο πατάκι μιας πολυκατοικίας, είχα βολευτεί γιατί μου έδιναν φαγάκι συχνά πυκνά,
        μέχρι που ήρθε ένα κοριτσάκι που το συμπάθησα πολύ. Κάθε φορά της έκανα γλυκές,
        ξέρετε κωλοτούμπες, κολλούσα τη μουσούδα μου στο τζάμι όταν έμπαινε μέσα στην οικοδομή...
        Και επειδή μάλλον με ερωτεύτηκε κεραυνοβόλα με πήρε στην άλλη άκρη της πόλης να ζήσουμε μαζί.
        Τι καλά! Παλιά είχα κι εγώ οικογένεια αλλά η μαμά μας μας εγκατέλειψε και εμένα και το αδερφάκι
        μου μας χτύπησε αμάξι μια μέρα... Οοο το αδερφάκι μου δεν άντεξε, εμένα μου χάλασε μόνο το ένα
        ποδαράκι μου, αλλά δε το έβαλα κάτω! Έχω μάλιστα να δηλώσω οτι μου αρέσει το ποδόσφαιρο και συγκεκριμένα
        το τέρμα. Δε μπορεί κανένα μπαλάκι να περάσει την εστία μου γιατί τρέχω σαν σίφουνας και πέφτω εξαιρετικά
        παρόλο που το ένα πόδι μου δε λειτουργεί καθόλου εδώ και χρόνια. Αλλά δε με πτοεί τίποτα, τη ζωή μου κάνω!
        Λατρεύω ακόμα και το καλοκαίρι να αράζω κάτω από τα σκεπάσματα ή στο μπαλκόνι σε σημείο όπου ο ήλιος να
        ζεματάει, είμαι θερμός γάτος! Όλοι λεν ότι είμαι ένα κουκλάκι ζωγραφιστο αλλά εγώ δεν υποκύπτω εύκολα σε
        κοπλιμέντα και τα χάδια μου τα χαρίζω σε λίγους. Οι άλλοι μπορούν να με απολαμβάνουν να τους κοιτάω, μιας
        και έχω ματάρες, και να με βλέπουν να κάνω κωλοτούμπες μέσα στα παπούτσια τους ή σε κανένα χαρτοκούτι,
        τρελαίνομαι να ανακαλύπτω νέα μέρη όπως καταλάβατε!
        </pre>   
                     
        </div>
            
        <div class="row">         
            <div class="col-1"></div>
            <div class="col-10 ml-3"><a href="index.php" class="mx-auto"><button type="button" class="btn btn-secondary ml-n4  ">Επιστροφή</button></a></div>
        </div>
        
    
</div>

<?php include "scripts/footer.php" ?>

<script src="js/ajaxCaller.js"></script>
<script src="js/initiateDB.js"></script>