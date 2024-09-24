import { useState,useCallback} from "react";
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import UploadIcon from '@mui/icons-material/Upload';

// utils/tableConfig.js
export const AG_GRID_LOCALE_ES = {
    // for filter panel
    page: 'Página',
    more: 'Más',
    to: 'a',
    of: 'de',
    next: 'Siguiente',
    last: 'Último',
    first: 'Primero',
    previous: 'Anterior',
    loadingOoo: 'Cargando...',

    // for pagination
    pageSize: 'Tamaño de página',
    blanks: 'En blanco',
    notBlanks: 'No en blanco',

    // for set filter
    selectAll: 'Seleccionar Todo',
    searchOoo: 'Buscar...',

    // for number filter and text filter
    filterOoo: 'Filtrar',
    applyFilter: 'Aplicar Filtro...',
    equals: 'Igual',
    notEqual: 'No Igual',

    // for number filter
    lessThan: 'Menos que',
    greaterThan: 'Mayor que',
    lessThanOrEqual: 'Menos o igual que',
    greaterThanOrEqual: 'Mayor o igual que',
    inRange: 'En rango de',

    // for text filter
    contains: 'Contiene',
    notContains: 'No contiene',
    startsWith: 'Empieza con',
    endsWith: 'Termina con',

    // filter conditions
    andCondition: 'Y',
    orCondition: 'O',

    // the header of the default group column
    group: 'Grupo',

    // tool panel
    columns: 'Columnas',
    filters: 'Filtros',
    valueColumns: 'Valores de las Columnas',
    pivotMode: 'Modo Pivote',
    groups: 'Grupos',
    values: 'Valores',
    pivots: 'Pivotes',
    toolPanelButton: 'Botón del Panel de Herramientas',

    // other
    noRowsToShow: 'No hay filas para mostrar',

    // enterprise menu
    pinColumn: 'Columna Pin',
    valueAggregation: 'Agregar valor',
    autosizeThisColumn: 'Autoajustar esta columna',
    autosizeAllColumns: 'Ajustar todas las columnas',
    groupBy: 'Agrupar',
    ungroupBy: 'Desagrupar',
    resetColumns: 'Reiniciar Columnas',
    expandAll: 'Expandir todo',
    collapseAll: 'Colapsar todo',
    toolPanel: 'Panel de Herramientas',
    export: 'Exportar',
    csvExport: 'Exportar a CSV',
    excelExport: 'Exportar a Excel (.xlsx)',
    excelXmlExport: 'Exportar a Excel (.xml)',

    // enterprise menu pinning
    pinLeft: 'Pin Izquierdo',
    pinRight: 'Pin Derecho',

    // enterprise menu aggregation and status bar
    sum: 'Suma',
    min: 'Mínimo',
    max: 'Máximo',
    none: 'Nada',
    count: 'Contar',
    average: 'Promedio',

    // standard menu
    copy: 'Copiar',
    copyWithHeaders: 'Copiar con cabeceras',
    paste: 'Pegar'
};

export const paginationPageSizeSelector = [6, 12, 24, 48, 100];

export const getColumns = () => [
    { headerName: 'Mes', field: 'mes', sortable: true, filter: true },
    { headerName: 'Doc. Entrada', field: 'entrada', sortable: true, filter: true },
    { headerName: 'Doc. Salida', field: 'salida', sortable: true, filter: true },
    { headerName: 'Doc. Sin Entrada', field: 'sin_entrada', sortable: true, filter: true },
    { headerName: 'Todos Doc.', field: 'todos', sortable: true, filter: true },
    { headerName: '% Cumplimiento', field: 'cumplimiento', sortable: true, filter: true },
    { headerName: 'Meta', field: 'meta', sortable: true, filter: true },
];

// utils/tableConfig.js


// Definición de columnas de la tabla
export const columnDefs = [
  { headerName: 'Opciones', field: 'editar', cellRenderer: 'btns' },
  { headerName: 'Fecha de Entrada', field: 'fecha_entrada_formateada' },
  { headerName: 'Datos de la persona', field: 'usuario_completo' },
  { headerName: 'Nº de documento', field: 'numero_doc' },
  { headerName: 'Nombre de Remitente', field: 'nombre_rem' },
  { headerName: 'Tipo de Documento', field: 'nombre_doc' },
];

// Componentes de acción
export const frameworkComponents = {
  btns: ({ data, handleEdit, handleDelete, handleMigrate }) => (
    <div style={{ display: "flex", justifyContent: "center", alignItems: "center", height: '100%' }} >
      <button onClick={() => handleEdit(data.id_documento)} style={buttonStyle}>
        <EditIcon fontSize="small" />
      </button>
      <button onClick={() => handleDelete(data.id_documento)} style={buttonStyle}>
        <DeleteIcon fontSize="small" />
      </button>
      <button onClick={() => handleMigrate(data.id_documento)} style={buttonStyle}>
        <UploadIcon fontSize="small" />
      </button>
    </div>
  ),
};

// Estilo para los botones
const buttonStyle = {
  cursor: 'pointer',
  padding: '3px 5px',
  margin: '2px',
  border: 'none',
  borderRadius: '4px',
  color: 'white',
};

// Funciones de manejo
export const useTableHandlers = (onEdit, onDelete, onMigrate) => {
  const handleEdit = useCallback((id) => {
    onEdit(id);
  }, [onEdit]);

  const handleDelete = useCallback((id) => {
    onDelete(id);
  }, [onDelete]);

  const handleMigrate = useCallback((id) => {
    onMigrate(id);
  }, [onMigrate]);

  return { handleEdit, handleDelete, handleMigrate };
};


export const getTableData = (reportData) =>
    Object.keys(reportData.todos).map((mes) => ({
        mes: mes,
        entrada: reportData.entrada[mes],
        salida: reportData.salida[mes],
        sin_entrada: reportData.sin_entrada[mes],
        todos: reportData.todos[mes].cantidad,
        cumplimiento: reportData.todos[mes].meta === 'Sin Meta' ? 'N/A' : `${((reportData.todos[mes].cantidad / reportData.todos[mes].meta) * 100).toFixed(2)}%`,
        meta: reportData.todos[mes].meta,
    }));

    export const CustomPagination = ({ api }) => {
        const [pageSize, setPageSize] = useState(api.paginationGetPageSize());
    
        const onPageSizeChanged = (event) => {
            const newSize = Number(event.target.value);
            api.paginationSetPageSize(newSize);
            setPageSize(newSize);
        };
    
        return (
            <div className="custom-pagination">
                <span>Página {api.paginationGetCurrentPage() + 1} de {api.paginationGetTotalPages()}</span>
                <span>
                    Tamaño de página:
                    <select value={pageSize} onChange={onPageSizeChanged}>
                        {paginationPageSizeSelector.map(size => (
                            <option key={size} value={size}>{size}</option>
                        ))}
                    </select>
                </span>
            </div>
        );
    };
    