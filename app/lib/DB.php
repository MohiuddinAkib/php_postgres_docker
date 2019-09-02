<?php

namespace App\lib;

use PDO;
use PDOException;

class DB
{
    private $conn = null;
    private $dbhost;
    private $dbuser;
    private $dbpassword;
    private $dbname;

    public function __construct()
    {
        $this->dbhost = DB_HOST;
        $this->dbuser = DB_USER;
        $this->dbpassword = DB_PASSWORD;
        $this->dbname = DB_NAME;
    }

    public function connect()
    {
        $dsn = "pgsql:host=$this->dbhost;dbname=$this->dbname";

        try {
            $this->conn = new PDO($dsn, $this->dbuser, $this->dbpassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die(json_encode(["title" => "Connection error", 'msg' => $e->getMessage()]));
        }

        return $this->conn;
    }
}