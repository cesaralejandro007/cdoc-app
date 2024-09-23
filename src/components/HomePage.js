// src/components/HomePage.js
import React, { useState, useEffect, useContext } from 'react';
import { Outlet, useLocation } from 'react-router-dom';
import { Box, CssBaseline, CircularProgress, Container, Grid, Paper, Typography } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { AuthContext } from '../context/AuthContext';
import Sidebar from './sidebar/Sidebar';
import Header from './header/Header';
import Footer from './footer/Footer';
import { AgGridReact } from 'ag-grid-react';
import 'ag-grid-community/styles/ag-grid.css'; // AG Grid base styles
import 'ag-grid-community/styles/ag-theme-alpine.css'; // AG Grid theme styles
const AG_GRID_LOCALE_ES = {
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

const HomePage = () => {
  
  const { user, loading } = useContext(AuthContext);
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const [reportData, setReportData] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const navigate = useNavigate();
  const location = useLocation();
  const pagination = true;
  const paginationPageSize = 6;
  const paginationPageSizeSelector = [6,12,24,48,100];
  useEffect(() => {
    if (!loading && !user) {
      navigate('/login');
    }
  }, [user, loading, navigate]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch('http://localhost/cdoc-app/api/home/report', {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${user.token}`,
            'Content-Type': 'application/json',
          },
        });
        const data = await response.json();
        setReportData(data);
        setIsLoading(false);
      } catch (error) {
        console.error("Error al obtener los datos de la API", error);
        setIsLoading(false);
      }
    };
    if (user && user.token) {
      fetchData();
    }
  }, [user]);

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  if (loading || isLoading) {
    return (
      <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100vh' }}>
        <CircularProgress />
      </div>
    );
  }

  // Definir las columnas para AG Grid
  const columns = [
    { headerName: 'Mes', field: 'mes', sortable: true, filter: true },
    { headerName: 'Doc. Entrada', field: 'entrada', sortable: true, filter: true },
    { headerName: 'Doc. Salida', field: 'salida', sortable: true, filter: true },
    { headerName: 'Doc. Sin Entrada', field: 'sin_entrada', sortable: true, filter: true },
    { headerName: 'Todos Doc.', field: 'todos', sortable: true, filter: true },
    { headerName: '% Cumplimiento', field: 'cumplimiento', sortable: true, filter: true },
    { headerName: 'Meta', field: 'meta', sortable: true, filter: true },
  ];

  // Procesar los datos para la tabla
  const tableData = Object.keys(reportData.todos).map((mes) => ({
    mes: mes,
    entrada: reportData.entrada[mes],
    salida: reportData.salida[mes],
    sin_entrada: reportData.sin_entrada[mes],
    todos: reportData.todos[mes].cantidad,
    cumplimiento: reportData.todos[mes].meta === 'Sin Meta' ? 'N/A' : `${((reportData.todos[mes].cantidad / reportData.todos[mes].meta) * 100).toFixed(2)}%`,
    meta: reportData.todos[mes].meta,
  }));

  return (
    <Box sx={{ display: 'flex', minHeight: '100vh', flexDirection: 'column' }}>
      <CssBaseline />
      <Header onToggleSidebar={toggleSidebar} isSidebarOpen={isSidebarOpen} />
      <Sidebar open={isSidebarOpen} />
      <Container sx={{ flexGrow: 1, marginLeft: isSidebarOpen ? '250px' : '0', transition: 'margin-left 0.3s', padding: '20px', marginTop: '64px', marginBottom: '64px' }}>
        {location.pathname === '/home' ? (
          <Grid container spacing={2}>
            <Grid item xs={12}>
              <Paper elevation={3} sx={{ padding: '16px' }}>
                <Typography variant="h6" component="h2" gutterBottom>
                  Reporte de Documentos
                </Typography>
                <div className="ag-theme-alpine" style={{ height: 400, width: '100%' }}>
                  <AgGridReact
                    rowData={tableData}
                    columnDefs={columns}
                    domLayout='autoHeight'
                    pagination={pagination}
                    localeText={AG_GRID_LOCALE_ES} // Usar localización en español
                    paginationPageSize={paginationPageSize}
                    paginationPageSizeSelector={paginationPageSizeSelector}
                    paginationAutoPageSize={false} // Se desactiva el tamaño de página automático
                  />
                </div>
              </Paper>
            </Grid>
          </Grid>
        ) : (
          <Outlet />
        )}
      </Container>
      <Footer isSidebarOpen={isSidebarOpen} />
    </Box>
  );
};

export default HomePage;
