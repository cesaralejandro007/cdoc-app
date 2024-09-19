<?php

namespace App\Controllers;

use App\Models\ProduccionAlmacen;
use App\Models\ProduccionSucursal;
use App\Core\Controller;
use App\Core\Responses;

class ProduccionAlmacenController extends Controller {

    protected $almacen;
    protected $sucursal;
    protected $responses;

    public function __construct() {
        $this->almacen = new ProduccionAlmacen();
        $this->sucursal = new ProduccionSucursal();
        $this->responses = new Responses();  
    }

    public function create($request) {
        $fields = [
            'nombre' => $request['nombre'] ?? null,
            'id_sucursal' => $request['id_sucursal'] ?? null
        ];
    
        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 1, 100);
        $errors[] = $this->validateField('id_sucursal', $fields['id_sucursal'], true, 'int', 1, 255);
    
        $errors = array_filter($errors);
    
        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
    
        if ($this->almacen->byName($fields['nombre'])) {
            return $this->responses->error("El almacen ya existe", 409);
        }

        if ($this->sucursal->byId($fields['id_sucursal'])) {
            return $this->responses->error("Sucursal no existe", 404);
        }
    
        if ($this->almacen->create($fields)) {
            return $this->responses->success("Almacen creado exitosamente");
        }
    
        return $this->responses->error("Error al crear el almacen", 500);
    }

    public function edit($id, $request) {
        if (!$this->almacen->byId($id)) {
            return $this->responses->error("El almacen no existe", 404);
        }


        $fields = [
            'nombre' => $request['nombre'] ?? null,
            'id_sucursal' => $request['id_sucursal'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 1, 100);
        $errors[] = $this->validateField('id_sucursal', $fields['id_sucursal'], true, 'int', 1, 255);

        $errors = array_filter($errors);

        if (!$this->sucursal->byId($fields['id_sucursal'])) {
            return $this->responses->error("Sucursal no existe", 404);
        }
        
        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->almacen->edit($id, $fields)) {
            return $this->responses->success("Almacen actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el almacen", 500);
    }

    public function getById($id) {
        $almacen = $this->almacen->getById($id);

        if (!$almacen) {
            return $this->responses->error("Almacen no encontrado", 404);
        }

        return $this->responses->success("Almacen encontrado", $almacen);
    }

    public function all() {
        $almacen = $this->almacen->all();

        if (empty($almacen)) {
            return $this->responses->error("No hay almacenes disponibles", 404);
        }

        return $this->responses->success("Almacenes obtenidos", $almacen, count($almacen));
    }

    public function delete($id) {
        if (!$this->almacen->byId($id)) {
            return $this->responses->error("El almacen no existe", 404);
        }

        if ($this->almacen->delete($id)) {
            return $this->responses->success("Almacen eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el almacen", 500);
    }
}
