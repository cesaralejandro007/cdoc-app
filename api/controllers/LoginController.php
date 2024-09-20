<?php

namespace App\Controllers;

use App\Models\Login;
use App\Models\Token;
use App\Core\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Core\Responses;

class LoginController extends Controller {
    
    protected $responses;
    protected $login;
    protected $token;

    public function __construct() {
        $this->responses = new Responses();
        $this->login = new Login();
        $this->token = new Token();
    }

    /**
     * Inicia sesión del usuario.
     */
    public function iniciarSesion($request) {   
        $fields = [
            'cedula' => $request['cedula'] ?? null,
            'clave' => $request['clave'] ?? null
        ];

        $errors = [];
        $errors[] = $this->validateField('Cedula', $fields['cedula'], true, 'string', 6, 8);
        $errors[] = $this->validateField('Clave', $fields['clave'], true, 'string', 3, 25);
    
        $errors = array_filter($errors);
    
        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
    
        if (!$this->login->byId($fields['cedula'])) {
            return $this->responses->error("Usuario no encontrado", 404);
        }
        
        $datos_user = $this->login->iniciarSesion($request);

        if (!$datos_user) {
            return $this->responses->error("Por favor, verifique sus credenciales", 401);
        }
        return $this->responses->success("Inicio de sesión exitoso",$datos_user);
    }

    /**
     * Esta función verifica el token para determinar si el cierre de sesión fue exitoso o si hubo un error en el proceso.
     */
    public function cerrarSesion() {
        $headers = getallheaders();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';    
        if ($this->token->byToken($authHeader)) {
            $this->token->deleteToken($authHeader);
            return $this->responses->success("Cierre de sesión exitoso.");
        }
        return $this->responses->error("Error de Cierre de sesion", 500);
    }

}
