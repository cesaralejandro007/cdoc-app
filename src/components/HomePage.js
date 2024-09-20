import React, { useState, useEffect, useContext } from 'react';
import { Outlet } from 'react-router-dom';
import { Box, CssBaseline } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { AuthContext } from '../context/AuthContext';
import Sidebar from './sidebar/Sidebar';
import Header from './header/Header';
import Footer from './footer/Footer';

const HomePage = () => {
  const { user, loading } = useContext(AuthContext); // Accede al usuario y al estado de carga desde el contexto
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const navigate = useNavigate();

  // Verificar si hay un usuario autenticado
  useEffect(() => {
    if (!loading && !user) {
      navigate('/login'); // Redirige si no hay usuario y la carga ya ha terminado
    }
  }, [user, loading, navigate]);

  // Control de la apertura/cierre del sidebar
  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  // Si la aplicación aún está cargando, puedes mostrar un loader o simplemente null
  if (loading) {
    return <div>Cargando...</div>; // Mostrar un mensaje de carga
  }

  return (
    <Box sx={{ display: 'flex', minHeight: '100vh', flexDirection: 'column' }}>
      <CssBaseline />
      <Header onToggleSidebar={toggleSidebar} isSidebarOpen={isSidebarOpen} />
      <Sidebar open={isSidebarOpen} />
      <Box
        component="main"
        sx={{
          flexGrow: 1,
          marginLeft: isSidebarOpen ? '250px' : '0', 
          transition: 'margin-left 0.3s', 
          padding: '20px',
          marginTop: '64px',
        }}
      >
        <Outlet />
      </Box>
      <Footer isSidebarOpen={isSidebarOpen} />
    </Box>
  );
};

export default HomePage;
