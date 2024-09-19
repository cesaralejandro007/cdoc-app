<?php
namespace App\Core;

use App\Models\Token;

class AuthMiddleware {

    protected $token;

    public function __construct() {
        $this->token = new Token();
    }

    public function handle($params) {
        // Obtener el token de los headers
        $headers = getallheaders();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        // Validar el token
        $validationResult = $this->validarToken($authHeader);

        if ($validationResult['status'] === 'success') {
            return true;
        }

        // Token inválido, detener la ejecución
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['message' => $validationResult['message']]);
        return false;
    }

    private function validarToken($authHeader) {
        $token = '';
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        } else {
            return ['status' => 'error', 'message' => 'Token de autorización no proporcionado o inválido.'];
        }

        // Dividir el token en partes
        $tokenParts = explode('.', $token);
        if (count($tokenParts) !== 3) {
            return ['status' => 'error', 'message' => 'Token inválido.'];
        }

        // Dividir el token en partes
        if (!$this->token->verifyToken($token)) {
            return ['status' => 'error', 'message' => 'No autorizado.'];
        }

        $base64UrlHeader = $tokenParts[0];
        $base64UrlPayload = $tokenParts[1];
        $base64UrlSignature = $tokenParts[2];
        $secretKey = $_ENV['JWT_SECRET'] ?? null; 

        if (!$secretKey) {
            return ['status' => 'error', 'message' => 'Clave secreta no encontrada.'];
        }

        // Crear la cadena de datos que se firmará
        $data = "$base64UrlHeader.$base64UrlPayload";
        
        // Generar la firma esperada usando HMAC SHA-256
        $signature = hash_hmac('sha256', $data, $secretKey, true);
        
        // Convertir la firma esperada a formato Base64 URL
        $base64UrlSignatureExpected = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        // Comparar la firma proporcionada con la firma esperada
        if (!hash_equals($base64UrlSignatureExpected, $base64UrlSignature)) {
            return ['status' => 'error', 'message' => 'Firma inválida.'];
        }

        // Decodificar el payload para verificar la fecha de expiración
        $payload = json_decode($this->base64UrlDecode($base64UrlPayload), true);

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return ['status' => 'error', 'message' => 'El token ha expirado.'];
        }

        // Si la firma es válida y el token no ha expirado, retornar éxito
        return ['status' => 'success', 'message' => 'Token válido.'];
    }

    private function base64UrlDecode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
