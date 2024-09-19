// src/components/Sidebar.js
import React, { useState } from 'react';
import { Drawer, List, ListItem, ListItemText, Collapse, ListItemIcon, Typography } from '@mui/material';
import { ExpandLess, ExpandMore, Home, Description, People, Settings, ExitToApp, Input, Cancel, History, EventNote } from '@mui/icons-material'; // Íconos adicionales
import { Link, useLocation } from 'react-router-dom';

const Sidebar = ({ open }) => {
  const [isDocumentsOpen, setIsDocumentsOpen] = useState(false);
  const [isConfigOpen, setIsConfigOpen] = useState(false);
  const location = useLocation(); // Para obtener la ruta actual

  const handleDocumentsClick = () => {
    setIsDocumentsOpen(!isDocumentsOpen);
  };

  const handleConfigClick = () => {
    setIsConfigOpen(!isConfigOpen);
  };

  // Función para saber si la opción está activa (ruta actual)
  const isActive = (path) => location.pathname === path;
  
  return (
    <Drawer
      variant="persistent"
      anchor="left"
      open={open}
      sx={{
        width: open ? '250px' : '0',
        flexShrink: 0,
        '& .MuiDrawer-paper': {
          width: open ? '250px' : '0',
          boxSizing: 'border-box',
          transition: 'width 0.3s ease',
          backgroundColor: '#263238', // Color de fondo oscuro
          color: '#ffffff', // Color de texto claro
        },
      }}
    >
      <List>
        {/* Encabezado del menú */}
        <ListItem
          sx={{
            justifyContent: 'center',
            padding: '20px 0',
            borderBottom: '1px solid rgba(255, 255, 255, 0.1)',
          }}
        >
          <Typography variant="h6" color="inherit">
            Menú
          </Typography>
        </ListItem>

        {/* Inicio */}
        <ListItem
          button
          component={Link}
          to="/home"
          sx={{
            backgroundColor: isActive('/home') ? '#1E88E5' : 'inherit', // Azul claro cuando está activa
            '&:hover': {
              backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
            }
          }}
        >
          <ListItemIcon sx={{ color: '#ffffff' }}>
            <Home />
          </ListItemIcon>
          <ListItemText primary="Inicio" sx={{ color: '#ffffff' }} />
        </ListItem>

        {/* Menú desplegable de Documentos */}
        <ListItem button onClick={handleDocumentsClick}>
          <ListItemIcon sx={{ color: '#ffffff' }}>
            <Description />
          </ListItemIcon>
          <ListItemText primary="Documentos" sx={{ color: '#ffffff' }} />
          {isDocumentsOpen ? <ExpandLess sx={{ color: '#ffffff' }} /> : <ExpandMore sx={{ color: '#ffffff' }} />}
        </ListItem>

        {/* Submenú colapsable de Documentos */}
        <Collapse in={isDocumentsOpen} timeout="auto" unmountOnExit>
          <List component="div" disablePadding sx={{ paddingLeft: 4 }}>
            <ListItem
              button
              component={Link}
              to="modules/doc-entry"
              sx={{
                backgroundColor: isActive('/home/modules/doc-entry') ? '#1E88E5' : 'inherit',
                '&:hover': {
                  backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
                }
              }}
            >
              <ListItemIcon sx={{ color: '#ffffff' }}>
                <Input />
              </ListItemIcon>
              <ListItemText primary="Doc. de entrada" sx={{ color: '#ffffff' }} />
            </ListItem>
            <ListItem
              button
              component={Link}
              to="modules/doc-exit"
              sx={{
                backgroundColor: isActive('/home/modules/doc-exit') ? '#1E88E5' : 'inherit',
                '&:hover': {
                  backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
                }
              }}
            >
              <ListItemIcon sx={{ color: '#ffffff' }}>
                <ExitToApp />
              </ListItemIcon>
              <ListItemText primary="Doc. de salida" sx={{ color: '#ffffff' }} />
            </ListItem>
            <ListItem
              button
              component={Link}
              to="modules/doc-without-entry"
              sx={{
                backgroundColor: isActive('/home/modules/doc-without-entry') ? '#1E88E5' : 'inherit',
                '&:hover': {
                  backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
                }
              }}
            >
              <ListItemIcon sx={{ color: '#ffffff' }}>
                <Cancel />
              </ListItemIcon>
              <ListItemText primary="Doc. sin entrada" sx={{ color: '#ffffff' }} />
            </ListItem>
          </List>
        </Collapse>

        {/* Menú desplegable de Configuración */}
        <ListItem button onClick={handleConfigClick}>
          <ListItemIcon sx={{ color: '#ffffff' }}>
            <Settings />
          </ListItemIcon>
          <ListItemText primary="Sistema" sx={{ color: '#ffffff' }} />
          {isConfigOpen ? <ExpandLess sx={{ color: '#ffffff' }} /> : <ExpandMore sx={{ color: '#ffffff' }} />}
        </ListItem>

        {/* Submenú colapsable de Configuración */}
        <Collapse in={isConfigOpen} timeout="auto" unmountOnExit>
          <List component="div" disablePadding sx={{ paddingLeft: 4 }}>
            <ListItem
              button
              component={Link}
              to="modules/log-user"
              sx={{
                backgroundColor: isActive('/home/modules/log-user') ? '#1E88E5' : 'inherit',
                '&:hover': {
                  backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
                }
              }}
            >
              <ListItemIcon sx={{ color: '#ffffff' }}>
                <History />
              </ListItemIcon>
              <ListItemText primary="Bitacora de usuario" sx={{ color: '#ffffff' }} />
            </ListItem>
            <ListItem
              button
              component={Link}
              to="modules/log-system"
              sx={{
                backgroundColor: isActive('/home/modules/system-log') ? '#1E88E5' : 'inherit',
                '&:hover': {
                  backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
                }
              }}
            >
              <ListItemIcon sx={{ color: '#ffffff' }}>
                <EventNote />
              </ListItemIcon>
              <ListItemText primary="Bitacora del sistema" sx={{ color: '#ffffff' }} />
            </ListItem>
          </List>
        </Collapse>

        {/* Usuarios */}
        <ListItem
          button
          component={Link}
          to="/home/modules/users"
          sx={{
            backgroundColor: isActive('/home/modules/users') ? '#1E88E5' : 'inherit',
            '&:hover': {
              backgroundColor: '#1E88E5', // Color al pasar el ratón por encima
            }
          }}
        >
          <ListItemIcon sx={{ color: '#ffffff' }}>
            <People />
          </ListItemIcon>
          <ListItemText primary="Usuarios" sx={{ color: '#ffffff' }} />
        </ListItem>
      </List>
    </Drawer>
  );
};

export default Sidebar;
