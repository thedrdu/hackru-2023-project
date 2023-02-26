<?php

require "./portalConn.php";

function signupInputEmpty($user_email, $user_name, $pwd, $pwdRepeat){

    $testValue = null;

    if ( empty($user_email) || empty($user_name)  || empty($pwd) || empty($pwdRepeat) ){

        $testValue = true;

    } else {

        $testValue = false;

    }

    return $testValue;

}

function signinInputEmpty($user_email, $pwd){

    $testValue = null;

    if ( empty($user_email) || empty($pwd) ){

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

function createUserLog($connection, $user_email, $pwd){

    $query = "INSERT INTO userLog (userEmail, Pwd) VALUES (?, ?);";

    $stmt = mysqli_stmt_init($connection);
    if ( !mysqli_stmt_prepare($stmt, $query)){
        header("location: ./signup.php?error=stmtFailed");
        exit();
    }

    
    mysqli_stmt_bind_param($stmt, "ss", $user_email, $user_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function loginUser($connection, $user_email, $pwd){

    $exist_email = existsEmail($connection, $user_email);

    $hashedPassword = $exist_email["userPwd"];
    $checkedPWD = password_verify($pwd, $hashedPassword);

    if ( $checkedPWD === false ){
        header("location: ./signin.php?error=wrongPassword");
        exit();
    } else if ( $checkedPWD === true ){
        session_start();
        $_SESSION["userEmail"] = $exist_email["userEmail"];

       
        createUserLog($connection, $user_email, $pwd);
        header("Location: /templates/index.html");
        exit();  

    }
}



function createAccount($connection, $user_email, $user_name, $pwd){

    $query = "INSERT INTO users (userEmail, userName, userPwd) VALUES (?, ?, ?);";

    $stmt = mysqli_stmt_init($connection);
    if ( !mysqli_stmt_prepare($stmt, $query)){
        header("location: ./signup.php?error=stmtFailed");
        exit();
    }

    
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $user_email,  $user_name, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./signup.php?error=none");

}
