import React, { useState } from 'react';
import { Outlet, useLocation } from 'react-router-dom';
import { Box, CssBaseline, CircularProgress, Grid, Typography } from '@mui/material';
import { AgGridReact } from 'ag-grid-react';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { useHomePageData } from '../hooks/useReportData';
import { getColumns, getTableData, paginationPageSizeSelector, AG_GRID_LOCALE_ES } from '../utils/tableConfig';
import useChartOptions from "../hooks/useReportChart";
import Sidebar from './sidebar/Sidebar';
import Header from './header/Header';
import Footer from './footer/Footer';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official'; // Importa Highcharts y el wrapper de React
import AssignmentReturnIcon from '@mui/icons-material/AssignmentReturn';
import DriveFileMoveIcon from '@mui/icons-material/DriveFileMove';
import AssignmentReturnedIcon from '@mui/icons-material/AssignmentReturned';
import GradingIcon from '@mui/icons-material/Grading';
import { usePagination } from '../hooks/usePagination';

const HomePage = () => {
  const location = useLocation();
  const { reportData, docAll, docEntrada, docSinEntrada, docSalida, isLoading } = useHomePageData();
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const { paginationPageSize, onGridReady, onPageSizeChanged } = usePagination(paginationPageSizeSelector);
  const columns = getColumns();
  const tableData = reportData ? getTableData(reportData) : [];
  const chartOptions = useChartOptions(reportData);

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  if (isLoading) {
    return (
      <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100vh' }}>
        <CircularProgress />
      </div>
    );
  }
  
  return (
    <Box sx={{ display: 'flex', minHeight: '100vh', flexDirection: 'column' }}>
      <CssBaseline />
      <Header onToggleSidebar={toggleSidebar} isSidebarOpen={isSidebarOpen} />

      <Sidebar
        open={isSidebarOpen}
        sx={{
          position: { xs: 'fixed', md: 'relative' }, // Fijo en pantallas pequeñas, relativo en grandes
          width: { xs: isSidebarOpen ? '250px' : '0', md: '250px' }, // 250px en pantallas grandes, colapsable en pequeñas
          transition: 'width 0.3s',
          zIndex: { xs: 1200, md: 'auto' }, // Prioridad de z-index para pantallas pequeñas
        }}
      />

      <Box
        sx={{
          flexGrow: 1,
          marginLeft: { xs: 0, md: isSidebarOpen ? '250px' : '0' }, // Ajuste de margen basado en el tamaño de la pantalla
          transition: 'margin-left 0.3s',
          padding: { xs: '16px', md: '30px' }, // Padding más pequeño en pantallas pequeñas
          marginTop: '64px',
          marginBottom: '64px',
          width: { xs: '100%', md: isSidebarOpen ? 'calc(100% - 250px)' : '100%' }, // Ajustar ancho para pantallas grandes
          overflowX: 'hidden',
        }}
      >
        {location.pathname === '/home' ? (
          <>
            <Grid container spacing={3} justifyContent="center">
              <Grid item xs={12} sm={6} md={3}> {/* Cambia el tamaño en diferentes pantallas */}
                <Box
                  sx={{
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    padding: '16px',
                    textAlign: 'center',
                    boxShadow: '5px 5px 5px 1px rgba(128, 128, 128, 0.5)'
                  }}
                >
                  <AssignmentReturnIcon sx={{ fontSize: 40, color: 'green' }} />
                  <Typography variant="h5">{docEntrada}</Typography>
                  <Typography variant="subtitle1">Total Doc. Entrada</Typography>
                </Box>
              </Grid>
              <Grid item xs={12} sm={6} md={3}>
                <Box
                  sx={{
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    padding: '16px',
                    textAlign: 'center',
                    boxShadow: '5px 5px 5px 1px rgba(128, 128, 128, 0.5)'
                  }}
                >
                  <DriveFileMoveIcon sx={{ fontSize: 40, color: 'blue' }} />
                  <Typography variant="h5">{docSalida}</Typography>
                  <Typography variant="subtitle1">Total Doc. Salida</Typography>
                </Box>
              </Grid>
              <Grid item xs={12} sm={6} md={3}>
                <Box
                  sx={{
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    padding: '16px',
                    textAlign: 'center',
                    boxShadow: '5px 5px 5px 1px rgba(128, 128, 128, 0.5)'
                  }}
                >
                  <AssignmentReturnedIcon sx={{ fontSize: 40, color: 'orange' }} />
                  <Typography variant="h5">{docSinEntrada}</Typography>
                  <Typography variant="subtitle1">Total Doc. Sin Entrada</Typography>
                </Box>
              </Grid>
              <Grid item xs={12} sm={6} md={3}>
                <Box
                  sx={{
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    padding: '16px',
                    textAlign: 'center',
                    boxShadow: '5px 5px 5px 1px rgba(128, 128, 128, 0.5)'
                  }}
                >
                  <GradingIcon sx={{ fontSize: 40, color: 'red' }} />
                  <Typography variant="h5">{docAll}</Typography>
                  <Typography variant="subtitle1">Total Docs</Typography>
                </Box>
              </Grid>
            </Grid>
            <Grid item xs={12} sx={{
              border: '1px solid #ccc',
              borderRadius: '8px',
              padding: '16px',
              marginTop: '24px',
              boxShadow: '5px 5px 5px 1px rgba(128, 128, 128, 0.5)'
            }}>
              <HighchartsReact highcharts={Highcharts} options={chartOptions} />
            </Grid>
            <Grid item xs={12} sx={{
              border: '1px solid #ccc',
              borderRadius: '8px',
              padding: '16px',
              marginTop: '24px',
              boxShadow: '5px 5px 5px 1px rgba(128, 128, 128, 0.5)',
              position: 'relative'  // Para permitir posicionamiento absoluto de elementos dentro
            }}>
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

              {/* Tabla de documentos */}
              <div className="ag-theme-alpine" style={{ width: '100%', margin: 'auto' }}>
                <AgGridReact
                  rowData={tableData}
                  columnDefs={columns}
                  localeText={AG_GRID_LOCALE_ES}
                  paginationPageSize={paginationPageSize}
                  pagination={true}
                  domLayout='autoHeight'
                  onGridReady={onGridReady}
                  paginationPageSizeSelector={paginationPageSizeSelector}
                />
                <style jsx="true">
                  {`
                    .ag-paging-panel .ag-paging-page-size {
                      display: none;  /* Ocultar el selector de tamaño de página por defecto */
                    }
                  `}
                </style>
              </div>
            </Grid>
          </>
        ) : (
          <Outlet />
        )}
      </Box>

      <Footer isSidebarOpen={isSidebarOpen} />
    </Box>
  );
};

export default HomePage;
