<?php

namespace App\Controllers;

use App\Models\DocumentsEntry;
use App\Core\Controller;
use App\Core\Responses;

class DocumentsEntryController extends Controller {

    protected $documents_entry;
    protected $responses;

    public function __construct() {
        $this->documents_entry = new DocumentsEntry();
        $this->responses = new Responses();  
    }

    /**
     * Crea un nuevo documents_entry.
     *
     * @param array $request Datos del documents_entry.
     * @return mixed Respuesta de la operación.
     */
    public function create($request) {
        $fields = [
            'empresa' => $request['empresa'] ?? null,
            'tienda' => $request['tienda'] ?? null,
            'codigo' => $request['codigo'] ?? null,
            'nick' => $request['nick'] ?? null,
            'clave' => $request['clave'] ?? null,
            'nombre' => $request['nombre'] ?? null,
            'apellido' => $request['apellido'] ?? null,
            'email' => $request['email'] ?? null,
            'rol' => $request['rol'] ?? null,
            'imagen' => $request['imagen'] ?? null,
            'secure' => $request['secure'] ?? null,
            'documento' => $request['documento'] ?? null,
            'cedula' => $request['cedula'] ?? null,
            'status' => $request['status'] ?? null,
            'key_change_counter' => $request['key_change_counter'] ?? null,
            'failed_attempts' => $request['failed_attempts'] ?? null,
            'last_login' => $request['last_login'] ?? null,
            'last_ip' => $request['last_ip'] ?? null,
            'is_admin' => $request['is_admin'] ?? null,
            'editarPrecios' => $request['editarPrecios'] ?? null,
            'editarTwoFactory' => $request['editarTwoFactory'] ?? null,
            'google_auth_code' => $request['google_auth_code'] ?? null,
            'active_google_auth' => $request['active_google_auth'] ?? null,
            'telefono' => $request['telefono'] ?? null,
            'gravatar' => $request['gravatar'] ?? null,
            'pin' => $request['pin'] ?? null,
            'is_pin' => $request['is_pin'] ?? null,
        ];

        $errors = [];
        $errors[] = $this->validateField('cedula', $fields['cedula'], true, 'string', 1, 15);
        $errors[] = $this->validateField('nombre', $fields['nombre'], true, 'string', 8, 260);
        $errors[] = $this->validateField('clave', $fields['clave'], false, 'string', 8, 260);
        $errors[] = $this->validateField('email', $fields['email'], true, 'email', 0, 160);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if ($this->documents_entry->byCedula($fields['cedula'])) {
            return $this->responses->error("La cedula del documents_entry coincide con otro registro", 409);
        }

        if ($this->documents_entry->create($fields)) {
            return $this->responses->success("documents_entry creado exitosamente");
        }

        return $this->responses->error("Error al crear el documents_entry", 500);
    }

    /**
     * Modifica un documents_entry existente.
     *
     * @param int $id 
     * @param array $request Datos del documents_entry.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->documents_entry->byId($id)) {
            return $this->responses->error("El documents_entry no existe", 404);
        }

        $fields = [
            'empresa' => $request['empresa'] ?? null,
            'tienda' => $request['tienda'] ?? null,
            'codigo' => $request['codigo'] ?? null,
            'nick' => $request['nick'] ?? null,
            'clave' => $request['clave'] ?? null,
            'nombre' => $request['nombre'] ?? null,
            'apellido' => $request['apellido'] ?? null,
            'email' => $request['email'] ?? null,
            'rol' => $request['rol'] ?? null,
            'imagen' => $request['imagen'] ?? null,
            'secure' => $request['secure'] ?? null,
            'documento' => $request['documento'] ?? null,
            'cedula' => $request['cedula'] ?? null,
            'status' => $request['status'] ?? null,
            'key_change_counter' => $request['key_change_counter'] ?? null,
            'failed_attempts' => $request['failed_attempts'] ?? null,
            'last_login' => $request['last_login'] ?? null,
            'last_ip' => $request['last_ip'] ?? null,
            'is_admin' => $request['is_admin'] ?? null,
            'editarPrecios' => $request['editarPrecios'] ?? null,
            'editarTwoFactory' => $request['editarTwoFactory'] ?? null,
            'google_auth_code' => $request['google_auth_code'] ?? null,
            'active_google_auth' => $request['active_google_auth'] ?? null,
            'telefono' => $request['telefono'] ?? null,
            'gravatar' => $request['gravatar'] ?? null,
            'pin' => $request['pin'] ?? null,
            'is_pin' => $request['is_pin'] ?? null,
        ];

        $errors = [];
        $errors[] = $this->validateField('cedula', $fields['cedula'], false, 'string', 1, 15);
        $errors[] = $this->validateField('nombre', $fields['nombre'], false, 'string', 8, 260);
        $errors[] = $this->validateField('clave', $fields['clave'], false, 'string', 8, 260);
        $errors[] = $this->validateField('email', $fields['email'], false, 'email', 0, 160);
        // Agrega más validaciones según sea necesario

        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        
        // Filtrar solo los campos que tienen un valor no nulo
        $fields = array_filter($fields, function($value) {
            return $value !== null;
        });
        
        if ($this->documents_entry->edit($id, $fields)) {
            return $this->responses->success("documents_entry actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el documents_entry", 500);
    }

    /**
     * Consulta un documents_entry por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $documents_entry = $this->documents_entry->getById($id);

        if (!$documents_entry) {
            return $this->responses->error("documents_entry no encontrado", 404);
        }
        return $this->responses->success("documents_entry encontrado", $documents_entry);
    }

    /**
     * Consulta todos los documents_entrys.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all() {
        $documents_entrys = $this->documents_entry->all();

        if (empty($documents_entrys)) {
            return $this->responses->error("No hay Documentos disponibles", 404);
        }
        return $this->responses->success("Documentos obtenidos", $documents_entrys, count($documents_entrys));
    }

    /**
     * Elimina un documents_entry por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->documents_entry->byId($id)) {
            return $this->responses->error("El documents_entry no existe", 404);
        }

        if ($this->documents_entry->delete($id)) {
            return $this->responses->success("documents_entry eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el documents_entry", 500);
    }
}
