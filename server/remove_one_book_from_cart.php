<?php
    session_start();
    include "database_connection.php";

    $userId = $_SESSION["LoggedInUserId"];
    $bookId = $_GET["bookId"];

    $success = removeOneBookFromUsersCart($userId, $bookId, $conn);

    $conn->close();
    echo json_encode($success);


    // **************************************************
    function removeOneBookFromUsersCart($userId, $bookId, $conn) {
        $queryQuantity= sprintf("SELECT quantity FROM booksincart WHERE bookEditionId = '%s' AND userId = '%s'", $bookId, $userId);
        $currentQuantity = 0;
        if ($result = $conn->query($queryQuantity)) {
            if ($result->num_rows >= 1) {
                $row = $result->fetch_assoc();
                $currentQuantity = $row["quantity"];
                if ($currentQuantity > 1) {
                    $newQuantity = $currentQuantity - 1;
                    $queryRemove = sprintf("UPDATE booksincart SET quantity = '%s' WHERE bookEditionId = '%s' AND userId = '%s'", $newQuantity, $bookId, $userId);
                    return $conn->query($queryRemove);
                } else if ($currentQuantity == 1) {
                    $queryDeleteItemFromCart = sprintf("DELETE FROM booksincart WHERE bookEditionId = '%s' AND userId = '%s'", $bookId, $userId);
                    return $conn->query($queryDeleteItemFromCart);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
?>