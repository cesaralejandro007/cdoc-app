<?php

namespace App\Core;

class Responses{
    /**
     * Respuesta de éxito en formato JSON.
     */
    public static function success($message, $data = [], $rows = null, $code = 200) {
        if (!headers_sent()) {
            http_response_code($code); // Establecer el código HTTP
            header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON
        }
        echo json_encode([
            'OK' => true,
            'code' => $code,
            'message' => $message,
            'rows' => $rows,
            'data' => $data
        ]);
    }

    /**
     * Respuesta de error en formato JSON.
     */
    public static function error($message, $code) {
        if (!headers_sent()) {
            http_response_code($code); // Establecer el código HTTP
            header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON
        }
        echo json_encode([
            'OK' => false,
            'code' => $code,
            'message' => $message
        ]);
    }
}
