// src/components/HomePage.js
import React, { useState } from 'react';
import { Outlet } from 'react-router-dom';
import { Box, CssBaseline } from '@mui/material';
import Sidebar from './sidebar/Sidebar';
import Header from './header/Header';
import Footer from './footer/Footer';

const HomePage = () => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  return (
    <Box sx={{ display: 'flex', minHeight: '100vh', flexDirection: 'column' }}>
      <CssBaseline />
      <Header onToggleSidebar={toggleSidebar} isSidebarOpen={isSidebarOpen} />
      <Sidebar open={isSidebarOpen} />
      <Box
        component="main"
        sx={{
          flexGrow: 1,
          marginLeft: isSidebarOpen ? '250px' : '0', // Ajusta el margen principal
          transition: 'margin-left 0.3s', // Transición suave
          padding: '20px',
          marginTop: '64px', // Ajuste según la altura del header
        }}
      >
        <Outlet />
      </Box>
      <Footer isSidebarOpen={isSidebarOpen} />
    </Box>
  );
};

export default HomePage;
