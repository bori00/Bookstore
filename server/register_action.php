<?php
    session_start();
    include "database_connection.php";
    include "User.php";

    // to get post data from javascript
    $_POST = json_decode(file_get_contents('php://input'), true);

    $name = $_POST["UserName"]; 
    $password = $_POST["Password"]; 

    const SUCCESS = "Succesful SignUp";
    const DUPLICATED_USERNAME = "Duplicated UserName";
    const DATABASE_ERROR = "Database Error";

    $result = signUp($name, $password, $conn);
    $conn->close();
    print json_encode($result);

    // **************************************************
    function signUp($name, $pass, $conn) {
        $user = new User($name, $pass);
        if (validUserName($user, $conn)) {
            if ($user->saveInDatabase($conn)) {
                return SUCCESS;
            } else {
                return DATABASE_ERROR;
            }
        } else {
            return DUPLICATED_USERNAME;
        }
    }

    // **************************************************
    function validUserName($user, $conn) { //check if there exists another user with the same name
        return User::getFromDatabase($user->getName(), $conn) == null;
    }
?>