// DocumentEntry.js

import React from 'react';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { AgGridReact } from 'ag-grid-react';
import { Typography } from '@mui/material';
import { usePagination } from '@mui/material';
import { AG_GRID_LOCALE_ES, paginationPageSizeSelector, columnDefs, frameworkComponents, useTableHandlers } from '../utils/tableConfig';
import { useCrud } from '../hooks/useCrud';

const DocumentEntry = React.memo(() => {
  const { paginationPageSize, onGridReady, onPageSizeChanged } = usePagination(paginationPageSizeSelector);
  const {
    data, 
    isLoading, 
    error, 
    handleEdit, 
    handleDelete, 
    handleMigrate
  } = useCrud('http://localhost/cdoc-app/api/documents-entry/all');

  const { handleEdit: edit, handleDelete: deleteHandler, handleMigrate: migrate } = useTableHandlers(handleEdit, handleDelete, handleMigrate);

  // Manejo de estados de carga y error
  if (isLoading) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;

  return (
    <div className="ag-theme-alpine" style={{ height: 400, width: '100%' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <Typography variant="h6" component="h2" gutterBottom>
          Reporte de Documentos
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
        columnDefs={columnDefs}
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
