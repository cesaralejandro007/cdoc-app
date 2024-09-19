<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Core\Controller;
use App\Core\Responses;

class UsuarioController extends Controller {

    protected $usuario;
    protected $responses;

    public function __construct() {
        $this->usuario = new Usuario();
        $this->responses = new Responses();  
    }

    /**
     * Crea un nuevo Usuario.
     *
     * @param array $request Datos del Usuario.
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

        if ($this->usuario->byCedula($fields['cedula'])) {
            return $this->responses->error("La cedula del usuario coincide con otro registro", 409);
        }

        if ($this->usuario->create($fields)) {
            return $this->responses->success("Usuario creado exitosamente");
        }

        return $this->responses->error("Error al crear el usuario", 500);
    }

    /**
     * Modifica un Usuario existente.
     *
     * @param int $id 
     * @param array $request Datos del Usuario.
     * @return mixed Respuesta de la operación.
     */
    public function edit($id, $request) {
        if (!$this->usuario->byId($id)) {
            return $this->responses->error("El usuario no existe", 404);
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
        
        if ($this->usuario->edit($id, $fields)) {
            return $this->responses->success("Usuario actualizado exitosamente");
        }

        return $this->responses->error("Error al actualizar el usuario", 500);
    }

    /**
     * Consulta un Usuario por ID.
     *
     * @param int $id
     * @return mixed Respuesta de la operación.
     */
    public function getById($id) {
        $usuario = $this->usuario->getById($id);

        if (!$usuario) {
            return $this->responses->error("Usuario no encontrado", 404);
        }

        return $this->responses->success("Usuario encontrado", $usuario);
    }

    /**
     * Consulta todos los Usuarios.
     *
     * @return mixed Respuesta de la operación.
     */
    public function all() {
        $usuarios = $this->usuario->all();

        if (empty($usuarios)) {
            return $this->responses->error("No hay usuarios disponibles", 404);
        }

        return $this->responses->success("Usuarios obtenidos", $usuarios, count($usuarios));
    }

    /**
     * Elimina un Usuario por ID.
     *
     * @param int $id 
     * @return mixed Respuesta de la operación.
     */
    public function delete($id) {
        if (!$this->usuario->byId($id)) {
            return $this->responses->error("El usuario no existe", 404);
        }

        if ($this->usuario->delete($id)) {
            return $this->responses->success("Usuario eliminado exitosamente");
        }

        return $this->responses->error("Error al eliminar el usuario", 500);
    }
}
