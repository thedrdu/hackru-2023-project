<?php

function signupInputEmpty($user_email, $user_name, $netid, $pwd, $pwdRepeat){

    $testValue = null;

    if ( empty($user_email) || empty($user_name)  || empty($pwd) || empty($pwdRepeat) || empty($netid)){

        $testValue = true;

    } else {

        $testValue = false;

    }

    return $testValue;

}

function signinInputEmpty($user_email, $pwd, $netid){

    $testValue = null;

    if ( empty($user_email) || empty($pwd) || empty($netid)){

        $testValue = true;

    } else {

        $testValue = false;

    }

    return $testValue;

}

function samePWD($pwd, $pwdRepeat){

    $testValue = null;

    if ( $pwd !== $pwdRepeat ){

        $testValue = true;

    } else {

        $testValue = false;

    }

    return $testValue;

}

function existsEmail($connection, $user_email){


    $query = "SELECT * FROM users WHERE userEmail = ?;";

    $sql_stmt = mysqli_stmt_init($connection);

    if ( !mysqli_stmt_prepare($sql_stmt, $query)){
        header("location: ./signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($sql_stmt, "s", $user_email);
    mysqli_stmt_execute($sql_stmt);

    $resulting_data = mysqli_stmt_get_result($sql_stmt);

    if ( $row = mysqli_fetch_assoc($resulting_data) ){
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($sql_stmt);

}

function validation($connection, $user_email){

    $query = "SELECT * FROM users WHERE userEmail = ? AND validated = 1;";

    $sql_stmt = mysqli_stmt_init($connection);

    if ( !mysqli_stmt_prepare($sql_stmt, $query)){
        header("location: ./signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($sql_stmt, "s", $user_email);
    mysqli_stmt_execute($sql_stmt);

    $resulting_data = mysqli_stmt_get_result($sql_stmt);

    if ( $row = mysqli_fetch_assoc($resulting_data) ){
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($sql_stmt);

}

function createUserLog($connection, $netid, $user_email){

    $query = "INSERT INTO userLog (userEmail, user_NETID) VALUES (?, ?);";

    $stmt = mysqli_stmt_init($connection);
    if ( !mysqli_stmt_prepare($stmt, $query)){
        header("location: ./signup.php?error=stmtFailed");
        exit();
    }

    
    mysqli_stmt_bind_param($stmt, "ss", $user_email, $netid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


function loginUser($connection, $user_email, $netid, $pwd){

    $exist_email = existsEmail($connection, $user_email);

    if ( $exist_email === false ){
        header("location: ./signin.php?error=emailNotExist");
        exit();
    }

    $hashedPassword = $exist_email["userPwd"];
    $checkedPWD = password_verify($pwd, $hashedPassword);

    if ( $checkedPWD === false ){
        header("location: ./signin.php?error=wrongPassword");
        exit();
    } else if ( $checkedPWD === true ){
        session_start();
        $_SESSION["userEmail"] = $exist_email["userEmail"];
        $checkValidation = validation($connection, $user_email);

        if ( $checkValidation === false){
            header("location: ./signin.php?error=notValidated");
            exit();
        } else {

            createUserLog($connection, $netid, $user_email);

            header("location: ../index.php");
            exit();  
        }

      

    }

}

function createAccount($connection, $user_email, $user_name, $netid, $pwd){

    $return = null;
    $resulting_data = null;

    $query = "INSERT INTO users (NETID, userEmail, userPwd, userName) VALUES (?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($connection);
    if ( !mysqli_stmt_prepare($stmt, $query)){
        header("location: ./signup.php?error=stmtFailed");
        exit();
    }

    
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $netid, $user_email, $hashedPassword, $user_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./signup.php?error=none");

}
