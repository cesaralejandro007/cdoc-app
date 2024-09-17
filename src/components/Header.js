// src/components/Header.js
import React from 'react';
import { AppBar, Toolbar, IconButton, Typography } from '@mui/material';
import MenuIcon from '@mui/icons-material/Menu';

const Header = ({ onToggleSidebar, isSidebarOpen }) => {
  return (
    <AppBar
      position="fixed"
      sx={{
        transition: 'margin-left 0.3s',
        marginLeft: isSidebarOpen ? '250px' : '0', // Ajuste de margen del header según el estado del menú
        width: isSidebarOpen ? 'calc(100% - 250px)' : '100%', // Ajuste del ancho según el estado del menú
      }}
    >
      <Toolbar>
        {/* Botón de menú siempre visible */}
        <IconButton
          edge="start"
          color="inherit"
          aria-label="menu"
          onClick={onToggleSidebar}
          sx={{
            marginRight: '16px',
          }}
        >
          <MenuIcon />
        </IconButton>
        <Typography variant="h6" noWrap>
          Control de Documentos
        </Typography>
      </Toolbar>
    </AppBar>
  );
};

export default Header;
