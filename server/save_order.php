<?php
    session_start();
    include_once "database_connection.php";
    include_once "Address.php";
    include_once "SaveOrderResult.php";
    include_once "Order.php";

    $userId = $_SESSION["LoggedInUserId"];

    // to get post data from javascript
    $_POST = json_decode(file_get_contents('php://input'), true);

    $transactionStatus = saveOrder($userId, $conn);

    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($transactionStatus);

    // **************************************************
    function saveOrder($userId, $conn) {
        $newAddress = $_POST['newAddress'];
        $addressId = -1;
        $address = null;
        if ($newAddress) {
            $addressName = $_POST["addressName"];
            if (Address::userHasAddressWithName($userId, $addressName, $conn)) {// duplication of addressName not allowed
                return new SaveOrderResult(false, SaveOrderResult::DUPLICATE_ADDRESSNAME, null);
            }
            $address = new Address(-1, $addressName, $userId, $_POST["country"], $_POST["city"], $_POST["street"], $_POST["number"], $_POST["postalCode"]);
            if (!$address->saveInDatabase($conn)) {
                return new SaveOrderResult(false, SaveOrderResult::DATABASE_ERROR, null);
            }
            $savedAddress = Address::getFromDatabase($userId, $addressName, $conn);
            if ($savedAddress == null) {
                return new SaveOrderResult(false, SaveOrderResult::DATABASE_ERROR, null);
            }
            $addressId = $savedAddress->getId();
        } else {
            $addressId = $_POST["addressId"];
        }
        $notes = $_POST["notes"];
        $order = new Order(-1, $userId, -1, $addressId, 1, $notes); //status = registered = 1, time is specified in query
        return $order->saveAsNewInDatabase($conn); 
    }
?>