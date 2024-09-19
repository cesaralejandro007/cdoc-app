<?php
// Incluir el autoload de Composer
require_once 'vendor/autoload.php';

// Encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo de solicitudes preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // En caso de una solicitud preflight (OPTIONS), se responde con 200 OK
    http_response_code(200);
    exit();
}

// Cargar variables de entorno desde el archivo .env en la raíz del proyecto
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Cargar configuración de base de datos (si es necesario)
// require_once 'config/database.php';

// Cargar las rutas
require_once 'routes/Api.php';

// Despachar la solicitud
\App\Routes\Route::dispatch();
?>
