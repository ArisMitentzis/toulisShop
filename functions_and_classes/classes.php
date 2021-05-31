<?php
    class RowOfProductBoxPlace
    {
        const last = 0;
        const popular = 1;
        const byType = 2;
    }
    //echo RowOfProductBoxPlace::popular;

    class UserType
    {
        const notLogged = 0;
        const notAdmin = 1;
        const admin = 2;
        
        static $userType;
        static $userCode;
        static $userFirst;
        static $userLast;
        
        static $wrongEmailAttempt;
        static $wrongPasswordAttempt;
        
        static $userMobile;
        static $userEmail;
        static $userAdress;
        static $userTk;
        static $userCity;
        static $userNomos;
        static $userBirthdate;
    }

    class ExecQueryResult
    {   
        const logicalNotExamined = -1;
        const logicalError = 0;
        const logiacalOk = 1;
        
        var $querySuccess;
        var $resultSet;
        var $resultSetRows;
        var $logicalCheck = -1;
        var $logicalErrorMessage = null; 
        var $numericResult = null;
        
        
    }
