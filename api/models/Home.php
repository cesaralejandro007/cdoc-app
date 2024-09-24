<?php

namespace App\Models;

use App\Core\Model;

class Home extends Model {
    private $table = "documentos";

    public function consultarReporteDocAll() {
        try {
            // Obtén el año actual
            $año_actual = date('Y');
    
            // Consulta 1: Obtener la cantidad de documentos por mes
            $sql_documentos = "SELECT 
                MONTH(fecha_registro) AS mes, 
                YEAR(fecha_registro) AS año, 
                COUNT(id_documento) AS cantidad 
            FROM 
                documentos 
            WHERE 
                YEAR(fecha_registro) = $año_actual
            GROUP BY 
                mes, 
                año 
            ORDER BY 
                año, 
                mes";
            $stmt_documentos = $this->conn->prepare($sql_documentos);
            $stmt_documentos->execute();
            $resultado_documentos = $stmt_documentos->fetchAll();
    
            // Consulta 2: Obtener las metas por mes
            $sql_meta = "SELECT 
                MONTH(fecha) AS mes, 
                YEAR(fecha) AS año, 
                meta 
            FROM 
                meta 
            JOIN 
                seccionesxmeta ON meta.id_meta = seccionesxmeta.id_meta
            WHERE 
                YEAR(fecha) = $año_actual";
            $stmt_meta = $this->conn->prepare($sql_meta);
            $stmt_meta->execute();
            $resultado_meta = $stmt_meta->fetchAll();
    
            // Inicializar el objeto para almacenar los resultados
            $documentos = [
                'todos' => array_fill(1, 12, ['cantidad' => 0, 'meta' => 'Sin Meta']),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ];
    
            // Combinar los resultados para 'todos'
            foreach ($resultado_documentos as $doc) {
                $mes = (int)$doc['mes'];
                $cantidad = (int)$doc['cantidad'];
    
                // Buscar la meta correspondiente para el mismo mes y año
                $meta_encontrada = 'Sin Meta';
                foreach ($resultado_meta as $meta) {
                    if ($meta['mes'] == $mes && $meta['año'] == $doc['año']) {
                        $meta_encontrada = $meta['meta'];
                        break;
                    }
                }
    
                // Almacenar el resultado en el arreglo 'todos'
                $documentos['todos'][$mes] = [
                    'cantidad' => $cantidad,
                    'meta' => $meta_encontrada
                ];
            }
    
            // Consulta y combinación para 'entrada', 'sin_entrada', y 'salida' (mantén las consultas que ya tienes)
            $queries = [
                'entrada' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                    FROM documentos
                    WHERE estatus = 1 AND YEAR(fecha_registro) = $año_actual
                    GROUP BY MONTH(fecha_registro)
                    ORDER BY mes",
                'sin_entrada' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                    FROM documentos
                    WHERE estatus = 2 AND YEAR(fecha_registro) = $año_actual
                    GROUP BY MONTH(fecha_registro)
                    ORDER BY mes",
                'salida' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                    FROM documentos
                    WHERE estatus = 3 AND YEAR(fecha_registro) = $año_actual
                    GROUP BY MONTH(fecha_registro)
                    ORDER BY mes"
            ];
    
            foreach ($queries as $key => $query) {
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                $resultados = $stmt->fetchAll();
    
                foreach ($resultados as $fila) {
                    $mes = (int)$fila['mes'];
                    $cantidad = (int)$fila['cantidad'];
                    $documentos[$key][$mes] = $cantidad;
                }
            }
    
            echo json_encode($documentos);
        } catch (Exception $e) {
            // Manejo de errores, puedes registrar el error si lo deseas
            echo json_encode([
                'todos' => array_fill(1, 12, ['cantidad' => 0, 'meta' => 'Sin Meta']),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ]);
        }
    }

    public function consultarDocEntrada() {
        $query = "SELECT * FROM documentos WHERE estatus = :estatus";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':estatus', 1);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll();
        $totalDocumentos = count($resultados);
        echo json_encode([
            'total' => $totalDocumentos,
            'documentos' => $resultados
        ]);
    }
    

public function consultarDocumentos($status = null) {

    $query = "SELECT * FROM documentos WHERE estatus = :estatus";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':estatus', $status);

    $stmt->execute();
    
    $resultados = $stmt->fetchAll();
    $totalDocumentos = count($resultados);

    echo json_encode([
        'total' => $totalDocumentos,
        'documentos' => $resultados
    ]);
}

public function consultarDocAll() {  
    $query = "SELECT * FROM documentos";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    
    $resultados = $stmt->fetchAll();
    $totalDocumentos = count($resultados);
    echo json_encode([
        'total' => $totalDocumentos,
        'documentos' => $resultados
    ]);
}

}
