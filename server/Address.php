<?php
    include_once "Book.php";

    class Address implements \JsonSerializable {
        private $id;
        private $name;
        private $userId;
        private $country;
        private $city;
        private $street;
        private $number;
        private $postalCode;

        function __construct($id, $name, $userId, $country, $city, $street, $number, $postalCode) {
            $this->id = $id;
            $this->name = $name;
            $this->userId = $userId;
            $this->country = $country;
            $this->city = $city;
            $this->street = $street;
            $this->number = $number;
            $this->postalCode = $postalCode;
        }

        function getId() {
            return $this->id;
        }

        function getName() {
            return $this->name;
        }

        function getCountry() {
            return $this->country;
        }

        function getCity() {
            return $this->city;
        }

        function getStreet() {
            return $this->street;
        }

        function getNumber() {
            return $this->number;
        }

        function getPostalCode() {
            return $this->postalCode;
        }

        function saveInDatabase($conn) {
            $query= sprintf("INSERT INTO Address (userId, addressName, country, city, street, number, postalCode) VALUES (%d, '%s', '%s', '%s', '%s', %d, '%s');", 
                $this->userId, $this->name, $this->country, $this->city, $this->street, $this->number, $this->postalCode);
            return $conn->query($query);
        }

        static function getFromDatabase($userId, $addressName, $conn) {
            $query= sprintf("SELECT * FROM Address WHERE userId = %d AND addressName = '%s'", $userId, $addressName);
            if ($result = $conn->query($query)) {
                if ($row = $result->fetch_assoc()) {
                    return new Address($row["addressId"], $row["addressName"], $row["userId"], $row["country"], $row["city"], $row["street"], $row["number"], $row["postalCode"]);
                }
                return null;
            }
            return null;
        }

        static function userHasAddressWithName($userId, $addressName, $conn) {
            return Address::getFromDatabase($userId, $addressName, $conn) != null;
        }

        static function getUsersAddressesFromDatabase($userId, $conn) {
            $query= sprintf("SELECT * FROM Address WHERE userId = %s", $userId);
            $addresses = array();
            if ($result = $conn->query($query)) {
                while($row = $result->fetch_assoc()) {
                    array_push($addresses, new Address($row["addressId"], $row["addressName"], $row["userId"], $row["country"], $row["city"], $row["street"], $row["number"], $row["postalCode"]));
                }
            }
            return $addresses;
        }

        public function jsonSerialize() {
            return get_object_vars($this);
        }
    }
?>