<?php
    session_start();
    include "database_connection.php";

    $userId = $_SESSION["LoggedInUserId"];
    $bookId = $_GET["bookId"];

    $success = addOneBookToUsersCart($userId, $bookId, $conn);

    $conn->close();
    echo json_encode($success);


    // **************************************************
    function addOneBookToUsersCart($userId, $bookId, $conn) {
        $queryQuantity= sprintf("SELECT quantity FROM booksincart WHERE bookEditionId = '%s' AND userId = '%s'", $bookId, $userId);
        $currentQuantity = 0;
        if ($result = $conn->query($queryQuantity)) {
            if ($result->num_rows >= 1) {
                $row = $result->fetch_assoc();
                $currentQuantity = $row["quantity"];
                $newQuantity = $currentQuantity + 1;
                $queryAdd = sprintf("UPDATE booksincart SET quantity = '%s' WHERE bookEditionId = '%s' AND userId = '%s'", $newQuantity, $bookId, $userId);
                return $conn->query($queryAdd);
            } else {
                $quantity = 1;
                $queryInsert = sprintf("INSERT INTO booksincart (bookEditionId, userId) VALUES (%d, %d)", $bookId, $userId);
                return $conn->query($queryInsert);
            }
        } else {
            return false;
        }
    }
?>