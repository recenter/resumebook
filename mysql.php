<?php
    //RE Server, PHP 5.3 
    $mssql_host = 'sb1-sql12-1.business.uconn.edu';
    $mssql_database = 'REResume';
    $mssql_user = 'util.sql.reresume';
    $mssql_password = 'RE$RE$RE$299';
    $connection = mssql_connect($mssql_host, $mssql_user, $mssql_password);
    mssql_select_db($mssql_database);

    /* Test Environment, PHP 5.6.24 
    $serverName='sb1-sql12-1.business.uconn.edu';
    $user='util.sql.reresume';
    $pword='RE$RE$RE$299';
    $db='REResume';
    $connection = new PDO("sqlsrv:Server=$serverName;Database=$db",$user,$pword);
    */
?>