<?php
    session_start();
    include "User.php";
    include "database_connection.php";

    // to get post data from javascript
    $_POST = json_decode(file_get_contents('php://input'), true);

    $loginUser = new User($_POST["UserName"], $_POST["Password"]);
    $succesfulLogin = logIn($loginUser, $conn);

    if ($succesfulLogin) {
        saveNewLoggedInUser($loginUser, $conn);
    }
    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($succesfulLogin);

    // **************************************************
    function logIn($user, $conn) {
        $query= sprintf("SELECT * FROM User WHERE UserName = '%s' AND Password = '%s';", $user->getName(), $user->getPassword());
        $succesfulLogin = false;
        if ($result = $conn->query($query)) {
            if ($result->num_rows == 1) {
                $succesfulLogin = true;
            }
            $result->close();
        }
        return $succesfulLogin;
    }

    // **************************************************
    function saveNewLoggedInUser($user, $conn) {
        $_SESSION["LoggedInUserId"] = getUserId($user, $conn);
    }

    // **************************************************
    function getUserId($user, $conn) {
        $query= sprintf("SELECT UserId FROM user WHERE UserName = '%s'", $user->getName());
        if ($result = $conn->query($query)) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                return $row["UserId"];
            }
            return -1;
        }
        return -1;
    }
?>