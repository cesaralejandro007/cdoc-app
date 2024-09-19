<?php

namespace App\Models;

use App\Core\Model;

class ProduccionSucursal extends Model {

    /**
     * Crea una nueva Sucursal de producción.
     *
     * @param array $data Datos de la Sucursal (debe incluir 'nombre').
     * @return bool True si la Sucursal fue creada exitosamente, false en caso contrario.
     */
    public function create(array $data) {
        $query = "INSERT INTO produccion_sucursales (nombre, direccion, principal) VALUES (:nombre, :direccion, :principal)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':principal', $data['principal']);
        return $stmt->execute(); 
    }
    

    /**
     * Modifica una Sucursal de producción existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si la Sucursal fue modificada exitosamente, false en caso contrario.
     */
    public function edit($id, $data) {
        $nombre = $data['nombre'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $principal = $data['principal'] ?? '';
        $query = "UPDATE produccion_sucursales SET nombre = :nombre, direccion = :direccion, principal = :principal WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':principal', $principal);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Consulta una Sucursal de producción por ID.
     *
     * @param int $id
     * @return array|null Información de la Sucursal si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM produccion_sucursales WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todas las Sucursals de producción.
     *
     * @return array Listado de todas las Sucursals.
     */
    public function all() {
        $query = "SELECT * FROM produccion_sucursales";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina una Sucursal de producción por ID.
     *
     * @param int $id 
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function delete($id) {
        $query = "DELETE FROM produccion_sucursales WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); 
    }

    /**
     * Verifica si una Sucursal de producción existe por id.
     *
     * @param string $id
     * @return bool True si la Sucursal existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM produccion_sucursales WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si una Sucursal de producción existe por id.
     *
     * @param string $id
     * @return bool True si la Sucursal existe, false en caso contrario.
     */
    public function byName($nombre) {
        $query = "SELECT nombre FROM produccion_sucursales WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Muestra todos los kds de una sucursal en especifico
     *
     * @param string $idSucursal
     * @return array Listado de todos los KDS.
     */
    public function kds($idSucursal) {
        $query = "SELECT * FROM produccion_kds WHERE id_sucursal = :id_sucursal";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_sucursal', $idSucursal, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);  
    }
    
}
