<?php
use App\Core\AuthMiddleware;
use App\Routes\Route;
use App\Controllers\LoginController;
// Detecta la ruta base dinámicamente
$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Define la constante BASE_URL usando el valor detectado
define('BASE_URL', $baseUri);


/*##################### MODULO LOGIN #####################*/

// Endpoint para iniciar sesión de usuario
Route::post(BASE_URL . '/auth/login', 'App\Controllers\LoginController@iniciarSesion');;
Route::post(BASE_URL . '/auth/logout', 'App\Controllers\LoginController@cerrarSesion', [AuthMiddleware::class]);
Route::post(BASE_URL . '/auth/verify-email', 'App\Controllers\LoginController@verificarEmail');
Route::post(BASE_URL . '/auth/reset-password', 'App\Controllers\LoginController@restablecerContrasena');

/*##################### MODULO CONFIGURACION GLOBAL #####################*/

//REGISTRAR DATOS DE CONFIGURACION GLOBAL
Route::get(BASE_URL . '/conf/company/getNcf', 'App\Controllers\ConfigEmpresaController@consultarEmpresaNcf',  [AuthMiddleware::class]);
Route::get(BASE_URL . '/conf/company/getMoneda', 'App\Controllers\ConfigEmpresaController@consultarTipoModeda',  [AuthMiddleware::class]);
Route::get(BASE_URL . '/conf/company/getPaises', 'App\Controllers\ConfigEmpresaController@consultarPaises',  [AuthMiddleware::class]);
Route::get(BASE_URL . '/conf/company/getTiendas', 'App\Controllers\ConfigEmpresaController@consultarTiendas',  [AuthMiddleware::class]);
Route::get(BASE_URL . '/conf/company/getTipoVenta', 'App\Controllers\ConfigEmpresaController@consultarTipoVenta',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/company/create', 'App\Controllers\ConfigEmpresaController@registrarEmpresa',  [AuthMiddleware::class]);
/* Route::post(BASE_URL . '/conf/info-email', 'App\Controllers\ConfigController@registrarEmail',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/tax-receipts', 'App\Controllers\ConfigController@registrarComprobante',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/payment-form', 'App\Controllers\ConfigController@formaPago',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/license', 'App\Controllers\ConfigController@registrarLicencia',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/security', 'App\Controllers\ConfigController@registrarSeguridad',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/skins-wedgets', 'App\Controllers\ConfigController@skinsWedgets',  [AuthMiddleware::class]);
Route::post(BASE_URL . '/conf/calendar', 'App\Controllers\ConfigController@registrarCalendario',  [AuthMiddleware::class]); */

/*##################### MODULO USUARIO #####################*/
//GESTIONAR DATOS DE USUARIOS
Route::get(BASE_URL.'/user/all', 'App\Controllers\UsuarioController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/user/get/{id}', 'App\Controllers\UsuarioController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/user/create', 'App\Controllers\UsuarioController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/user/edit/{id}', 'App\Controllers\UsuarioController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/user/delete/{id}', 'App\Controllers\UsuarioController@delete', [AuthMiddleware::class]);



/*##################### MODULO INVENTARIO #####################*/
//GESTIONAR DATOS DE MEDIDAS
Route::get(BASE_URL.'/inventory/measure/all', 'App\Controllers\InventarioMedidaController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/inventory/measure/get/{id}', 'App\Controllers\InventarioMedidaController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/inventory/measure/create', 'App\Controllers\InventarioMedidaController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/inventory/measure/edit/{id}', 'App\Controllers\InventarioMedidaController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/inventory/measure/delete/{id}', 'App\Controllers\InventarioMedidaController@delete', [AuthMiddleware::class]);

//GESTIONAR ARTICULOS DE ALMANECEN AUN NO ESTA LISTO
Route::get(BASE_URL.'/inventory/article/store/all', 'App\Controllers\InventarioArticuloAlmacenController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/inventory/article/store/get/{id}', 'App\Controllers\InventarioArticuloAlmacenController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/inventory/article/store/create', 'App\Controllers\InventarioArticuloAlmacenController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/inventory/article/store/edit/{id}', 'App\Controllers\InventarioArticuloAlmacenController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/inventory/article/store/delete/{id}', 'App\Controllers\InventarioArticuloAlmacenController@delete', [AuthMiddleware::class]);



/*##################### MODULO PRODUCCION #####################*/

//GESTIONAR DATOS DE PRODUCCION-CATEGORIA
Route::get(BASE_URL.'/production/category/all', 'App\Controllers\ProduccionCategoriaController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/category/get/{id}', 'App\Controllers\ProduccionCategoriaController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/category/create', 'App\Controllers\ProduccionCategoriaController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/category/edit/{id}', 'App\Controllers\ProduccionCategoriaController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/production/category/delete/{id}', 'App\Controllers\ProduccionCategoriaController@delete', [AuthMiddleware::class]);

//GESTIONAR DATOS DE PRODUCCION-SUCURSAL
Route::get(BASE_URL.'/production/sucursal/all', 'App\Controllers\ProduccionSucursalController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/sucursal/get/{id}', 'App\Controllers\ProduccionSucursalController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/sucursal/create', 'App\Controllers\ProduccionSucursalController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/sucursal/edit/{id}', 'App\Controllers\ProduccionSucursalController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/production/sucursal/delete/{id}', 'App\Controllers\ProduccionSucursalController@delete', [AuthMiddleware::class]);

//GESTIONAR DATOS DE PRODUCCION-ALMACEN
Route::get(BASE_URL.'/production/store/all', 'App\Controllers\ProduccionAlmacenController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/store/get/{id}', 'App\Controllers\ProduccionAlmacenController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/store/create', 'App\Controllers\ProduccionAlmacenController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/store/edit/{id}', 'App\Controllers\ProduccionAlmacenController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/production/store/delete/{id}', 'App\Controllers\ProduccionAlmacenController@delete', [AuthMiddleware::class]);

//GESTIONAR DATOS DE PRODUCCION-RECETA
Route::get(BASE_URL.'/production/cooking/recipe/all', 'App\Controllers\ProduccionRecetaController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/cooking/recipe/get/{id}', 'App\Controllers\ProduccionRecetaController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/cooking/recipe/create', 'App\Controllers\ProduccionRecetaController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/cooking/recipe/edit/{id}', 'App\Controllers\ProduccionRecetaController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/production/cooking/recipe/delete/{id}', 'App\Controllers\ProduccionRecetaController@delete', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/cooking/recipe/category/set', 'App\Controllers\ProduccionRecetaController@asignarCategorias', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/cooking/recipe/category/get/{id}', 'App\Controllers\ProduccionRecetaController@obtenerCategorias', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/cooking/recipe/material/set', 'App\Controllers\ProduccionRecetaController@asignarMateriales', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/cooking/recipe/material/get/{id}', 'App\Controllers\ProduccionRecetaController@obtenerMateriales', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/cooking/recipe/ingredient/set', 'App\Controllers\ProduccionRecetaController@asignarIngredientes', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/cooking/recipe/ingredient/get/{id}', 'App\Controllers\ProduccionRecetaController@obtenerIngredientesPorReceta', [AuthMiddleware::class]);

//GESTIONAR DATOS DE PRODUCCION-KDS
Route::get(BASE_URL.'/production/kds/all', 'App\Controllers\ProduccionKDSController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/kds/get/{id}', 'App\Controllers\ProduccionKDSController@getById', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/kds/category/get/{id}', 'App\Controllers\ProduccionKDSController@obtenerCategorias', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/kds/create', 'App\Controllers\ProduccionKDSController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/kds/edit/{id}', 'App\Controllers\ProduccionKDSController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/production/kds/delete/{id}', 'App\Controllers\ProduccionKDSController@delete', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/kds/category/set', 'App\Controllers\ProduccionKDSController@asignarCategorias', [AuthMiddleware::class]);

//GESTIONAR DATOS DE PRODUCCION-MATERIAL
Route::get(BASE_URL.'/production/material/all', 'App\Controllers\ProduccionMaterialController@all', [AuthMiddleware::class]);
Route::get(BASE_URL . '/production/material/get/{id}', 'App\Controllers\ProduccionMaterialController@getById', [AuthMiddleware::class]);
Route::post(BASE_URL . '/production/material/create', 'App\Controllers\ProduccionMaterialController@create', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/material/edit/{id}', 'App\Controllers\ProduccionMaterialController@edit', [AuthMiddleware::class]);
Route::delete(BASE_URL . '/production/material/delete/{id}', 'App\Controllers\ProduccionMaterialController@delete', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/material/decrease/{id}', 'App\Controllers\ProduccionMaterialController@decreaseStock', [AuthMiddleware::class]);
Route::put(BASE_URL . '/production/material/increase/{id}', 'App\Controllers\ProduccionMaterialController@increaseStock', [AuthMiddleware::class]);
