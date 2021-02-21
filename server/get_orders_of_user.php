<?php
    session_start();
    include "database_connection.php";
    include "OrderData.php";

    $ordersData = OrderData::getUsersOrderDataFromDatabase($_SESSION["LoggedInUserId"], $conn);

    header('Content-Type: application/json');
    $conn->close();
    echo json_encode($ordersData);
?>