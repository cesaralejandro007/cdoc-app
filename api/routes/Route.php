<?php

namespace App\Routes;

class Route {
    private static $routes = [];
    private static $middleware = [];

    /**
     * Registra una ruta GET.
     */
    public static function get($uri, $controllerMethod, $middleware = []) {
        self::addRoute('GET', $uri, $controllerMethod, $middleware);
    }

    /**
     * Registra una ruta POST.
     */
    public static function post($uri, $controllerMethod, $middleware = []) {
        self::addRoute('POST', $uri, $controllerMethod, $middleware);
    }

    /**
     * Registra una ruta PUT.
     */
    public static function put($uri, $controllerMethod, $middleware = []) {
        self::addRoute('PUT', $uri, $controllerMethod, $middleware);
    }

    /**
     * Registra una ruta DELETE.
     */
    public static function delete($uri, $controllerMethod, $middleware = []) {
        self::addRoute('DELETE', $uri, $controllerMethod, $middleware);
    }

    /**
     * Registra la ruta con su método HTTP, controlador y middleware.
     */
    private static function addRoute($method, $uri, $controllerMethod, $middleware = []) {
        self::$routes[$method][self::convertUri($uri)] = [
            'controller' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Convierte la URI en una expresión regular para capturar parámetros dinámicos.
     * Permite parámetros con nombres como `{id}` o `{slug}`.
     */
    private static function convertUri($uri) {
        return preg_replace('/{(\w+)}/', '(?P<$1>[^/]+)', $uri);
    }

    /**
     * Despacha la solicitud al controlador correspondiente.
     */
    public static function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
    
        if (!isset(self::$routes[$method])) {
            self::notFound();
            return;
        }
    
        foreach (self::$routes[$method] as $route => $routeInfo) {
            if (preg_match("#^{$route}$#", $uri, $matches)) {
                // Extraer parámetros nombrados
                $params = self::extractParams($matches);
                
                // Obtener datos de la solicitud para métodos POST y PUT
                if ($method == 'POST' || $method == 'PUT') {
                    $input = json_decode(file_get_contents('php://input'), true);
                    if (!$input) {
                        $input = $_POST; // Alternativamente, manejar otros tipos de entrada si es necesario
                    }
                    $params[] = $input; // Añadir los datos al final de los parámetros
                }
    
                // Ejecutar el middleware si existe
                foreach ($routeInfo['middleware'] as $middleware) {
                    if (!self::runMiddleware($middleware, $params)) {
                        return;
                    }
                }
    
                // Ejecutar el controlador
                $controllerAction = explode('@', $routeInfo['controller']);
                $controllerName = $controllerAction[0];
                $methodName = $controllerAction[1];
    
                // Comprobar si el controlador y el método existen
                if (!class_exists($controllerName)) {
                    self::serverError("El controlador {$controllerName} no existe");
                    return;
                }
    
                $controller = new $controllerName();
                if (!method_exists($controller, $methodName)) {
                    self::serverError("El método {$methodName} en {$controllerName} no existe");
                    return;
                }
    
                // Llamar al método del controlador con los parámetros
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }
    
        self::notFound();
    }

    /**
     * Respuesta 500 para errores internos del servidor.
     */
    private static function serverError($message) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(['message' => $message]);
    }

    

    /**
     * Extrae los parámetros nombrados de la URI.
     */
    private static function extractParams($matches) {
        return array_filter($matches, function ($key) {
            return !is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Ejecuta el middleware. Si el middleware falla, retorna false y detiene la ejecución.
     */
    private static function runMiddleware($middleware, $params) {
        $middlewareInstance = new $middleware();
        return $middlewareInstance->handle($params);
    }

    /**
     * Respuesta 404 en caso de ruta no encontrada.
     */
    private static function notFound() {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['message' => 'Ruta no encontrada']);
    }
}
