<?php

namespace App\Models;

use App\Core\Model;

class TipoVenta extends Model {
    private $table = "facts_tipo_ventas";
    /**
     * Crea un nuevo Material.
     *
     * @param array $data Datos del Material.
     * @return bool True si el Material fue creado exitosamente, false en caso contrario.
     */
    public function create(array $data) {

        return $this->save($data, null, $this->table);
    }

    /**
     * Modifica un Material existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si el Material fue modificado exitosamente, false en caso contrario.
     */
    public function edit($id, array $data) {
        return $this->save($data, $id, $this->table);
    }

    public function editDefault(){
        $query = "UPDATE $this->table SET margen = 0 WHERE 1";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    

    /**
     * Consulta un Material por ID.
     *
     * @param int $id
     * @return array|null Información del Material si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todos los Materials.
     *
     * @return array Listado de todos los Materials.
     */
    public function all() {
        $query = "SELECT * FROM  $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un Material por ID.
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
     * Verifica si un Material existe por ID.
     *
     * @param int $id
     * @return bool True si el Material existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si un Material existe por nombre.
     *
     * @param string $nombre
     * @return bool True si el Material existe, false en caso contrario.
     */
    public function byNombre($nombre) {
        $query = "SELECT nombre FROM  $this->table WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }


}
