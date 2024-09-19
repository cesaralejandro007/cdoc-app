<?php

namespace App\Models;

use App\Core\Model;

class ProduccionRecetaCategoria extends Model {
    private $table = "produccion_categorias_receta";
    /**
     * Crea un nuevo RecetaCategoria.
     *
     * @param array $data Datos del RecetaCategoria.
     * @return bool True si el RecetaCategoria fue creado exitosamente, false en caso contrario.
     */
    public function asignarCategorias($idKds, array $categorias) {
        try {
            $this->conn->beginTransaction();
    
            // Eliminar las categorías actuales del KDS para evitar duplicados
            $queryDelete = "DELETE FROM $this->table WHERE id_receta = :id_receta";
            $stmtDelete = $this->conn->prepare($queryDelete);
            $stmtDelete->bindParam(':id_receta', $idKds, \PDO::PARAM_INT);
            $stmtDelete->execute();
    
            // Insertar las nuevas categorías
            $queryInsert = "INSERT INTO $this->table (id_receta, id_categoria) VALUES (:id_receta, :id_categoria)";
            $stmtInsert = $this->conn->prepare($queryInsert);
    
            foreach ($categorias as $idCategoria) {
                $stmtInsert->bindParam(':id_receta', $idKds, \PDO::PARAM_INT);
                $stmtInsert->bindParam(':id_categoria', $idCategoria, \PDO::PARAM_INT);
                $stmtInsert->execute();
            }
    
            // Confirmar la transacción
            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    
    /**
     * Consulta todas las categorias de KDS por ID.
     *
     * @param int $id
     * @return array|null Devuelve un array de categorías
     */
    public function obtenerCategoriasPorReceta($idKds) {
        $query = "SELECT c.* FROM produccion_categorias c
                  JOIN $this->table kc ON kc.id_categoria = c.id
                  WHERE kc.id_receta = :id_receta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_receta', $idKds, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);  
    }

    /**
     * Verifica si una RecetaCategoria existe por ID.
     *
     * @param int $id
     * @return bool True si el RecetaCategoria existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
