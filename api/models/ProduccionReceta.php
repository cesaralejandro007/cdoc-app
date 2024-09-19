<?php

namespace App\Models;

use App\Core\Model;

class ProduccionReceta extends Model {
    private $table = "produccion_recetas";
    /**
     * Crea un nuevo Receta.
     *
     * @param array $data Datos del Receta.
     * @return bool True si el Receta fue creado exitosamente, false en caso contrario.
     */
    public function create(array $data) {
        return $this->save($data, null, $this->table);
    }

    /**
     * Modifica un Receta existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si el Receta fue modificado exitosamente, false en caso contrario.
     */
    public function edit($id, array $data) {
        return $this->save($data, $id, $this->table);
    }

    /**
     * Consulta un Receta por ID.
     *
     * @param int $id
     * @return array|null Información del Receta si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todos los Recetas.
     *
     * @return array Listado de todos los Recetas.
     */
    public function all() {
        $query = "SELECT * FROM  $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un Receta por ID.
     *
     * @param int $id 
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function delete($id) {
        $query = "DELETE FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Verifica si un Receta existe por ID.
     *
     * @param int $id
     * @return bool True si el Receta existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si un Receta existe por nombre.
     *
     * @param string $nombre
     * @return bool True si el Receta existe, false en caso contrario.
     */
    public function byNombre($nombre) {
        $query = "SELECT nombre FROM  $this->table WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
