<?php

namespace App\Controllers;

use App\Models\ProduccionSucursal;
use App\Core\Controller;
use App\Core\Responses;

class ProduccionSucursalController extends Controller {

    protected $sucursal;
    protected $responses;

    public function __construct() {
        $this->sucursal = new ProduccionSucursal();
        $this->responses = new Responses();  
    }

    public function create($request) {
        $fields = [
            'nombre' => $request['nombre'] ?? null,
            'direccion' => $request['direccion'] ?? null,
            'principal' => $request['principal'] ?? null
        ];
    
        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 1, 100);
        $errors[] = $this->validateField('direccion', $fields['direccion'], true, 'string', 1, 255);
        $errors[] = $this->validateField('principal', $fields['principal'], true, 'boolean');
    
        $errors = array_filter($errors);
    
        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
    
        if ($this->sucursal->byName($fields['nombre'])) {
            return $this->responses->error("La sucursal ya existe", 409);
        }
    
        if ($this->sucursal->create($fields)) {
            return $this->responses->success("Sucursal creada exitosamente");
        }
    
        return $this->responses->error("Error al crear la sucursal", 500);
    }

    public function edit($id, $request) {
        if (!$this->sucursal->byId($id)) {
            return $this->responses->error("La sucursal no existe", 404);
        }

        $fields = [
            'nombre' => $request['nombre'] ?? null,
            'direccion' => $request['direccion'] ?? null,
            'principal' => $request['principal'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 1, 100);
        $errors[] = $this->validateField('direccion', $fields['direccion'], true, 'string', 1, 255);
        $errors[] = $this->validateField('principal', $fields['principal'], true, 'boolean');

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->sucursal->edit($id, $fields)) {
            return $this->responses->success("Sucursal actualizada exitosamente");
        }

        return $this->responses->error("Error al actualizar la sucursal", 500);
    }

    public function getById($id) {
        $sucursal = $this->sucursal->getById($id);

        if (!$sucursal) {
            return $this->responses->error("Sucursal no encontrada", 404);
        }

        return $this->responses->success("Sucursal encontrada", $sucursal);
    }

    public function all() {
        $sucursals = $this->sucursal->all();

        if (empty($sucursals)) {
            return $this->responses->error("No hay sucursales disponibles", 404);
        }

        return $this->responses->success("Sucursales obtenidas", $sucursals, count($sucursals));
    }

    public function delete($id) {
        if (!$this->sucursal->byId($id)) {
            return $this->responses->error("La sucursal no existe", 404);
        }

        if ($this->sucursal->delete($id)) {
            return $this->responses->success("Sucursal eliminada exitosamente");
        }

        return $this->responses->error("Error al eliminar la sucursal", 500);
    }
}
