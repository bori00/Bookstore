<?php
    session_start();
    $result =  false;
    if (isset($_SESSION["LoggedInUserId"])) {
       $result = true;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
?>
