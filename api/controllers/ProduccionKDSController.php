<?php

namespace App\Controllers;

use App\Models\ProduccionKDS;
use App\Models\ProduccionCategoria;
use App\Models\ProduccionKDSCategoria;
use App\Core\Controller;
use App\Core\Responses;

class ProduccionKDSController extends Controller {

    protected $kds;
    protected $categoria;
    protected $kds_categoria;
    protected $responses;

    public function __construct() {
        $this->kds = new ProduccionKDS();
        $this->categoria = new ProduccionCategoria();
        $this->kds_categoria = new ProduccionKDSCategoria();
        $this->responses = new Responses();  
    }

    /**
     * Crea una nueva Produccion KDS.
     *
     * @param array $request Datos del Produccion KDS.
     * @return mixed Respuesta de el operación.
     */
    public function create($request) {
        $fields = [
            'codigo' => $request['codigo'] ?? null,            
            'id_sucursal' => $request['id_sucursal'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('codigo', $fields['codigo'], true, 'string', 4, 50);
        $errors[] = $this->validateField('id_sucursal', $fields['id_sucursal'], true, 'int');

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->kds->byNombre($fields['codigo'])) {
            return $this->responses->error("El codigo del kds coincide con otro registro", 409);
        }

        if ($this->kds->create($fields)) {
            return $this->responses->success("KDS de producción creado exitosamente");
        } 

        return $this->responses->error("Error al crear el kds", 500);
    }

    /**
     * Modifica un ProduccionKDS existente.
     *
     * @param int $id 
     * @param array $request Datos del ProduccionKDS.
     * @return mixed Respuesta de el operación.
     */
    public function edit($id, $request) {
        if (!$this->kds->byId($id)) {
            return $this->responses->error("El kds no existe", 404);
        }

        $fields = [
            'codigo' => $request['codigo'] ?? null,            
            'id_sucursal' => $request['id_sucursal'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('codigo', $fields['codigo'], true, 'string', 4, 50);
        $errors[] = $this->validateField('id_sucursal', $fields['id_sucursal'], true, 'int');

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        
        // Filtrar solo los campos que tienen un valor no nulo
        $fields = array_filter($fields, function($value) {
            return $value !== null;
        });
        
        if ($this->kds->edit($id, $fields)) {
            return $this->responses->success("KDS de producción actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el kds", 500);
    }

    /**
     * Consulta un ProduccionKDS por ID.
     *
     * @param int $id
     * @return mixed Respuesta de el operación.
     */
    public function getById($id) {
        $kds = $this->kds->getById($id);

        if (!$kds) {
            return $this->responses->error("KDS de producción  no encontrado", 404);
        }

        return $this->responses->success("KDS de producción  encontrado", $kds);
    }

    /**
     * Consulta todos los ProduccionKDSs.
     *
     * @return mixed Respuesta de el operación.
     */
    public function all() {
        $kds = $this->kds->all();

        if (empty($kds)) {
            return $this->responses->error("No hay kds disponibles", 404);
        }
        
        foreach ($kds as &$kdsItem) {
            $sucursal = $this->kds->sucursal($kdsItem['id']);  // Obtener la sucursal asociada al KDS
            if ($sucursal) {
                $kdsItem['sucursal'] = $sucursal;  // Agregar los datos de la sucursal al KDS
            } else {
                $kdsItem['sucursal'] = null;  // Si no hay sucursal asociada, lo dejamos como null o vacío
            }
        }
        return $this->responses->success("KDS de producción obtenidos", $kds, count($kds));
    }

    /**
     * Elimina un ProduccionKDS por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function delete($id) {
        if (!$this->kds->byId($id)) {
            return $this->responses->error("El kds no existe", 404);
        }

        if ($this->kds->delete($id)) {
            return $this->responses->success("KDS eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el kds", 500);
    }


    /**
     * Asignar categorias al KDS
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function asignarCategorias($request) {
        $id_Kds = $request['id_kds'] ?? null;
        $categorias = $request['categorias'] ?? [];
    
        // Validar que se envíe el id del KDS y al menos una categoría
        if (!$id_Kds || empty($categorias)) {
            return $this->responses->error("Falta el ID del KDS o las categorías", 400);
        }
    
        // Verificar si el KDS existe
        if (!$this->kds->byId($id_Kds)) {
            return $this->responses->error("El KDS no existe", 404);
        }
    
        // Validar que las categorías existan
        foreach ($categorias as $idCategoria) {
            if (!$this->categoria->byId($idCategoria)) {
                return $this->responses->error("La categoría con ID $idCategoria no existe", 404);
            }
        }
    
        // Asignar las categorías al KDS
        if ($this->kds_categoria->asignarCategorias($id_Kds, $categorias)) {
            return $this->responses->success("Categorías asignadas exitosamente al KDS");
        }
        return $this->responses->error("Error al asignar las categorías", 500);
    }

    public function obtenerCategorias($id) {
        // Verificar si el KDS existe
        if (!$this->kds->byId($id)) {
            return $this->responses->error("El KDS no existe", 404);
        }
    
        // Obtener las categorías asociadas al KDS
        $categorias = $this->kds_categoria->obtenerCategoriasPorKDS($id);
    
        if (empty($categorias)) {
            return $this->responses->error("No hay categorías asignadas a este KDS", 404);
        }
    
        return $this->responses->success("Categorías obtenidas", $categorias, count($categorias));
    }
    
    
}
