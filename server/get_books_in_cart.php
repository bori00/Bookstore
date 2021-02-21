<?php
    session_start();
    include "database_connection.php";
    include "Book.php";

    $books = Book::getBooksInCartFromDatabase($_SESSION["LoggedInUserId"], $conn);

    header('Content-Type: application/json');
    $conn->close();
    echo json_encode($books);
?>