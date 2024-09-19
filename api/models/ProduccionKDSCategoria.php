<?php

namespace App\Models;

use App\Core\Model;

class ProduccionKDSCategoria extends Model {
    private $table = "produccion_kds_categorias";
    /**
     * Crea un nuevo KDSCategoria.
     *
     * @param array $data Datos del KDSCategoria.
     * @return bool True si el KDSCategoria fue creado exitosamente, false en caso contrario.
     */
    public function asignarCategorias($idKds, array $categorias) {
        try {
            $this->conn->beginTransaction();
    
            // Eliminar las categorías actuales del KDS para evitar duplicados
            $queryDelete = "DELETE FROM $this->table WHERE id_kds = :id_kds";
            $stmtDelete = $this->conn->prepare($queryDelete);
            $stmtDelete->bindParam(':id_kds', $idKds, \PDO::PARAM_INT);
            $stmtDelete->execute();
    
            // Insertar las nuevas categorías
            $queryInsert = "INSERT INTO $this->table (id_kds, id_categoria) VALUES (:id_kds, :id_categoria)";
            $stmtInsert = $this->conn->prepare($queryInsert);
    
            foreach ($categorias as $idCategoria) {
                $stmtInsert->bindParam(':id_kds', $idKds, \PDO::PARAM_INT);
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
    public function obtenerCategoriasPorKDS($idKds) {
        $query = "SELECT c.* FROM produccion_categorias c
                  JOIN $this->table kc ON kc.id_categoria = c.id
                  WHERE kc.id_kds = :id_kds";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kds', $idKds, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);  
    }

    /**
     * Verifica si un KDSCategoria existe por ID.
     *
     * @param int $id
     * @return bool True si el KDSCategoria existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }



}
