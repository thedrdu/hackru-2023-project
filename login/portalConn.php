<?php

    
    $host    = "127.0.0.1";
    $user    = "root";
    $pass    = "raghunandan";
    $db_name = "hackrudb";


    //create connection
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_connect($host, $user, $pass, $db_name);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }

    return $connection;