<?php

namespace App\Models;

use App\Core\Model;

class Usuario extends Model {
    private $table = "usuarios";
    /**
     * Crea un nuevo Usuario.
     *
     * @param array $data Datos del Usuario.
     * @return bool True si el Usuario fue creado exitosamente, false en caso contrario.
     */
    public function create(array $data) {

        return $this->save($data, null, $this->table);
    }

    /**
     * Modifica un Usuario existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si el Usuario fue modificado exitosamente, false en caso contrario.
     */
    public function edit($id, array $data) {
        return $this->save($data, $id, $this->table);
    }

    /**
     * Consulta un Usuario por ID.
     *
     * @param int $id
     * @return array|null Información del Usuario si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todos los Usuarios.
     *
     * @return array Listado de todos los Usuarios.
     */
    public function all() {
        $query = "SELECT empresa, tienda, codigo, nick, nombre, apellido, email, rol, imagen, cedula, status, telefono FROM  $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un Usuario por ID.
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
     * Verifica si un Usuario existe por ID.
     *
     * @param int $id
     * @return bool True si el Usuario existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si un Usuario existe por cedula.
     *
     * @param string $cedula
     * @return bool True si el Usuario existe, false en caso contrario.
     */
    public function byCedula($cedula) {
        $query = "SELECT cedula FROM  $this->table WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
