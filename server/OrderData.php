<?php
    class OrderData implements \JsonSerializable {
        private $id;
        private $time;
        private $addressName;
        private $country;
        private $city;
        private $street;
        private $number;
        private $postalCode;
        private $status;
        private $totalPrice;

        function __construct($id, $time, $addressName, $country, $city, $street, $number, $postalCode, $status, $totalPrice) {
            $this->id = $id;
            $this->time = $time;
            $this->addressName = $addressName;
            $this->country = $country;
            $this->city = $city;
            $this->street = $street;
            $this->number = $number;
            $this->postalCode = $postalCode;
            $this->status = $status;
            $this->totalPrice = $totalPrice;
        }

    
        static function getUsersOrderDataFromDatabase($userId, $conn) {
            $query = sprintf("select * FROM order_data WHERE userId = '%s';", $userId);
            $ordersData = array();
            if ($result = $conn->query($query)) {
                while($row = $result->fetch_assoc()) {
                    array_push($ordersData, new OrderData($row["orderId"], $row["time"], $row["addressName"], 
                                $row["country"], $row["city"], $row["street"], $row["number"],
                                 $row["postalCode"], $row["status"], $row["totalPrice"]));
                }
            }
            return $ordersData;
        }

        function jsonSerialize() {
            return get_object_vars($this);
        }
    }
?>