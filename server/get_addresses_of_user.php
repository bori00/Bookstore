<?php
    session_start();
    include "database_connection.php";
    include "Address.php";

    $userId = $_SESSION["LoggedInUserId"];

    $addresses = Address::getUsersAddressesFromDatabase($userId, $conn);

    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($addresses);
?>