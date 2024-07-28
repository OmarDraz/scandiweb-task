<?php
// src/Database.php
namespace Omar\Scandiweb;

use PDO;
use PDOException;

class Database {
    private $host = 'sql.freedb.tech';
    private $db_name = 'freedb_scandiweb';
    private $username = 'freedb_omar_scandiweb';
    private $password = 'G!53ebYE4P&VXrG';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
