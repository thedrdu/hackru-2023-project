<?php

if ( isset($_POST["submit"])){
    

    $user_email = $_POST["user_email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwd_repeat"];
    $user_name = $_POST["user_name"];
    $netid = $_POST["netid"];

    require "./portalConn.php";
    require "./func.inc.php";

    if ( signupInputEmpty($user_email, $user_name, $netid, $pwd, $pwdRepeat) !== false ){
        header("location: ./signup.php?error=noInput");
        exit();


    } 

    if ( samePWD($pwd, $pwdRepeat) !== false ){
        header("location: ./signup.php?error=notSamePWD");
        exit();


    } 
    if ( existsEmail($connection, $user_email) !== false ){
        header("location: ./signup.php?error=emailExists");
        exit();


    }

    createAccount($connection, $user_email, $user_name, $netid, $pwd);
    exit();

}