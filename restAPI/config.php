<!--    Autor:  MF              -->
<!--    File:   config.php      -->
<?php
class mysql
    {
        private $servername= '';
        private $username= '';
        private $password= '';
        private $dbname= '';
        public $conn= NULL;

        function __construct() {
            @$this->conn= new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("MySQL Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
        }

        // Returns TRUE or FALSE
        public function query($sql) {
            $result = $this->conn->query($sql);
            return $result;
        }

        // Returns an Array
        public function get($sql) {
            $result = $this->conn->query($sql);
            
            if (is_object($result) && $result->num_rows > 0) {
                $data= array();
                while($row = $result->fetch_assoc()) {
                    $data[]= $row;
                }
            } 
            else 
            {
                return false;
            }
            
            return $data;
        }
    }
?>