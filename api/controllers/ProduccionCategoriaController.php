<?php

namespace App\Controllers;

use App\Models\ProduccionCategoria;
use App\Core\Controller;
use App\Core\Responses;

class ProduccionCategoriaController extends Controller {

    protected $categoria;
    protected $responses;

    public function __construct() {
        $this->categoria = new ProduccionCategoria();
        $this->responses = new Responses();  
    }

    public function create($request) {
        $fields = [
            'nombre' => $request['nombre'] ?? null,
        ];

        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 100);

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->categoria->byName($fields['nombre'])) {
            return $this->responses->error("La categoría ya existe", 409);
        }

        if ($this->categoria->create($fields['nombre'])) {
            return $this->responses->success("Categoría creada exitosamente");
        }

        return $this->responses->error("Error al crear la categoría", 500);
    }

    public function edit($id, $request) {
        if (!$this->categoria->byId($id)) {
            return $this->responses->error("La categoría no existe", 404);
        }

        $fields = [
            'nombre' => $request['nombre'] ?? null,
        ];

        $errors = [];
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 100);

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->categoria->edit($id, ['nombre' => $fields['nombre']])) {
            return $this->responses->success("Categoría actualizada exitosamente");
        }

        return $this->responses->error("Error al actualizar la categoría", 500);
    }

    public function getById($id) {
        $categoria = $this->categoria->getById($id);

        if (!$categoria) {
            return $this->responses->error("Categoría no encontrada", 404);
        }

        return $this->responses->success("Categoría encontrada", $categoria);
    }

    public function all() {
        $categorias = $this->categoria->all();

        if (empty($categorias)) {
            return $this->responses->error("No hay categorías disponibles", 404);
        }

        return $this->responses->success("Categorías obtenidas", $categorias, count($categorias));
    }

    public function delete($id) {
        if (!$this->categoria->byId($id)) {
            return $this->responses->error("La categoría no existe", 404);
        }

        if ($this->categoria->delete($id)) {
            return $this->responses->success("Categoría eliminada exitosamente");
        }

        return $this->responses->error("Error al eliminar la categoría", 500);
    }
}
