<?php
    class Book implements \JsonSerializable {
        private $id;
        private $ISBN;
        private $title;
        private $writerName;
        private $description; //nullable
        private $editionNr;
        private $editionYear;
        private $availableQuantity;
        private $quantityInCart;
        private $price;

        function __construct($id, $ISBN, $title,  $writerName, $description, $editionNr, $editionYear, $availableQuantity, $quantityInCart, $price) {
            $this->id = $id;
            $this->ISBN = $ISBN;
            $this->writerName = $writerName;
            $this->title = $title;
            $this->description = $description;
            $this->editionNr = $editionNr;
            $this->editionYear = $editionYear;
            $this->availableQuantity = $availableQuantity;
            $this->quantityInCart = $quantityInCart;
            $this->price = $price;
        }

        function getId() {
            return $this->id;
        }

        function getISBN() {
            return $this->ISBN;
        }

        function getTitle() {
            return $this->title;
        }

        function getWriterName() {
            return $this->writerName;
        }

        function getDescription() {
            return $this->description;
        }

        function getEditionNr() {
            return $this->editionNr;
        }

        function getEditionYear() {
            return $this->editionYear;
        }

        function getAvailableQuantity() {
            return $this->availableQuantity;
        }

        function getQuantityInCart() {
            return $this->quantityInCart;
        }

        function getPrice() {
            return $this->price;
        }

        static function getAvailableBooksFromDatabase($userId, $conn) {
            $query= sprintf("SELECT ab.bookEditionId AS bookEditionId, ISBN, title, firstName, lastName, description, editionNr, editionYear, ab.quantity AS quantity,
                            price, bc.quantity As quantityInCart
                            FROM available_book_data ab LEFT JOIN booksincart bc ON (ab.bookEditionId = bc.bookEditionId AND bc.userId = '%s')", $userId);
            $books = array();
            if ($result = $conn->query($query)) {
                while($row = $result->fetch_assoc()) {
                    array_push($books, new Book($row["bookEditionId"], $row["ISBN"], $row["title"], 
                                $row["firstName"] ." ". $row["lastName"], $row["description"], $row["editionNr"],
                                 $row["editionYear"], $row["quantity"], $row["quantityInCart"], $row["price"]));
                }
            }
            return $books;
        }

        static function getBooksInCartFromDatabase($userId, $conn) {
            $query= sprintf("SELECT * FROM cart_data WHERE userId = '%s'", $userId);
            $books = array();
            if ($result = $conn->query($query)) {
                while($row = $result->fetch_assoc()) {
                    array_push($books, new Book($row["bookEditionId"], $row["ISBN"], $row["title"], 
                                $row["firstName"] ." ". $row["lastName"], $row["description"], $row["editionNr"],
                                 $row["editionYear"], $row["quantity"], $row["quantityInCart"], $row["price"]));
                }
            }
            return $books;
        }

        public function jsonSerialize() {
            return get_object_vars($this);
        }
    }
?>