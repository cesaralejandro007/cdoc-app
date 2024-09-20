// src/components/HomePage.js
import React, {useState,useEffect,useContext} from 'react';
import { Outlet } from 'react-router-dom';
import { Box, CssBaseline } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { UserContext } from '../context/UserContext';
import Sidebar from './sidebar/Sidebar';
import Header from './header/Header';
import Footer from './footer/Footer';

const HomePage = () => {
  const { user, logout } = useContext(UserContext); // Accede al usuario y logout
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    if (!user) {
      navigate('/login'); // Redirige a la página de login si no hay usuario
    }
  }, [user, navigate]);
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
