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
            // Actualización
            $setString = implode(', ', array_map(fn($field) => "$field = :$field", $fields));
            $query = "UPDATE $table SET $setString WHERE id_documento = :id";
        } else {
            // Inserción
            $query = "INSERT INTO $table ($fieldString) VALUES ($placeholderString)";
        }
    
        $stmt = $this->conn->prepare($query);
    
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    
        if ($id) {
            $stmt->bindValue(':id', $id);
        }
    
        if ($stmt->execute()) {
            if (!$id) {
                // Si es una inserción, obtener el ID generado
                $id = $this->conn->lastInsertId();
            }
    
            // Retornar los datos insertados o actualizados, incluyendo el ID
            return array_merge(['id_documento' => $id], $data);
        }
    
        return false; // Si la ejecución falla, retornar false
    }
    
}
?>
