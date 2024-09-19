<?php

namespace App\Models;

use App\Core\Model;

class ProduccionKDS extends Model {
    private $table = "produccion_kds";
    /**
     * Crea un nuevo KDS.
     *
     * @param array $data Datos del KDS.
     * @return bool True si el KDS fue creado exitosamente, false en caso contrario.
     */
    public function create(array $data) {
        return $this->save($data, null, $this->table);
    }

    /**
     * Modifica un KDS existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si el KDS fue modificado exitosamente, false en caso contrario.
     */
    public function edit($id, array $data) {
        return $this->save($data, $id, $this->table);
    }

    /**
     * Consulta un KDS por ID.
     *
     * @param int $id
     * @return array|null Información del KDS si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todos los KDSs.
     *
     * @return array Listado de todos los KDSs.
     */
    public function all() {
        $query = "SELECT * FROM  $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un KDS por ID.
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
     * Verifica si un KDS existe por ID.
     *
     * @param int $id
     * @return bool True si el KDS existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si un KDS existe por codigo.
     *
     * @param string $codigo
     * @return bool True si el KDS existe, false en caso contrario.
     */
    public function byNombre($codigo) {
        $query = "SELECT codigo FROM  $this->table WHERE codigo = :codigo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Muestra toda la información de la sucursal con respecto al kds
     *
     * @param string $idKds
     * @return array Listado de todos los KDS.
     */
    public function sucursal($idKds) {
        $query = "SELECT s.* FROM produccion_sucursales s
                  JOIN produccion_kds k ON k.id_sucursal = s.id
                  WHERE k.id = :id_kds";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kds', $idKds, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
    
}
