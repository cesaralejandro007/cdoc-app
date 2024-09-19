<?php

namespace App\Models;

use \Firebase\JWT\JWT;
use App\Core\Model;

class Login extends Model {

    public function ById($cedula) {
        $query = "SELECT * FROM usuarios WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }


    /**
     * Inicia sesión del usuario.
     *
     * Esta función verifica si el usuario existe y la clave proporcionada coincide con la almacenada.
     * Devuelve la información del usuario si las credenciales son correctas.
     *
     * @param array $data Datos del usuario (incluye 'email' y 'clave').
     * @return array|null Información del usuario si el inicio de sesión es exitoso, null en caso contrario.
     */

    public function iniciarSesion($data) {
        $usuario = $this->verificarUsuario($data);
    
        if ($usuario && password_verify($data['clave'], $usuario['contrasena'])) {
            // Datos del usuario para el token
            $payload = [
                'cedula' => $usuario['cedula'],
                'clave' => $data['clave'],
                'id_usuario' => $usuario['id_usuario'],
                'iat' => time(), // Hora en la que se emite el token
                'exp' => time() + (60 * 60 * 24) // El token expira en 1 dia
            ];
    
            $secretKey = $_ENV['JWT_SECRET'];   
    
            // Generar el token JWT
            $token = JWT::encode($payload, $secretKey, 'HS256');

            $fechai = $this->convertirUnixAFecha($payload["iat"]);
            $fechae = $this->convertirUnixAFecha($payload["exp"]);

            $this->registrar_token($usuario["id_usuario"],$usuario["rol"],$token,$fechai,$fechae);

            return [
                'usuario' =>$usuario,
                'token' => $token
            ];

        }
        return null;
    }

    public function convertirUnixAFecha($timestamp_unix) {
        $fecha_formateada = date("Y-m-d H:i:s", $timestamp_unix);
        return $fecha_formateada;
    }

    public function registrar_token($id_usuario,$rol,$token,$fecha_inicio,$fecha_fin){
        $query = "INSERT INTO tokens_login (has,fecha,vence,rol,id_usuario) VALUES (:has, :fecha, :vence, :rol, :id_usuario)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':has', $token);
        $stmt->bindParam(':fecha', $fecha_inicio);
        $stmt->bindParam(':vence', $fecha_fin);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id_usuario', $id_usuario);
        return $stmt->execute(); 
    }
    /**
     * Verifica la existencia del usuario por email.
     *
     * Esta función consulta la base de datos para obtener la información del usuario basado en su email.
     *
     * @param array $data Datos del usuario (debe incluir 'email').
     * @return array Información del usuario si existe, null en caso contrario.
     */

    public function verificarUsuario($data){
        $cedula = $data['cedula'] ?? ''; // Obtiene el email del usuario
        $query = "SELECT * FROM usuarios WHERE cedula = :cedula"; // Consulta SQL para obtener información del usuario
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); // Devuelve la información del usuario
    }
    
    /**
     * Verifica si un correo electrónico está registrado.
     *
     * Esta función consulta la base de datos para ver si existe un usuario con el email proporcionado.
     *
     * @param string $email Email del usuario.
     * @return array|null Información del usuario si el email está registrado, null en caso contrario.
     */
    public function verificarCedula($cedula) {
        $query = "SELECT id, cedula FROM usuarios WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}
