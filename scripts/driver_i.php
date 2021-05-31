<?php  
    // γινεται include μόνο στο index.php

    // 1on --  τσεκαρει αν το ανοιγμα της index.php ηταν αποτέλεσμα πατηματος logout.
    //        Αν ήταν, κανε logout (και ανοιγει την index.php ως guest)
    
    // 2on (εκτελείται μονο αν το 1ο false)-τσεκαρει αν το ανοιγμα της index.php ηταν αποτέλεσμα πατηματος sign in.
    //        Αν ήταν, κανε αποπειρα sign in και 
    //              - ανοιγει την index.php ως signed in αν δοθηκαν (σωστα credentials)
    //              - αλλιως η index.php εμφανίζει μήνυμα ενημέρωσης αναλογα με το αν ειναι true kapoio apo ta 2
    //                                                        - UserType::$wrongEmailAttempt
    //                                                        - UserType::$wrongPasswordAttempt

    // 3on (εκτελείται μονο αν το 1ο και το 2ο false)
    //      Ελέγχει αν ο χρήστης είναι signed in και αν ναι περνα καποια δεδομενα του 
    //      απο τη Session μεταβλητες στα attributes ths static class userType

// arxikh ylopoihsh
//     if (! checkForLogOut()) {
//        
//         if (! checkForLogInSubmit()) {
//         
//            defineTypeOfCurrentUser();
//         }    
//     }

    UserType::$wrongEmailAttempt = false;
    UserType::$wrongPasswordAttempt = false;

    if (isset($_GET['loginButton'])){
        
        logOut();
    }
    elseif (isset($_POST['loginButton'])){
        
        logInSubmit();
    }
    else{
        
        defineTypeOfCurrentUser();
    }

?>