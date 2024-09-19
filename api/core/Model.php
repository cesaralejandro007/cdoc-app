<?php

namespace App\Core;

use App\Config\Database;

class Model {
    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function save(array $data, $id = null, $table) {
        $fields = array_keys($data);
        $fieldString = implode(', ', $fields);
        $placeholderString = ':' . implode(', :', $fields);
        
        if ($id) {
            $setString = implode(', ', array_map(fn($field) => "$field = :$field", $fields));
            $query = "UPDATE $table SET $setString WHERE id = :id";
        } else {
            $query = "INSERT INTO $table ($fieldString) VALUES ($placeholderString)";
        }

        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($id) {
            $stmt->bindValue(':id', $id);
        }

        return $stmt->execute(); 
    }
}
?>
