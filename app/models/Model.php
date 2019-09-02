<?php

namespace App\models;

use App\facades\DB;

abstract class Model
{
    protected $table;
    protected $conn;
    protected $query;

    private $stmt;

    public function __construct()
    {
        // Set table name
        $this->table = $this->getTableName();

        $this->conn = DB::connect();
    }

    // Gets the table name
    private function getTableName()
    {
        $segments = explode('\\', get_class($this));
        $child_class = end($segments);
        $trimmed = trim($child_class);
        $lowercased = strtolower($trimmed);
        $child_class = pluralize($lowercased);
        return $child_class;
    }

    // Prepares the DB query
    protected function prepare()
    {
        $this->stmt = $this->conn->prepare($this->query);
        return $this;
    }

    // Executes query
    protected function execute($bind_params)
    {
        is_array($bind_params) ?
        $this->stmt->execute($bind_params)
        :
        $this->stmt->execute();
        return $this;
    }

    // Queries from DB
    public function query(string $query, $bind_params = null)
    {
        $this->query = $query;
        return $this->prepare()->execute($bind_params);
    }

    // Get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function fetchAll()
    {
        return $this->stmt->fetchAll();
    }

    public function fetch()
    {
        return $this->stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function error()
    {
        return $this->stmt->error;
    }
}