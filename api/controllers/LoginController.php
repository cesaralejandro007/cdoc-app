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
            return $this->responses->error($fields['cedula'], 409);
        }
        
        $datos_user = $this->login->iniciarSesion($request);

        if (!$datos_user) {
            return $this->responses->error("Verifique sus datos", 401);
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
    /**
     * Envía un correo para recuperar la contraseña.
     *
     * Esta función recibe el email del usuario, verifica si está registrado,
     * genera un token de recuperación y envía un correo con un enlace para restablecer la contraseña.
     */
    public function verificarEmail($request) {   
        $fields = [
            'email' => $request['email'] ?? null,
        ];

        $errors = [];
        $errors[] = $this->validateField('email', $fields['email'], true, 'string', 3, 50);
        $errors = array_filter($errors);
    
        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
    
        if (!$this->login->byId($fields['email'])) {
            return $this->responses->error("El usuario no existe", 409);
        }

        date_default_timezone_set('America/Caracas'); 
        $token = bin2hex(random_bytes(16));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->login->guardarToken($fields['email'], $token, $expiracion);

        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cvides@nerdcom.do';
            $mail->Password = 'Usuariov.37';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('cvides@nerdcom.do', 'Cesar Vides');
            $mail->addAddress($fields['email']);
            
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='https://tu-dominio.com/restablecer-contraseña?token=$token'>Restablecer Contraseña</a>";
            
            $mail->send();
            return $this->responses->success("Correo de recuperación enviado");
        } catch (Exception $e) {
            echo json_encode(['message' => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
            http_response_code(500);
        }
    }

    /**
     * Restablece la contraseña del usuario.
     *
     * Esta función recibe un token y una nueva contraseña, verifica si el token es válido,
     * y actualiza la contraseña del usuario si el token es válido.
     */
    public function restablecerContrasena($request) {
        $fields = [
            'token' => $request['token'] ?? null,
            'nueva_contrasena' => $request['nueva_contrasena'] ?? null,
        ];
        $errors = [];
        $errors[] = $this->validateField('token', $fields['token'], true, 'string', 30, 100);
        $errors[] = $this->validateField('nueva_contraseña', $fields['nueva_contrasena'], true, 'string', 3, 30);
        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }

        if (!$this->login->restablecerContrasena($fields['token'], $fields['nueva_contrasena'])) {
            return $this->responses->error("Token inválido o expirado", 409);
        }
        
        return $this->responses->success("Contraseña actualizada");
    }

}
