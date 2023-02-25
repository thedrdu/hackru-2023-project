<?php

    
    $host    = "localhost";
    $user    = "root";
    $pass    = "raghunandan";
    $db_name = "Portal";

  
    //create connection
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_connect($host, $user, $pass, $db_name);

    return $connection;


