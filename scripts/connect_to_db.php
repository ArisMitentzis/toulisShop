<?php

    // connection to DB
    // and session_start() because this app uses session


     // anagkaio gia na einai catchable to sql error
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection;
        
    try {
        //port 3306
        $connection = mysqli_connect('localhost','root','','PETSHOPDB');
        //echo "db_ok";
    } 
    catch(Exception $e) {
        
        if (! $connection) {
            die ("Db  connection failed");
        }
    }  
    
    session_start();
    
?>
