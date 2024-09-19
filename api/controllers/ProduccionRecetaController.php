<?php

namespace App\Controllers;

use App\Models\ProduccionReceta;
use App\Models\ProduccionCategoria;
use App\Models\ProduccionMaterial;
use App\Models\ProduccionRecetaCategoria;
use App\Models\ProduccionRecetaMaterial;
use App\Models\ProduccionRecetaIngrediente;
use App\Models\InventarioArticuloAlmacen;
use App\Models\InventarioMedida;
use App\Core\Controller;
use App\Core\Responses;

class ProduccionRecetaController extends Controller {

    protected $receta;
    protected $categoria;
    protected $material;
    protected $receta_categoria;
    protected $receta_material;
    protected $receta_ingrediente;
    protected $ingrediente;
    protected $medida;
    protected $responses;

    public function __construct() {
        $this->receta = new ProduccionReceta();
        $this->categoria = new ProduccionCategoria();
        $this->material = new ProduccionMaterial();
        $this->receta_categoria = new ProduccionRecetaCategoria();
        $this->receta_material = new ProduccionRecetaMaterial();
        $this->receta_ingrediente = new ProduccionRecetaIngrediente();
        $this->ingrediente = new InventarioArticuloAlmacen();
        $this->medida = new InventarioMedida();
        $this->responses = new Responses();  
    }

    /**
     * Crea una nueva Produccion Receta.
     *
     * @param array $request Datos de la Produccion Receta.
     * @return mixed Respuesta de la operación.
     */
    public function create($request) {
        $fields = [
            'principal' => $request['principal'] ?? null,
            'nombre' => $request['nombre'] ?? null,
            'codigo' => $request['codigo'] ?? null,            
            'dosis' => $request['dosis'] ?? null,
            'costo_dosis' => $request['costo_dosis'] ?? null,
            'cant_dosis_empaque' => $request['cant_dosis_empaque'] ?? null,
            'porcentaje_foodcost' => $request['porcentaje_foodcost'] ?? null,
            'preparacion' => $request['preparacion'] ?? null,
            'proceso_empaque' => $request['proceso_empaque'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('codigo', $fields['codigo'], true, 'string', 5, 50);
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 200);
        $errors[] = $this->validateField('principal', $fields['principal'], true, 'int');
        $errors[] = $this->validateField('dosis', $fields['dosis'], true, 'float', 1, 20);
        $errors[] = $this->validateField('costo_dosis', $fields['costo_dosis'], true, 'float', 1, 20);
        $errors[] = $this->validateField('cant_dosis_empaque', $fields['cant_dosis_empaque'], true, 'float', 1, 20);
        $errors[] = $this->validateField('porcentaje_foodcost', $fields['porcentaje_foodcost'], true, 'float', 1, 20);
        $errors[] = $this->validateField('preparacion', $fields['preparacion'], true, 'string', 1, 200);
        $errors[] = $this->validateField('proceso_empaque', $fields['proceso_empaque'], true, 'string', 1, 200);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->receta->byNombre($fields['nombre'])) {
            return $this->responses->error("La nombre de la receta coincide con otro registro", 409);
        }

        if ($this->receta->create($fields)) {
            return $this->responses->success("Receta creada exitosamente");
        } 

        return $this->responses->error("Error al crear la receta", 500);
    }

