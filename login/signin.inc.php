<?php

if ( isset($_POST["submit"])){
    

    $user_email = $_POST["user_email"];
    $pwd = $_POST["pwd"];
    $user_name = $_POST["user_name"];

    require "./portalConn.php";
    require "./func.php";

    if ( signinInputEmpty($user_email, $pwd) !== false ){
        header("location: ./signin.php?error=noInput");
        exit();


    } 

    if ( existsEmail($connection, $user_email) === false ){
        header("location: ./signin.php?error=emailExists");
        exit();


    }

    loginUser($connection, $user_email,$pwd);
    exit();

}