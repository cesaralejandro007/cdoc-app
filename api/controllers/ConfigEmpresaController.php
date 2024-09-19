<?php

namespace App\Controllers;

use App\Models\Empresa;
use App\Models\Tiendas;
use App\Models\EmpresasNcf;
use App\Models\TipoMoneda;
use App\Models\TipoVenta;
use App\Models\Paises;
use App\Core\Controller;
use App\Core\Responses;
class ConfigEmpresaController extends Controller {

    protected $responses;
    protected $empresa;
    protected $tiendas;
    protected $empresas_ncf;
    protected $tipo_moneda;
    protected $tipo_ventas;
    protected $paises;

    public function __construct() {
        $this->responses = new Responses();
        $this->empresa = new Empresa();
        $this->tiendas = new Tiendas();
        $this->empresas_ncf = new EmpresasNcf();
        $this->tipo_moneda = new TipoMoneda();
        $this->tipo_ventas = new TipoVenta();
        $this->paises = new Paises();
    }

    public function consultarTiendas() {
        $info = $this->tiendas->all();
        if (!$info) {
            return $this->responses->error("No hay datos disponibles", 205);
        }
        return $this->responses->success("Información disponible",$info);
    }

    public function consultarEmpresaNcf() {
        $info = $this->empresas_ncf->all();
        if (!$info) {
            return $this->responses->error("No hay datos disponibles", 205);
        }
        return $this->responses->success("Información disponible",$info);
    }

    public function consultarTipoModeda() {
        $info = $this->tipo_moneda->all();
        if (!$info) {
            return $this->responses->error("No hay datos disponibles", 205);
        }
        return $this->responses->success("Información disponible",$info);
    }

    
    public function consultarPaises() {
        $info = $this->paises->all();
        if (!$info) {
            return $this->responses->error("No hay datos disponibles", 205);
        }
        return $this->responses->success("Información disponible",$info);
    }

    public function consultarTipoVenta() {
        $info = $this->tipo_ventas->all();
        if (!$info) {
            return $this->responses->error("No hay datos disponibles", 205);
        }
        return $this->responses->success("Información disponible",$info);
    }

    public function registrarEmpresa($request) {
        $fields = [
            'empresa' => $request['empresa'] ?? null,
            'tienda' => $request['tienda'] ?? null,
            'nombre_empresa' => $request['nombre_empresa'] ?? null,
            'documento' => $request['documento'] ?? null,
            'rnc' => $request['rnc'] ?? null,
            'email' => $request['email'] ?? null,
            'address1' => $request['address1'] ?? null,
            'address2' => $request['address2'] ?? null,
            'phone1' => $request['phone1'] ?? null,
            'phone2' => $request['phone2'] ?? null,
            'foto' => $request['foto'] ?? null,
            'itbis_cargado_monto' => $request['itbis_cargado_monto'] ?? null,
            'porciento_ley' => $request['porciento_ley'] ?? null,
            'tipo_impresora_facturas' => $request['tipo_impresora_facturas'] ?? null,
            'tipo_impresora_cotizaciones' => $request['tipo_impresora_cotizaciones'] ?? null,
            'ncf_predeterminado' => $request['ncf_predeterminado'] ?? null,
            'activar_impresora_fiscal' => $request['activar_impresora_fiscal'] ?? null,
            'tipo_moneda' => $request['tipo_moneda'] ?? null,
            'prestamos' => $request['prestamos'] ?? null,
            'pie_factura' => $request['pie_factura'] ?? null,
            'pie_cotizacion' => $request['pie_cotizacion'] ?? null,
            'pais' => $request['pais'] ?? null,
            'margenGanancia' => $request['margenGanancia'] ?? null,
            'id_tipo_venta' => $request['id_tipo_venta'] ?? null,
            'margen' => $request['margen'] ?? null
        ];
        $errors = [];
        $errors[] = $this->validateField('ID_empresa', $fields['empresa'], true, 'int', 1, 51);
        $errors[] = $this->validateField('Tipo de tienda', $fields['tienda'], false, 'int', 1, 51);
        $errors[] = $this->validateField('Nombre de la Empresa', $fields['nombre_empresa'], false, 'string', 3, 150);
        $errors[] = $this->validateField('Documento', $fields['documento'], true, 'string', 3, 20);
        $errors[] = $this->validateField('rnc', $fields['rnc'], false, 'string', 3, 14);
        $errors[] = $this->validateField('E-mail', $fields['email'], false, 'string', 4, 70);
        $errors[] = $this->validateField('Dirección Principal', $fields['address1'], false, 'string', 4, 100);
        $errors[] = $this->validateField('Dirección Secundaria', $fields['address2'], false, 'string', 4, 100);
        $errors[] = $this->validateField('phone1', $fields['phone1'], false, 'string', 4, 15);
        $errors[] = $this->validateField('phone2', $fields['phone2'], false, 'string', 1, 15);
        $errors[] = $this->validateField('Logo de la Empresa', $fields['foto'], false, 'string', 1, 200);
        $errors[] = $this->validateField('ITBIS Cargado en Monto', $fields['itbis_cargado_monto'], false, 'int', 1, 1);
        $errors[] = $this->validateField('Porciento ley', $fields['porciento_ley'], false, 'float', 1, 16);
        $errors[] = $this->validateField('Tipo de impresora defacturas', $fields['tipo_impresora_facturas'], false, 'int', 1, 11);
        $errors[] = $this->validateField('Tipo de impresora de cotizaciones', $fields['tipo_impresora_cotizaciones'], false, 'int', 1, 11);
        $errors[] = $this->validateField('NCF predeterminado', $fields['ncf_predeterminado'], false, 'int', 1, 11);
        $errors[] = $this->validateField('Activar impresora fiscal', $fields['activar_impresora_fiscal'], false, 'int', 1, 1);
        $errors[] = $this->validateField('Moneda', $fields['tipo_moneda'], false, 'int', 1, 11);
        $errors[] = $this->validateField('Prestamos', $fields['prestamos'], false, 'int', 1, 11);
        $errors[] = $this->validateField('Pie de factura', $fields['pie_factura'], false, 'string', 3, 455);
        $errors[] = $this->validateField('Pie de cotizacion', $fields['pie_cotizacion'], false, 'string', 3, 455);
        $errors[] = $this->validateField('País', $fields['pais'], false, 'int', 1, 11);
        $errors[] = $this->validateField('Margen de ganancia', $fields['margenGanancia'], false, 'int', 1, 11);
        $errors[] = $this->validateField('ID tipo venta', $fields['id_tipo_venta'], false, 'int', 1, 11);
        $errors[] = $this->validateField('Margen', $fields['margen'], false, 'float', 1, 11);
        $errors = array_filter($errors);

        if (!empty($errors)) {
            return $this->responses->error(implode(', ', $errors), 400);
        }
        if($fields['id_tipo_venta'] != null && $fields['margen'] != null){
            $this->tipo_ventas->edit($fields["id_tipo_venta"], ['margen' => $fields['margen']]);
        }else{
            $this->tipo_ventas->editDefault();
        }
        
        $empresa = $this->empresa->byId($fields["empresa"]);
        if (!$empresa) {
            $info = $this->empresa->create($request);
            if (!$info) {
                return $this->responses->error("El registro de la empresa no se completó", 500);
            }
            return $this->responses->success("El registro de la empresa fue exitoso");
        } else {
            $info = $this->empresa->edit($fields["empresa"], $request);
            if (!$info) {
                return $this->responses->error("La actualización de la empresa no se completó", 500);
            }
            return $this->responses->success("La actualización de la empresa fue exitosa");
        }

        
        
    }
    
}   
