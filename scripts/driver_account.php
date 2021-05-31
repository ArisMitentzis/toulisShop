<?php
    
    // fernei ola ta data tou sundedemenou user
    // kai ta anathetei stis antistoixa attributes ths UserType statikhs klashs
    // wste meta na mpoun sth forma ths diaxeirishs logariasmou (account.php)
    //assignAccountDetails();

    // an einai orismenh h $_POST['update'], tote to anoigma ths selidas prohlthe apo
    // pathma tou submit button update -- exoume dhladh aithma ananewshs twn stoixeiwn tou logariasmoy
    // apo to xrhsth
    if (isset($_POST['update'])){
        
        update();
        
        $_SESSION['userFirst'] = $_POST['firstName'];
        $_SESSION['userLast'] = $_POST['lastName'];
        
        UserType::$userFirst = $_POST['firstName'];
        UserType::$userLast = $_POST['lastName'];
        
        assignAccountDetails();
    }  

    // καλειται απο το driver_account.php όταν ειναι ορισμενη η $_POST['delete']
    // κανει delete to logariasmo toy syndedemenou xrhsth
    elseif (isset($_POST['delete'])){
        
        delete();
    }  
    else{
    // fernei ola ta data tou sundedemenou user
    // kai ta anathetei stis antistoixa attributes ths UserType statikhs klashs
    // wste meta na mpoun sth forma ths diaxeirishs logariasmou (account.php)
    assignAccountDetails();
    }
?>