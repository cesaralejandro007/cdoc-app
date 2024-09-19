<?php

namespace App\Models;

use App\Core\Model;

class ProduccionAlmacen extends Model {

    /**
     * Crea una nueva Almacen de producción.
     *
     * @param array $data Datos de la Almacen (debe incluir 'nombre').
     * @return bool True si la Almacen fue creada exitosamente, false en caso contrario.
     */
    public function create(array $data) {
        $query = "INSERT INTO produccion_almacenes (nombre, id_sucursal) VALUES (:nombre, :id_sucursal)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':id_sucursal', $data['id_sucursal']);
        return $stmt->execute(); 
    }
    

    /**
     * Modifica una Almacen de producción existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si la Almacen fue modificada exitosamente, false en caso contrario.
     */
    public function edit($id, $data) {
        $nombre = $data['nombre'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $id_sucursal = $data['id_sucursal'] ?? '';
        $query = "UPDATE produccion_almacenes SET nombre = :nombre, id_sucursal = :id_sucursal WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id_sucursal', $id_sucursal);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Consulta una Almacen de producción por ID.
     *
     * @param int $id
     * @return array|null Información de la Almacen si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM produccion_almacenes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todos los Almacenes de producción.
     *
     * @return array Listado de todos los Almacenes.
     */
    public function all() {
        $query = "SELECT * FROM produccion_almacenes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina una Almacen de producción por ID.
     *
     * @param int $id 
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function delete($id) {
        $query = "DELETE FROM produccion_almacenes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Verifica si una Almacen de producción existe por id.
     *
     * @param string $id
     * @return bool True si la Almacen existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM produccion_almacenes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si una Almacen de producción existe por id.
     *
     * @param string $id
     * @return bool True si la Almacen existe, false en caso contrario.
     */
    public function byName($nombre) {
        $query = "SELECT nombre FROM produccion_almacenes WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
