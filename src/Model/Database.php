<?php
namespace sirJuni\Framework\Model;

use PDO;
use sirJuni\Framework\Helper\HelperFuncs;

class Database {
    protected $db;

    protected function dbConnect() {
        $dsn = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";";
        $dbUser = DB_USER;
        $dbPass = DB_PASS;

        try {
            $this->db = new PDO($dsn, $dbUser, $dbPass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            HelperFuncs::report($e);
        }
    }
}

?>