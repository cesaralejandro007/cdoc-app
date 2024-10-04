// DocumentEntry.js

import React from 'react';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { AgGridReact } from 'ag-grid-react';
import { Typography } from '@mui/material';
import { usePagination } from '@mui/material';
import { useFetch } from '../hooks/useRequest';
import { AG_GRID_LOCALE_ES, paginationPageSizeSelector, columnDefsDocWithoutEntry, frameworkComponents, useTableHandlers } from '../utils/tableConfig';

const DocumentEntry = React.memo(() => {
  const { data, isLoading, error } = useFetch('http://localhost/cdoc-app/api/documents/all/2');
  const { paginationPageSize, onGridReady, onPageSizeChanged } = usePagination(paginationPageSizeSelector);

  // Funciones de manejo
  const handleEdit = (id) => {
    console.log(`Editar documento con ID: ${id}`);
  };

  const handleDelete = (id) => {
    console.log(`Eliminar documento con ID: ${id}`);
  };

  const handleMigrate = (id) => {
    console.log(`Migrar documento con ID: ${id}`);
  };

  // Uso de los manejadores
  const { handleEdit: edit, handleDelete: deleteHandler, handleMigrate: migrate } = useTableHandlers(handleEdit, handleDelete, handleMigrate);

  // Manejo de estados de carga y error
  if (isLoading) return <p>Cargando...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className="ag-theme-alpine" style={{ height: 400, width: '75%' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <Typography variant="h6" component="h2" gutterBottom>
          Documentos sin entrada
        </Typography>

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
        columnDefs={columnDefsDocWithoutEntry}
        localeText={AG_GRID_LOCALE_ES}
        paginationPageSize={paginationPageSize}
        pagination={true}
        onGridReady={onGridReady}
        components={{
          ...frameworkComponents,
          btns: ({ data }) => frameworkComponents.btns({ data, handleEdit: edit, handleDelete: deleteHandler, handleMigrate: migrate }),
        }}
        domLayout='autoHeight'
      />

      <style jsx="true">{`
        .ag-paging-panel .ag-paging-page-size {
          display: none;
        }
        button {
          padding: 3px 5px;
          margin: 2px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          display: flex;
          align-items: center;
        }
        button:hover {
          opacity: 0.8;
        }
      `}</style>
    </div>
  );
});

export default DocumentEntry;
