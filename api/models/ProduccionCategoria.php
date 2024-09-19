<?php

namespace App\Models;

use App\Core\Model;

class ProduccionCategoria extends Model {

    /**
     * Crea una nueva categoría de producción.
     *
     * @param array $data Datos de la categoría (debe incluir 'nombre').
     * @return bool True si la categoría fue creada exitosamente, false en caso contrario.
     */
    public function create($nombre) {
        $query = "INSERT INTO produccion_categorias (nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        return $stmt->execute(); 
    }

    /**
     * Modifica una categoría de producción existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si la categoría fue modificada exitosamente, false en caso contrario.
     */
    public function edit($id, $data) {
        $nombre = $data['nombre'] ?? '';
        $query = "UPDATE produccion_categorias SET nombre = :nombre WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Consulta una categoría de producción por ID.
     *
     * @param int $id
     * @return array|null Información de la categoría si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM produccion_categorias WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todas las categorías de producción.
     *
     * @return array Listado de todas las categorías.
     */
    public function all() {
        $query = "SELECT * FROM produccion_categorias";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina una categoría de producción por ID.
     *
     * @param int $id 
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function delete($id) {
        $query = "DELETE FROM produccion_categorias WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Verifica si una categoría de producción existe por id.
     *
     * @param string $id
     * @return bool True si la categoría existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM produccion_categorias WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si una categoría de producción existe por id.
     *
     * @param string $id
     * @return bool True si la categoría existe, false en caso contrario.
     */
    public function byName($nombre) {
        $query = "SELECT nombre FROM produccion_categorias WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
