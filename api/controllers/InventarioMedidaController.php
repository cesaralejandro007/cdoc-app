<?php

namespace App\Controllers;

use App\Models\InventarioMedida;
use App\Core\Controller;
use App\Core\Responses;

class InventarioMedidaController extends Controller {

    protected $medida;
    protected $responses;

    public function __construct() {
        $this->medida = new InventarioMedida();
        $this->responses = new Responses();  
    }

    /**
     * Crea una nueva Produccion Material.
     *
     * @param array $request Datos del Produccion Material.
     * @return mixed Respuesta de la operación.
     */
    public function create($request) {
        $fields = [       
            'nombre' => $request['nombre'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 100);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->medida->byNombre($fields['nombre'])) {
            return $this->responses->error("El nombre de la medida coincide con otro registro", 409);
        }

        if ($this->medida->create($fields)) {
            return $this->responses->success("Medida creada exitosamente");
        }

        return $this->responses->error("Error al crear la medida", 500);
    }

    /**
     * Modifica un InventarioMedida existente.
     *
     * @param int $id 
     * @param array $request Datos del InventarioMedida.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->medida->byId($id)) {
            return $this->responses->error("La medida no existe", 404);
        }

        $fields = [        
            'nombre' => $request['nombre'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 100);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        
        // Filtrar solo los campos que tienen un valor no nulo
        $fields = array_filter($fields, function($value) {
            return $value !== null;
        });
        
        if ($this->medida->edit($id, $fields)) {
            return $this->responses->success("Medida actualizada exitosamente");
        }

        return $this->responses->error("Error al actualizar la medida", 500);
    }

    /**
     * Consulta un InventarioMedida por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $medida = $this->medida->getById($id);

        if (!$medida) {
            return $this->responses->error("Medida  no encontrada", 404);
        }

        return $this->responses->success("Medida  encontrada", $medida);
    }

    /**
     * Consulta todos los InventarioMedidas.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all() {
        $medidas = $this->medida->all();

        if (empty($medidas)) {
            return $this->responses->error("No hay medidas disponibles", 404);
        }

        return $this->responses->success("Medida obtenidas", $medidas, count($medidas));
    }

    /**
     * Elimina un InventarioMedida por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->medida->byId($id)) {
            return $this->responses->error("El medida no existe", 404);
        }

        if ($this->medida->delete($id)) {
            return $this->responses->success("Medida eliminada exitosamente");
        }

        return $this->responses->error("Error al eliminar la medida", 500);
    }
}
