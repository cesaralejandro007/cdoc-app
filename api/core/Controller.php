<?php

namespace App\Core;

class Controller {
    // Método para enviar respuestas JSON
    protected function jsonResponse($data, $status = 200) {
        if (!headers_sent()) {
            header("Content-Type: application/json");
            http_response_code($status);
        }
        echo json_encode($data);
    }

    //Se recibe: nombre del campo, el valor,si es requerido, el tipo de variable, minimo de caracteres, y maximo
    public function validateField($field, $value, $required = false, $type = 'string', $minLength = null, $maxLength = null) {
        // Verificar si el campo es obligatorio y está presente
        if ($required && is_null($value)) {
            return "El campo '$field' es obligatorio";
        }
    
        // Si el valor no está presente, no realizar más validaciones
        if (is_null($value)) {
            return null;
        }
    
        // Verificar el tipo de dato
        if ($type === 'string' && !is_string($value)) {
            return "El campo '$field' debe contener cadena de texto";
        }
        
        if ($type === 'int' && !is_int($value)) {
            return "El campo '$field' debe contener números enteros";
        }    

        if ($type === 'float' && (!is_int($value) && !is_float($value))) {
            return "El campo '$field' debe contener números";
        }  
        
        if ($type === 'boolean' && !is_bool($value)) {
            return "El campo '$field' debe ser un valor booleano";
        }
    
        // Verificar la longitud mínima y máxima
        if ($type === 'string') {
            if (!is_null($minLength) && strlen($value) < $minLength) {
                return "El campo '$field' debe tener al menos $minLength caracteres";
            }
    
            if (!is_null($maxLength) && strlen($value) > $maxLength) {
                return "El campo '$field' no puede tener más de $maxLength caracteres";
            }
        }
        return null;
    }

    public function validarToken($authHeader) {
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

        $base64UrlHeader = $tokenParts[0];
        $base64UrlPayload = $tokenParts[1];
        $base64UrlSignature = $tokenParts[2];
        $secretKey = $_ENV['JWT_SECRET'] ?? null; // Asegúrate de que la clave secreta esté configurada

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
