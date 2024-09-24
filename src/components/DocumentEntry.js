import React, { useMemo, useCallback } from 'react';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { AgGridReact } from 'ag-grid-react';
import { Typography } from '@mui/material';
import { usePagination } from '@mui/material';
import EditIcon from '@mui/icons-material/Edit'; // Icono de editar
import DeleteIcon from '@mui/icons-material/Delete'; // Icono de eliminar
import UploadIcon from '@mui/icons-material/Upload'; // Icono de migrar
import { useFetch } from '../hooks/useRequest';
import { AG_GRID_LOCALE_ES, paginationPageSizeSelector } from '../utils/tableConfig';

const DocumentEntry = React.memo(() => {
  // Obtiene los datos de la API
  const { data, isLoading, error } = useFetch('http://localhost/cdoc-app/api/documents-entry/all');
  const { paginationPageSize, onGridReady, onPageSizeChanged } = usePagination(paginationPageSizeSelector);

  // Definición de columnas de la tabla
  const columnDefs = useMemo(() => [
    { headerName: 'Opciones', field: 'editar', cellRenderer: 'btns' },
    { headerName: 'Fecha de Entrada', field: 'fecha_entrada_formateada' },
    { headerName: 'Datos de la persona', field: 'usuario_completo' },
    { headerName: 'Nº de documento', field: 'numero_doc' },
    { headerName: 'Nombre de Remitente', field: 'nombre_rem' },
    { headerName: 'Tipo de Documento', field: 'nombre_doc' },
  ], []);

  // Componentes de acción
  const frameworkComponents = useMemo(() => ({
    btns: ({ data }) => (
      <div style={{ display: "flex", justifyContent: "center", alignItems: "center", height: '100%' }} >
        <button onClick={() => handleEdit(data.id_documento)} style={{ cursor: 'pointer', padding: '3px 5px', backgroundColor: '#E67E22', color: 'white', margin: '2px', border: 'none', borderRadius: '4px' }}>
          <EditIcon fontSize="small" />
        </button>
        <button onClick={() => handleDelete(data.id_documento)} style={{ cursor: 'pointer', padding: '3px 5px', backgroundColor: '#9D2323', color: 'white', margin: '2px', border: 'none', borderRadius: '4px' }}>
          <DeleteIcon fontSize="small" />
        </button>
        <button onClick={() => handleMigrate(data.id_documento)} style={{ cursor: 'pointer', padding: '3px 5px', backgroundColor: '#0228B5', color: 'white', margin: '2px', border: 'none', borderRadius: '4px' }}>
          <UploadIcon fontSize="small" />
        </button>
      </div>
    )
  }), []);

  // Funciones de manejo
  const handleEdit = useCallback((id) => {
    console.log(`Editar documento con ID: ${id}`);
  }, []);

  const handleDelete = useCallback((id) => {
    console.log(`Eliminar documento con ID: ${id}`);
  }, []);

  const handleMigrate = useCallback((id) => {
    console.log(`Migrar documento con ID: ${id}`);
  }, []);

  // Manejo de estados de carga y error
  if (isLoading) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;

  return (
    <div className="ag-theme-alpine" style={{ height: 400, width: '100%' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <Typography variant="h6" component="h2" gutterBottom>
          Reporte de Documentos
        </Typography>

        {/* Selector de tamaño de página personalizado */}
        <div style={{ display: 'flex', alignItems: 'center' }}>
          <label htmlFor="pageSize" style={{ marginRight: '8px' }}>Tamaño de página:</label>
          <select id="pageSize" value={paginationPageSize} onChange={onPageSizeChanged}>
            {paginationPageSizeSelector.map(size => (
              <option key={size} value={size}>{size}</option>
            ))}
          </select>
        </div>
      </div>

      <AgGridReact
        rowData={data?.data}
        columnDefs={columnDefs}
        localeText={AG_GRID_LOCALE_ES}
        paginationPageSize={paginationPageSize}
        pagination={true}
        onGridReady={onGridReady}
        frameworkComponents={frameworkComponents}
        components={frameworkComponents}
        domLayout='autoHeight'
      />

      <style jsx="true">{`
        .ag-paging-panel .ag-paging-page-size {
          display: none;  /* Ocultar el selector de tamaño de página por defecto */
        }
        button {
          padding: 3px 5px; /* Botones más pequeños */
          margin: 2px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          display: flex;
          align-items: center;
        }
        button:hover {
          opacity: 0.8; /* Efecto de opacidad al pasar el mouse */
        }
      `}</style>
    </div>
  );
});

export default DocumentEntry;
