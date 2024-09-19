<?php

namespace App\Controllers;

use App\Models\ProduccionMaterial;
use App\Core\Controller;
use App\Core\Responses;

class ProduccionMaterialController extends Controller {

    protected $material;
    protected $responses;

    public function __construct() {
        $this->material = new ProduccionMaterial();
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
            'codigo' => $request['codigo'] ?? null,            
            'nombre' => $request['nombre'] ?? null,
            'precio' => $request['precio'] ?? null,
            'stock' => $request['stock'] ?? null,
            'stock_minimo' => $request['stock_minimo'] ?? null,
            'stock_maximo' => $request['stock_maximo'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('codigo', $fields['codigo'], true, 'string', 1, 50);
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 100);
        $errors[] = $this->validateField('precio', $fields['precio'], true, 'float', 1, 20);
        $errors[] = $this->validateField('stock', $fields['stock'], true, 'float', 1, 20);
        $errors[] = $this->validateField('stock_minimo', $fields['stock_minimo'], true, 'float', 1, 20);
        $errors[] = $this->validateField('stock_maximo', $fields['stock_maximo'], true, 'float', 1, 20);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->material->byNombre($fields['nombre'])) {
            return $this->responses->error("El nombre del material coincide con otro registro", 409);
        }

        if ($this->material->create($fields)) {
            return $this->responses->success("Material de producción creado exitosamente");
        }

        return $this->responses->error("Error al crear el material", 500);
    }

    /**
     * Modifica un ProduccionMaterial existente.
     *
     * @param int $id 
     * @param array $request Datos del ProduccionMaterial.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->material->byId($id)) {
            return $this->responses->error("El material no existe", 404);
        }

        $fields = [
            'codigo' => $request['codigo'] ?? null,            
            'nombre' => $request['nombre'] ?? null,
            'precio' => $request['precio'] ?? null,
            'stock' => $request['stock'] ?? null,
            'stock_minimo' => $request['stock_minimo'] ?? null,
            'stock_maximo' => $request['stock_maximo'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('codigo', $fields['codigo'], false, 'string', 1, 50);
        $errors[] = $this->validateField('nombre', $fields['nombre'], false, 'string', 4, 100);
        $errors[] = $this->validateField('precio', $fields['precio'], false, 'float', 1, 20);
        $errors[] = $this->validateField('stock', $fields['stock'], false, 'float', 1, 20);
        $errors[] = $this->validateField('stock_minimo', $fields['stock_minimo'], false, 'float', 1, 20);
        $errors[] = $this->validateField('stock_maximo', $fields['stock_maximo'], false, 'float', 1, 20);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        
        // Filtrar solo los campos que tienen un valor no nulo
        $fields = array_filter($fields, function($value) {
            return $value !== null;
        });
        
        if ($this->material->edit($id, $fields)) {
            return $this->responses->success("Material de producción actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el material", 500);
    }

    /**
     * Consulta un ProduccionMaterial por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $material = $this->material->getById($id);

        if (!$material) {
            return $this->responses->error("Material de producción  no encontrado", 404);
        }

        return $this->responses->success("Material de producción  encontrado", $material);
    }

    /**
     * Consulta todos los ProduccionMaterials.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all() {
        $materiales = $this->material->all();

        if (empty($materiales)) {
            return $this->responses->error("No hay materiales disponibles", 404);
        }

        return $this->responses->success("Material de producción obtenidos", $materiales, count($materiales));
    }

    /**
     * Elimina un ProduccionMaterial por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->material->byId($id)) {
            return $this->responses->error("El material no existe", 404);
        }

        if ($this->material->delete($id)) {
            return $this->responses->success("Material eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el material", 500);
    }

    /**
     * Suma una cantidad al stock del material.
     *
     * @param int $id ID del material.
     * @param array $request Datos de la cantidad a sumar.
     * @return mixed Respuesta de la operación.
     */
    public function increaseStock($id, $request) {
        // Verifica si el material existe
        if (!$this->material->byId($id)) {
            return $this->responses->error("El material no existe", 404);
        }

        // Verifica que la cantidad sea válida
        $cantidad = $request['cantidad'] ?? null;
        $error = $this->validateField('cantidad', $cantidad, true, 'float', 1, 20);

        if ($error) {
            return $this->responses->error($error, 400);
        }

        // Suma la cantidad al stock actual
        if ($this->material->actualizarStock($id, $cantidad, '+')) {
            return $this->responses->success("El stock fue actualizado correctamente");
        }

        return $this->responses->error("Error al actualizar el stock", 500);
    }

    /**
     * Resta una cantidad al stock del material.
     *
     * @param int $id ID del material.
     * @param array $request Datos de la cantidad a restar.
     * @return mixed Respuesta de la operación.
     */
    public function decreaseStock($id, $request) {
        // Verifica si el material existe
        if (!$this->material->byId($id)) {
            return $this->responses->error("El material no existe", 404);
        }

        // Verifica que la cantidad sea válida
        $cantidad = $request['cantidad'] ?? null;
        $error = $this->validateField('cantidad', $cantidad, true, 'float', 1, 20);

        if ($error) {
            return $this->responses->error($error, 400);
        }

        // Suma la cantidad al stock actual
        if ($this->material->actualizarStock($id, $cantidad, '-')) {
            return $this->responses->success("El stock fue actualizado correctamente");
        }

        return $this->responses->error("Error al actualizar el stock", 500);
    }
}
