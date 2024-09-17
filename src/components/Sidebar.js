// src/components/Sidebar.js
import React, { useState } from 'react';
import { Drawer, List, ListItem, ListItemText, Collapse, ListItemIcon } from '@mui/material';
import { ExpandLess, ExpandMore } from '@mui/icons-material'; // Iconos para la flecha
import { Link } from 'react-router-dom'; // Para los links de navegación

const Sidebar = ({ open }) => {
  const [isDocumentsOpen, setIsDocumentsOpen] = useState(false); // Estado para manejar el colapso del menú Documentos
  const [isConfigOpen, setIsConfigOpen] = useState(false);
  
  const handleConfigClick = () => {
    setIsConfigOpen(!isConfigOpen); // Cambia el estado cuando se haga clic
  };

  const handleDocumentsClick = () => {
    setIsDocumentsOpen(!isDocumentsOpen); // Cambia el estado cuando se haga clic
  };


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
        },
      }}
    >
      <List>
        <ListItem button>
          <ListItemText primary="Inicio" />
        </ListItem>
        {/* Menú desplegable de Documentos */}
        <ListItem button onClick={handleDocumentsClick}>
          <ListItemText primary="Documentos" />
          <ListItemIcon>
            {isDocumentsOpen ? <ExpandLess /> : <ExpandMore />}
          </ListItemIcon>
        </ListItem>

        {/* Submenú colapsable */}
        <Collapse in={isDocumentsOpen} timeout="auto" unmountOnExit>
          <List component="div" disablePadding>
            <ListItem button component={Link} to="modules/doc-entry">
              <ListItemText primary="Doc. de entrada" />
            </ListItem>
            <ListItem button component={Link} to="modules/doc-exit">
              <ListItemText primary="Doc. de salida" />
            </ListItem>
            <ListItem button component={Link} to="modules/doc-without-entry">
              <ListItemText primary="Doc. sin entrada" />
            </ListItem>
          </List>
        </Collapse>

        {/* Menú desplegable de Config */}
        <ListItem button onClick={handleConfigClick}>
          <ListItemText primary="Sistema" />
          <ListItemIcon>
            {isConfigOpen ? <ExpandLess /> : <ExpandMore />}
          </ListItemIcon>
        </ListItem>

        {/* Submenú colapsable */}
        <Collapse in={isConfigOpen} timeout="auto" unmountOnExit>
          <List component="div" disablePadding>
            <ListItem button component={Link} to="modules/DocEntry">
              <ListItemText primary="Bitacora de usuario" />
            </ListItem>
            <ListItem button component={Link} to="modules/DocExit">
              <ListItemText primary="Bitacora del sistema" />
            </ListItem>
          </List>
        </Collapse>

        <ListItem button>
          <ListItemText primary="Usuarios" />
        </ListItem>
      </List>
    </Drawer>
  );
};

export default Sidebar;
