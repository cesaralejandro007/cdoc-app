import React, { useState, useMemo } from 'react';
import { Outlet, useLocation } from 'react-router-dom';
import { Box, CssBaseline, CircularProgress, Grid, Typography } from '@mui/material';
import { AgGridReact } from 'ag-grid-react';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { useHomePageData } from '../hooks/useReportData';
import { getColumns, getTableData, AG_GRID_LOCALE_ES, calculateTableHeight } from '../utils/tableConfig';
import Sidebar from './sidebar/Sidebar';
import Header from './header/Header';
import Footer from './footer/Footer';
import DocumentScannerIcon from '@mui/icons-material/DocumentScanner';
import ArrowDownwardIcon from '@mui/icons-material/ArrowDownward';
import ArrowUpwardIcon from '@mui/icons-material/ArrowUpward';
import GradingIcon from '@mui/icons-material/Grading';


const HomePage = () => {
  const { reportData, docAll, docEntrada, docSinEntrada, docSalida, isLoading } = useHomePageData();
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const [paginationPageSize, setPaginationPageSize] = useState(6);
  const columns = getColumns();
  const tableData = reportData ? getTableData(reportData) : [];
  const location = useLocation();
  const paginationPageSizeSelector = [6, 12, 24, 48, 100];

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  const tableHeight = useMemo(() => calculateTableHeight(paginationPageSize), [paginationPageSize]);

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
      <Sidebar open={isSidebarOpen} sx={{ position: 'fixed', width: isSidebarOpen ? '250px' : '0', transition: 'width 0.3s' }} />
      
      <Box
        sx={{
          flexGrow: 1,
          marginLeft: isSidebarOpen ? '250px' : '0',
          transition: 'margin-left 0.3s',
          padding: '30px',
          marginTop: '64px',
          marginBottom: '64px',
          width: isSidebarOpen ? 'calc(100% - 250px)' : '100%',
          overflowX: 'hidden',
        }}
      >
        {location.pathname === '/home' ? (
          <>
            <Grid container spacing={3} justifyContent="center">
              <Grid item xs={12} md={3}>
                <Box sx={{ border: '1px solid #ccc', borderRadius: '8px', padding: '16px', textAlign: 'center' }}>
                  <DocumentScannerIcon sx={{ fontSize: 40, color: 'green' }} />
                  <Typography variant="h5">{docEntrada}</Typography>
                  <Typography variant="subtitle1">Total Doc. Entrada</Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box sx={{ border: '1px solid #ccc', borderRadius: '8px', padding: '16px', textAlign: 'center' }}>
                  <ArrowUpwardIcon sx={{ fontSize: 40, color: 'blue' }} />
                  <Typography variant="h5">{docSalida}</Typography>
                  <Typography variant="subtitle1">Total Doc. Salida</Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box sx={{ border: '1px solid #ccc', borderRadius: '8px', padding: '16px', textAlign: 'center' }}>
                  <ArrowDownwardIcon sx={{ fontSize: 40, color: 'orange' }} />
                  <Typography variant="h5">{docSinEntrada}</Typography>
                  <Typography variant="subtitle1">Total Doc. Sin Entrada</Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box sx={{ border: '1px solid #ccc', borderRadius: '8px', padding: '16px', textAlign: 'center' }}>
                  <GradingIcon sx={{ fontSize: 40, color: 'red' }} />
                  <Typography variant="h5">{docAll}</Typography>
                  <Typography variant="subtitle1">Total Docs</Typography>
                </Box>
              </Grid>
            </Grid>

            <Grid item xs={12}>
              <Typography variant="h6" component="h2" gutterBottom>
                Reporte de Documentos
              </Typography>
              <div className="ag-theme-alpine" style={{ height: tableHeight, width: '100%', overflow: 'auto' }}>
                <AgGridReact
                  rowData={tableData}
                  columnDefs={columns}
                  localeText={AG_GRID_LOCALE_ES}
                  paginationPageSize={paginationPageSize}
                  pagination={true}
                  paginationPageSizeSelector={paginationPageSizeSelector}
                  onPaginationChanged={(event) => setPaginationPageSize(event.api.paginationGetPageSize())}
                  paginationAutoPageSize={false}
                />
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
