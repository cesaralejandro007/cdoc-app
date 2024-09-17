// src/components/Footer.js
import React from 'react';
import { Box, Typography } from '@mui/material';

const Footer = ({ isSidebarOpen }) => {
  return (
    <Box
      component="footer"
      sx={{
        width: isSidebarOpen ? 'calc(100% - 250px)' : '100%', // Ajusta el ancho del footer
        marginLeft: isSidebarOpen ? '250px' : '0', // Ajusta el margen del footer
        transition: 'margin-left 0.3s', // Transición suave
        padding: '16px',
        backgroundColor: '#f4f4f4',
        borderTop: '1px solid #ddd',
        textAlign: 'center',
        position: 'fixed',
        bottom: 0,
      }}
    >
      <Typography variant="body2">
        &copy; 2024 Control de Documentos. Todos los derechos reservados.
      </Typography>
    </Box>
  );
};

export default Footer;
