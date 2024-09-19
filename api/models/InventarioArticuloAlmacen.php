<?php

namespace App\Models;

use App\Core\Model;

class InventarioArticuloAlmacen extends Model {
    private $table = "inv_articulo_almacen";
    /**
     * Crea un nuevo Articulo en inventario.
     *
     * @param array $data Datos del Articulo en inventario.
     * @return bool True si el Articulo en inventario fue creado exitosamente, false en caso contrario.
     */
    public function create(array $data) {
        return $this->save($data, null, $this->table);
    }

    /**
     * Modifica un Articulo en inventario existente.
     *
     * @param int $id 
     * @param array $data 
     * @return bool True si el Articulo en inventario fue modificado exitosamente, false en caso contrario.
     */
    public function edit($id, array $data) {
        return $this->save($data, $id, $this->table);
    }

    /**
     * Consulta un Articulo en inventario por ID.
     *
     * @param int $id
     * @return array|null Información del Articulo en inventario si existe, null en caso contrario.
     */
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Consulta todos los Articulo en inventarios.
     *
     * @return array Listado de todos los Articulo en inventarios.
     */
    public function all() {
        $query = "SELECT * FROM  $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un Articulo en inventario por ID.
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
     * Verifica si un Articulo en inventario existe por ID.
     *
     * @param int $id
     * @return bool True si el Articulo en inventario existe, false en caso contrario.
     */
    public function byId($id) {
        $query = "SELECT id FROM  $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Verifica si un Articulo en inventario existe por nombre.
     *
     * @param string $codigo_prod
     * @return bool True si el Articulo en inventario existe, false en caso contrario.
     */
    public function byNombre($codigo_prod) {
        $query = "SELECT codigo_prod FROM  $this->table WHERE codigo_prod = :codigo_prod";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo_prod', $codigo_prod);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Actualiza el stock sumando una cantidad al stock actual.
     *
     * @param int $id ID del material.
     * @param float $cantidad Cantidad a sumar al stock actual.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function actualizarStock($id, $cantidad, $signo) {
        // Consulta el stock actual del material
        $query = "SELECT stock FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $material = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($signo == '-'){
            $cantidad = $cantidad * -1;
        }

        if ($material) {
            $nuevoStock = $material['stock'] + $cantidad;

            // Actualiza el nuevo stock en la base de datos
            $updateQuery = "UPDATE $this->table SET stock = :nuevoStock WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':nuevoStock', $nuevoStock);
            $updateStmt->bindParam(':id', $id);
            return $updateStmt->execute();
        }

        return false;
    }
}
