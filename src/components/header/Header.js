// src/components/Header.js
import React, { useState } from 'react';
import { AppBar, Toolbar, IconButton, Typography, Menu, MenuItem } from '@mui/material';
import MenuIcon from '@mui/icons-material/Menu';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import useAuth from '../../hooks/useAuth'; // Importa el hook useAuth

const Header = ({ onToggleSidebar, isSidebarOpen }) => {
  const [anchorEl, setAnchorEl] = useState(null);
  const { logout } = useAuth(); // Obtiene la función logout del hook

  const handleMenuClick = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleMenuClose = () => {
    setAnchorEl(null);
  };

  const handleChangePassword = () => {
    // Aquí puedes manejar la redirección o la lógica para cambiar contraseña
    console.log("Cambiar contraseña");
    handleMenuClose();
  };

  const handleLogout = () => {
    logout(); // Llama a la función logout del hook
    handleMenuClose();
  };

  return (
    <AppBar
      position="fixed"
      sx={{
        transition: 'margin-left 0.3s',
        marginLeft: isSidebarOpen ? '250px' : '0',
        width: isSidebarOpen ? 'calc(100% - 250px)' : '100%',
      }}
    >
      <Toolbar>
        {/* Botón de menú siempre visible */}
        <IconButton
          edge="start"
          color="inherit"
          aria-label="menu"
          onClick={onToggleSidebar}
          sx={{ marginRight: '16px' }}
        >
          <MenuIcon />
        </IconButton>
        <Typography variant="h6" noWrap sx={{ flexGrow: 1 }}>
          Control de Documentos
        </Typography>

        {/* Icono de usuario con menú desplegable */}
        <IconButton
          edge="end"
          color="inherit"
          aria-controls="simple-menu"
          aria-haspopup="true"
          onClick={handleMenuClick}
        >
          <AccountCircleIcon />
        </IconButton>

        <Menu
          id="simple-menu"
          anchorEl={anchorEl}
          open={Boolean(anchorEl)}
          onClose={handleMenuClose}
        >
          <MenuItem onClick={handleChangePassword}>Cambiar Contraseña</MenuItem>
          <MenuItem onClick={handleLogout}>Salir</MenuItem>
        </Menu>
      </Toolbar>
    </AppBar>
  );
};

export default Header;
