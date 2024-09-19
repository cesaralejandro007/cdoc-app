<?php

namespace App\Models;

use App\Core\Model;

class ProduccionRecetaIngrediente extends Model {
    private $table = "produccion_recetas_ingredientes";
    /**
     * Crea un nuevo RecetaIngredientes.
     *
     * @param array $data Datos del RecetaIngredientes.
     * @return bool True si el RecetaIngredientes fue creado exitosamente, false en caso contrario.
     */
    public function asignarIngredientes($id_receta, array $ingredientes) {
        try {
            // Iniciar la transacción
            $this->conn->beginTransaction();
    
            // Eliminar los ingredientes actuales de la receta para evitar duplicados
            $queryDelete = "DELETE FROM $this->table WHERE id_receta = :id_receta";
            $stmtDelete = $this->conn->prepare($queryDelete);
            $stmtDelete->bindParam(':id_receta', $id_receta, \PDO::PARAM_INT);
            $stmtDelete->execute();
    
            // Insertar los nuevos ingredientes con su medida y cantidad
            $queryInsert = "INSERT INTO $this->table (id_receta, id_ingrediente, id_medida, cantidad)
                            VALUES (:id_receta, :id_ingrediente, :id_medida, :cantidad)";
            $stmtInsert = $this->conn->prepare($queryInsert);
    
            foreach ($ingredientes as $ingrediente) {
                // Se espera que cada elemento del array $ingredientes sea un array asociativo
                // con las llaves 'id_ingrediente', 'id_medida' y 'cantidad'.
                $stmtInsert->bindParam(':id_receta', $id_receta, \PDO::PARAM_INT);
                $stmtInsert->bindParam(':id_ingrediente', $ingrediente['id_ingrediente'], \PDO::PARAM_INT);
                $stmtInsert->bindParam(':id_medida', $ingrediente['id_medida'], \PDO::PARAM_INT);
                $stmtInsert->bindParam(':cantidad', $ingrediente['cantidad'], \PDO::PARAM_STR);  // Usamos STR por DECIMAL
                $stmtInsert->execute();
            }
    
            // Confirmar la transacción
            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            $this->conn->rollBack();
            return false;
        }
    }
    
    
    /**
     * Consulta todas las ingredientes de KDS por ID.
     *
     * @param int $id
     * @return array|null Devuelve un array de categorías
     */
    public function obtenerIngredientesPorReceta($id_receta) {
        $query = "SELECT c.* FROM inv_articulo_almacen c
                  JOIN $this->table kc ON kc.id_ingrediente = c.id
                  WHERE kc.id_receta = :id_receta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);  
    }

    /**
     * Verifica si un RecetaIngredientes existe por ID.
     *
     * @param int $id
     * @return bool True si el RecetaIngredientes existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }



}
