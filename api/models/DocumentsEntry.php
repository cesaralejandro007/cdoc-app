<?php

namespace App\Models;

use App\Core\Model;

class DocumentsEntry extends Model {
    private $table = "documentos";
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
        $query = "SELECT documentos.id_documento AS id_documento, documentos.fecha_entrada AS fecha_entrada, documentos.fecha_registro AS fecha_registro, documentos.descripcion AS descripcion, documentos.numero_doc AS numero_doc, documentos.estatus AS estatus, remitentes.id_remitente AS id_remitente,tipos_documentos.id_tipo_documento AS id_tipo_documento,remitentes.nombre_rem AS nombre_rem,tipos_documentos.nombre_doc AS nombre_doc, tipos_documentos.descripcion_doc AS descripcion_doc, usuarios.id_usuario AS id_usuario, usuarios.cedula AS cedula, usuarios.nombres AS nombres, usuarios.apellidos AS apellidos, usuarios.rol AS rol, DATE_FORMAT(documentos.fecha_entrada, '%d/%m/%Y') AS fecha_entrada_formateada, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo FROM documentos,tipos_documentos,remitentes,usuarios WHERE documentos.id_tipo_documento = tipos_documentos.id_tipo_documento AND documentos.id_remitente = remitentes.id_remitente AND documentos.id_usuario = usuarios.id_usuario AND documentos.estatus = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function allDocType() {
        $query = "SELECT * FROM tipos_documentos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function allSenderType() {
        $query = "SELECT * FROM remitentes";
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
