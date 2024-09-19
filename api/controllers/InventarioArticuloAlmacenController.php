<?php

namespace App\Controllers;

use App\Models\InventarioArticuloAlmacen;
use App\Core\Controller;
use App\Core\Responses;

class InventarioArticuloAlmacenController extends Controller {

    protected $articulo;
    protected $responses;

    public function __construct() {
        $this->articulo = new InventarioArticuloAlmacen();
        $this->responses = new Responses();  
    }

    /**
     * Crea nuevo registro
     *
     * @param array $request Datos
     * @return mixed Respuesta de la operación.
     */
    public function create($request) {
        $fields = [
            'empresa' => $request['empresa'] ?? null,            
            'codigo_prod' => $request['codigo_prod'] ?? null,
            'almacen' => $request['almacen'] ?? null,
            'cantidad' => $request['cantidad'] ?? null,
            'tipo' => $request['tipo'] ?? null,
            'referencia' => $request['referencia'] ?? null
        ];          

        $errors = [];
        $errors[] = $this->validateField('empresa', $fields['empresa'], true, 'int');
        $errors[] = $this->validateField('codigo_prod', $fields['codigo_prod'], true, 'string', 4, 100);
        $errors[] = $this->validateField('almacen', $fields['almacen'], true, 'int');
        $errors[] = $this->validateField('cantidad', $fields['cantidad'], true, 'int');
        $errors[] = $this->validateField('tipo', $fields['tipo'], true, 'int'); //1:ENTRADA 2:SALIDA 3:DEVOLUCION
        $errors[] = $this->validateField('referencia', $fields['referencia'], true, 'int');
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->articulo->byNombre($fields['codigo_prod'])) {
            return $this->responses->error("El codigo del articulo coincide con otro registro", 409);
        }

        if ($this->articulo->create($fields)) {
            return $this->responses->success("Articulo creado exitosamente");
        }

        return $this->responses->error("Error al crear el articulo", 500);
    }

    /**
     * Modifica un InventarioArticuloAlmacen existente.
     *
     * @param int $id 
     * @param array $request Datos del InventarioArticuloAlmacen.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->articulo->byId($id)) {
            return $this->responses->error("El articulo no existe", 404);
        }

        $fields = [
            'empresa' => $request['empresa'] ?? null,            
            'codigo_prod' => $request['codigo_prod'] ?? null,
            'almacen' => $request['almacen'] ?? null,
            'cantidad' => $request['cantidad'] ?? null,
            'tipo' => $request['tipo'] ?? null,
            'referencia' => $request['referencia'] ?? null
        ];          

        $errors = [];
        $errors[] = $this->validateField('empresa', $fields['empresa'], true, 'int');
        $errors[] = $this->validateField('codigo_prod', $fields['codigo_prod'], true, 'string', 4, 100);
        $errors[] = $this->validateField('almacen', $fields['almacen'], true, 'int');
        $errors[] = $this->validateField('cantidad', $fields['cantidad'], true, 'int');
        $errors[] = $this->validateField('tipo', $fields['tipo'], true, 'int'); //1:ENTRADA 2:SALIDA 3:DEVOLUCION
        $errors[] = $this->validateField('referencia', $fields['referencia'], true, 'int');
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        
        // Filtrar solo los campos que tienen un valor no nulo
        $fields = array_filter($fields, function($value) {
            return $value !== null;
        });
        
        if ($this->articulo->edit($id, $fields)) {
            return $this->responses->success("Articulo actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el articulo", 500);
    }

    /**
     * Consulta un InventarioArticuloAlmacen por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $articulo = $this->articulo->getById($id);

        if (!$articulo) {
            return $this->responses->error("Articulo  no encontrado", 404);
        }

        return $this->responses->success("Articulo  encontrado", $articulo);
    }

    /**
     * Consulta todos los InventarioArticuloAlmacens.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all() {
        $articuloes = $this->articulo->all();

        if (empty($articuloes)) {
            return $this->responses->error("No hay articuloes disponibles", 404);
        }

        return $this->responses->success("Articulo obtenidos", $articuloes, count($articuloes));
    }

    /**
     * Elimina un InventarioArticuloAlmacen por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->articulo->byId($id)) {
            return $this->responses->error("El articulo no existe", 404);
        }

        if ($this->articulo->delete($id)) {
            return $this->responses->success("Articulo eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el articulo", 500);
    }

    /**
     * Suma una cantidad al stock del articulo.
     *
     * @param int $id ID del articulo.
     * @param array $request Datos de la cantidad a sumar.
     * @return mixed Respuesta de la operación.
     */
    public function increaseStock($id, $request) {
        // Verifica si el articulo existe
        if (!$this->articulo->byId($id)) {
            return $this->responses->error("El articulo no existe", 404);
        }

        // Verifica que la cantidad sea válida
        $cantidad = $request['cantidad'] ?? null;
        $error = $this->validateField('cantidad', $cantidad, true, 'float', 1, 20);

        if ($error) {
            return $this->responses->error($error, 400);
        }

        // Suma la cantidad al stock actual
        if ($this->articulo->actualizarStock($id, $cantidad, '+')) {
            return $this->responses->success("El stock fue actualizado correctamente");
        }

        return $this->responses->error("Error al actualizar el stock", 500);
    }

    /**
     * Resta una cantidad al stock del articulo.
     *
     * @param int $id ID del articulo.
     * @param array $request Datos de la cantidad a restar.
     * @return mixed Respuesta de la operación.
     */
    public function decreaseStock($id, $request) {
        // Verifica si el articulo existe
        if (!$this->articulo->byId($id)) {
            return $this->responses->error("El articulo no existe", 404);
        }

        // Verifica que la cantidad sea válida
        $cantidad = $request['cantidad'] ?? null;
        $error = $this->validateField('cantidad', $cantidad, true, 'float', 1, 20);

        if ($error) {
            return $this->responses->error($error, 400);
        }

        // Suma la cantidad al stock actual
        if ($this->articulo->actualizarStock($id, $cantidad, '-')) {
            return $this->responses->success("El stock fue actualizado correctamente");
        }

        return $this->responses->error("Error al actualizar el stock", 500);
    }
}
