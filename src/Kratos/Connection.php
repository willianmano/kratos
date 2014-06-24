<?php

namespace Kratos;

use Exception;
use InvalidArgumentException;
use PDO;
use stdClass;

class Connection extends AbstractConnection {

    private $connection;

    public function __construct($connection) {
        if ($connection instanceof PDO) {
            $this->connection = $connection;
        } else {
            throw new InvalidArgumentException(
                '$connection must be an instance of PDO.'
            );
        }
    }

    public function getById() {

    }
    public function getByArguments() {

    }
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();

        return $results;
    }
    public function insert() {

    }
    public function update() {

    }
    public function delete() {

    }
}