    /**
     * Modifica un ProduccionReceta existente.
     *
     * @param int $id 
     * @param array $request Datos de la ProduccionReceta.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->receta->byId($id)) {
            return $this->responses->error("La receta no existe", 404);
        }

        $fields = [
            'codigo' => $request['codigo'] ?? null,            
            'nombre' => $request['nombre'] ?? null,
            'principal' => $request['principal'] ?? null,
            'dosis' => $request['dosis'] ?? null,
            'costo_dosis' => $request['costo_dosis'] ?? null,
            'cant_dosis_empaque' => $request['cant_dosis_empaque'] ?? null,
            'porcentaje_foodcost' => $request['porcentaje_foodcost'] ?? null,
            'preparacion' => $request['preparacion'] ?? null,
            'proceso_empaque' => $request['proceso_empaque'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('codigo', $fields['codigo'], true, 'string', 5, 50);
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 4, 200);
        $errors[] = $this->validateField('principal', $fields['principal'], true, 'int');
        $errors[] = $this->validateField('dosis', $fields['dosis'], true, 'float', 1, 20);
        $errors[] = $this->validateField('costo_dosis', $fields['costo_dosis'], true, 'float', 1, 20);
        $errors[] = $this->validateField('cant_dosis_empaque', $fields['cant_dosis_empaque'], true, 'float', 1, 20);
        $errors[] = $this->validateField('porcentaje_foodcost', $fields['porcentaje_foodcost'], true, 'float', 1, 20);
        $errors[] = $this->validateField('preparacion', $fields['preparacion'], true, 'string', 1, 200);
        $errors[] = $this->validateField('proceso_empaque', $fields['proceso_empaque'], true, 'string', 1, 200);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        
        // Filtrar solo los campos que tienen un valor no nulo
        $fields = array_filter($fields, function($value) {
            return $value !== null;
        });
        
        if ($this->receta->edit($id, $fields)) {
            return $this->responses->success("Receta actualizada exitosamente");
        }

        return $this->responses->error("Error al actualizar la receta", 500);
    }

    /**
     * Consulta un ProduccionReceta por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $receta = $this->receta->getById($id);

        if (!$receta) {
            return $this->responses->error("Receta  no encontrada", 404);
        }

        return $this->responses->success("Receta  encontrada", $receta);
    }

    /**
     * Consulta todos los ProduccionRecetas.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all() {
        $recetaes = $this->receta->all();

        if (empty($recetaes)) {
            return $this->responses->error("No hay recetaes disponibles", 404);
        }

        return $this->responses->success("Recetas obtenidas", $recetaes, count($recetaes));
    }

    /**
     * Elimina un ProduccionReceta por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->receta->byId($id)) {
            return $this->responses->error("La receta no existe", 404);
        }

        if ($this->receta->delete($id)) {
            return $this->responses->success("Receta eliminada exitosamente");
        }

        return $this->responses->error("Error al eliminar la receta", 500);
    }

    /**
     * Asignar categorias al recetas
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function asignarCategorias($request) {
        $id_Kds = $request['id_receta'] ?? null;
        $categorias = $request['categorias'] ?? [];
    
        // Validar que se envíe el id de la recetas y al menos una categoría
        if (!$id_Kds || empty($categorias)) {
            return $this->responses->error("Falta el ID de la recetas o las categorías", 400);
        }
    
        // Verificar si la recetas existe
        if (!$this->receta->byId($id_Kds)) {
            return $this->responses->error("La recetas no existe", 404);
        }
    
        // Validar que las categorías existan
        foreach ($categorias as $idCategoria) {
            if (!$this->categoria->byId($idCategoria)) {
                return $this->responses->error("La categoría con ID $idCategoria no existe", 404);
            }
        }
    
        // Asignar las categorías al recetas
        if ($this->receta_categoria->asignarCategorias($id_Kds, $categorias)) {
            return $this->responses->success("Categorías asignadas exitosamente al recetas");
        }
        return $this->responses->error("Error al asignar las categorías", 500);
    }

    public function obtenerCategorias($id) {
        // Verificar si la recetas existe
        if (!$this->receta->byId($id)) {
            return $this->responses->error("La recetas no existe", 404);
        }
    
        // Obtener las categorías asociadas al recetas
        $categorias = $this->receta_categoria->obtenerCategoriasPorReceta($id);
    
        if (empty($categorias)) {
            return $this->responses->error("No hay categorías asignadas a este recetas", 404);
        }
    
        return $this->responses->success("Categorías obtenidas", $categorias, count($categorias));
    }


    /**
     * Asignar materiales de producción una receta
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function asignarMateriales($request) {
        $id_receta = $request['id_receta'] ?? null;
        $materiales = $request['materiales'] ?? [];
    
        // Validar que se envíe el id de la recetas y al menos un material
        if (!$id_receta || empty($materiales)) {
            return $this->responses->error("Falta el ID de la recetas o los materiales", 400);
        }
    
        // Verificar si la recetas existe
        if (!$this->receta->byId($id_receta)) {
            return $this->responses->error("La recetas no existe", 404);
        }
    
        // Validar que las materiales existan
        foreach ($materiales as $idMaterial) {
            if (!$this->material->byId($idMaterial)) {
                return $this->responses->error("El material con ID $idMaterial no existe", 404);
            }
        }
    
        // Asignar las materiales al recetas
        if ($this->receta_material->asignarMateriales($id_receta, $materiales)) {
            return $this->responses->success("Materiales asignados exitosamente al recetas");
        }
        return $this->responses->error("Error al asignar los materiales", 500);
    }

    /**
     * Mostrar todos los materiales con respecto a una receta
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function obtenerMateriales($id) {
        // Verificar si la recetas existe
        if (!$this->receta->byId($id)) {
            return $this->responses->error("La receta no existe", 404);
        }
        // Obtener las materiales asociadas al recetas
        $materiales = $this->receta_material->obtenerMaterialesPorReceta($id);
    
        if (empty($materiales)) {
            return $this->responses->error("No hay materiales asignadas a este recetas", 404);
        }
        return $this->responses->success("Materiales obtenidos", $materiales, count($materiales));
    }

    
    /**
     * Asignar ingredientes a una receta
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function asignarIngredientes($request) {
        $id_receta = $request['id_receta'] ?? null;
        $ingredientes = $request['ingredientes'] ?? [];
    
        // Validar que se recibió el id de la receta y el array de ingredientes
        if (!$id_receta || empty($ingredientes)) {
            return $this->responses->error("Debe proporcionar el ID de la receta y los ingredientes", 400);
        }
    
        // Validar ingredientes y medidas
        foreach ($ingredientes as $ingrediente) {
            // Validar si el ingrediente existe
            if (!$this->ingrediente->byId($ingrediente['id_ingrediente'])) {
                return $this->responses->error("El ingrediente con ID {$ingrediente['id_ingrediente']} no existe", 404);
            }
    
            // Validar si la medida existe
            if (!$this->medida->byId($ingrediente['id_medida'])) {
                return $this->responses->error("La medida con ID {$ingrediente['id_medida']} no existe", 404);
            }
        }
    
        // Llamar al modelo para asignar los ingredientes
        if ($this->receta_ingrediente->asignarIngredientes($id_receta, $ingredientes)) {
            return $this->responses->success("Ingredientes asignados correctamente a la receta");
        }
    
        return $this->responses->error("Error al asignar los ingredientes a la receta", 500);
    }

    /**
     * Mostrar todos los ingredientes con respecto a una receta
     *
     * @param int $id 
     * @return mixed Respuesta de el operación.
     */
    public function obtenerIngredientesPorReceta($id) {
        // Verificar si la recetas existe
        if (!$this->receta->byId($id)) {
            return $this->responses->error("La receta no existe", 404);
        }
        // Obtener las ingredientes asociadas al recetas
        $ingredientes = $this->receta_ingrediente->obtenerIngredientesPorReceta($id);
    
        if (empty($ingredientes)) {
            return $this->responses->error("No hay ingredientes asignados a esta recetas", 404);
        }
        return $this->responses->success("Ingredientes obtenidos", $ingredientes, count($ingredientes));
    }
    
}
