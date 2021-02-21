<?php
    class User {
        private $name;
        private $password;

        function __construct($name, $password) {
            $this->name = $name;
            $this->password = $password;
        }

        function getName() {
            return $this->name;
        }

        function getPassword() {
            return $this->password;
        }

        function saveInDatabase($conn) {
            $query= sprintf("INSERT INTO User (UserName, Password) VALUES ('%s', '%s');", $this->name, $this->password);
            return $conn->query($query);
        }

        public static function getFromDatabase($name, $conn) {
            $query= sprintf("SELECT * FROM User WHERE UserName = '%s'", $name);
            if ($result = $conn->query($query)) {
                if ($result->num_rows >= 1) {
                    $row = $result->fetch_assoc();
                    return new User($row["UserName"], $row["Password"]);
                } else {
                    return null;
                }
            }
            return null;
        }
    }
?>