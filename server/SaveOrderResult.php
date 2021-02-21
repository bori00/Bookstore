<?php
    class SaveOrderResult implements \JsonSerializable {
        private $successful;
        private $errorType;
        private $missingBookName;

        const DATABASE_ERROR = "SaveOrder: Database Error";
        const MISSING_BOOK_ERROR = "SaveOrder: Missing Book Error";
        const DUPLICATE_ADDRESSNAME = "Duplicate AddressName";

        function __construct($successful, $errorType, $missingBookName) {
            $this->successful = $successful;
            if ($this->successful) {
                $this->errorType = null;
                $this->missingBookName = null;
            } else {
                $this->errorType = $errorType;
                if ($this->errorType == SaveOrderResult::MISSING_BOOK_ERROR) {
                    $this->missingBookName = $missingBookName;
                } else {
                    $this->missingBookName = null;
                }
            }
        }

        function isSuccessful() {
            return $this->successful;
        }

        public function jsonSerialize() {
            return get_object_vars($this);
        }
    }
?>