<?php

namespace App\Controllers;

use App\Models\Documents;
use App\Core\Controller;
use App\Core\Responses;

class DocumentsController extends Controller {

    protected $documents;
    protected $responses;

    public function __construct() {
        $this->documents = new Documents();
        $this->responses = new Responses();  
    }

    /**
     * Crea un nuevo documents.
     *
     * @param array $request Datos del documents.
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

        if ($this->documents->byCedula($fields['cedula'])) {
            return $this->responses->error("La cedula del documents coincide con otro registro", 409);
        }

        if ($this->documents->create($fields)) {
            return $this->responses->success("documents creado exitosamente");
        }

        return $this->responses->error("Error al crear el documents", 500);
    }

    /**
     * Modifica un documents existente.
     *
     * @param int $id 
     * @param array $request Datos del documents.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->documents->byId($id)) {
            return $this->responses->error("El documents no existe", 404);
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
        
        if ($this->documents->edit($id, $fields)) {
            return $this->responses->success("documents actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el documents", 500);
    }

    /**
     * Consulta un documents por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $documents = $this->documents->getById($id);

        if (!$documents) {
            return $this->responses->error("documents no encontrado", 404);
        }
        return $this->responses->success("documents encontrado", $documents);
    }

    /**
     * Consulta todos los documentss.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all($id) {
        $documents = $this->documents->all($id);

        if (empty($documents)) {
            return $this->responses->error("No hay Documentos disponibles", 404);
        }
        return $this->responses->success("Documentos obtenidos", $documents, count($documents));
    }

    public function allDocType() {
        $documents = $this->documents->allDocType();

        if (empty($documents)) {
            return $this->responses->error("No hay tipos de Documentos disponibles", 404);
        }
        return $this->responses->success("Tipos de documentos obtenidos", $documents, count($documents));
    }


    public function allSenderType() {
        $documents = $this->documents->allSenderType();

        if (empty($documents)) {
            return $this->responses->error("No hay tipos de Remitentes disponibles", 404);
        }
        return $this->responses->success("Tipos de remitentes obtenidos", $documents, count($documents));
    }
    /**
     * Elimina un documents por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->documents->byId($id)) {
            return $this->responses->error("El documents no existe", 404);
        }

        if ($this->documents->delete($id)) {
            return $this->responses->success("documents eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el documents", 500);
    }
}
