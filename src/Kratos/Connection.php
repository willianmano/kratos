<?php

namespace Kratos;

use Exception;
use InvalidArgumentException;
use PDO;
use stdClass;

class Connection extends AbstractConnection {

    private $connection;

    public function __construct($connection)
    {
        if ($connection instanceof PDO) {
            $this->connection = $connection;
        } else {
            throw new InvalidArgumentException(
                '$connection must be an instance of PDO.'
            );
        }
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $results = $stmt->execute(array($id));

        $results = $stmt->fetchAll();

        return current($results);
    }
    public function getByArguments($parameters)
    {
        return true;
    }
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();

        return $results;
    }
    public function insert($data)
    {
        $sql = $this->prepareInsertStatement($data);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        // $data['id'] = $this->connection->lastInsertId();

        return $this->connection->lastInsertId();
    }
    public function update($data)
    {
        $sql = $this->prepareUpdateStatement($data);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($data['id']));

        return $data['id'];
    }
    public function delete($id)
    {
        $data = $this->getById($id);
        if(!empty($data)) {
            $sql =  "DELETE FROM {$this->table} WHERE id = ?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array($data['id']));

            return true;
        }
        
        return false;
    }
    protected function prepareInsertStatement($data)
    {
        $sql = "INSERT INTO {$this->table} ";
        $fields = "(";
        $values = ") VALUES (";
        foreach ($data as $key => $value) {
            if (end(array_keys($data)) == $key) {
                $fields .= "`" . $key . "`";
                $values .= "'". $value . "'";
            } else {
                $fields .= "`" . $key . "`,";
                $values .= "'". $value . "',";
            }
        }
        $sql .= $fields;
        $sql .= $values;
        $sql .= ");";

        return $sql;
    }
    protected function prepareUpdateStatement($data)
    {
        $sql = "UPDATE {$this->table} SET ";
        foreach ($data as $key => $value) {
            if ($key == 'id')
                continue;
            if (end(array_keys($data)) == $key) {
                $sql .= "`" . $key . "` = '" . $value . "'";
            } else {
                $sql .= "`" . $key . "` = '" . $value . "',";    
            }
        }
        $sql .= " WHERE id = ?";

        return $sql;
    }
}