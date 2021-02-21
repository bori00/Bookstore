<?php
    include_once  "Book.php";
    include_once  "SaveOrderResult.php";

    class Order implements \JsonSerializable {
        private $id;
        private $userId;
        private $time;
        private $shippingAddressId;
        private $statusId;
        private $notes;

        function __construct($id, $userId, $time, $shippingAddressId, $statusId, $notes) {
            $this->id = $id;
            $this->userId = $userId;
            $this->time = $time;
            $this->shippingAddressId = $shippingAddressId;
            $this->statusId = $statusId;
            $this->notes = $notes;
        }

        function getId() {
            return $this->id;
        }

        function saveAsNewInDatabase($conn) { //time is set to current time
            date_default_timezone_set('Europe/Bucharest'); 
            // consists of multiple queryies - disable autocommit
            $conn -> autocommit(FALSE);
            $missingBookStatus = $this->missingBook($conn);
            if ($missingBookStatus->isSuccessful()) { //no missing book
                $insertOrder = sprintf("INSERT INTO orders (userId, time, shippingAddressId, statusId, notes) VALUES (%d, '%s', %d, %d, '%s');", 
                                $this->userId, date('Y-m-d H:i:s'), $this->shippingAddressId, $this->statusId, $this->notes);
                if ($conn->query($insertOrder)) {
                    $this->id = mysqli_insert_id($conn); //the id of the new order
                    if ($this->addBooksToOrder($this->id, $conn) && $this->decreaseStock($conn) && $this->removeBooksFromCart($conn)) {
                        $conn->commit();
                        return new SaveOrderResult(true, null, null);
                    } else {
                        return new SaveOrderResult(false, SaveOrderResult::DATABASE_ERROR, null);
                    }
                } else {
                    $conn->rollback();
                    return new SaveOrderResult(false, SaveOrderResult::DATABASE_ERROR, null);
                }
            } else {
                $conn->rollback();
                return $missingBookStatus;
            }
        }

        // Returns the book from which there are not enough samples available. 
        function missingBook($conn) {
            $missingBookQuery = sprintf("SELECT title FROM cart_data WHERE quantity < quantityInCart AND userId = '%s'", $this->userId);
            if ($result = $conn->query($missingBookQuery)) {
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    return new SaveOrderResult(false, SaveOrderResult::MISSING_BOOK_ERROR, $row["title"]);
                } else {
                    return new SaveOrderResult(true, null, null);
                }
            }
            return new SaveOrderResult(false, SaveOrderResult::DATABASE_ERROR, null);
        }

        function decreaseStock($conn) {
            $stockQuery = sprintf("UPDATE bookedition be JOIN booksincart cart ON be.bookEditionId = 
                    cart.bookEditionId SET be.quantity = be.quantity - cart.quantity WHERE cart.userId = %s;", $this->userId);
            if (!$conn->query($stockQuery)) {
                $conn ->rollback();
                return false;
            } else {
                return true;
            }
        }

        function removeBooksFromCart($conn) {
            $query= sprintf("DELETE FROM booksincart WHERE userId = '%s'", $this->userId);
            if (!$conn->query($query)) {
                $conn->rollback();
                return false;
            } else {
                return true;
            }
        }
        
        function addBooksToOrder($orderId, $conn) {
            $query= sprintf("INSERT INTO booksinorder (orderId, bookEditionId, quantity, unitPrice) SELECT '%s', cart.bookEditionId, cart.quantity, be.price 
                            FROM booksincart cart JOIN bookedition be ON be.bookEditionId = cart.bookEditionId WHERE cart.userId = '%s';", $orderId, $this->userId);
            if (!$conn->query($query)) {
                $conn->rollback();
                return false;
            } else {
                return true;
            }
        }

        function jsonSerialize() {
            return get_object_vars($this);
        }
    }
?>