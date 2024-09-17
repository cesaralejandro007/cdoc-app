// src/components/Login.js
import React, { useState } from "react";
import { TextField, Button, Typography, Container, Alert, Box } from "@mui/material";
import useLogin from "../hooks/useAuth"; // Importa el hook personalizado

const Login = () => {
  const [cedula, setCedula] = useState("");
  const [password, setPassword] = useState("");
  const { login, error, loading } = useLogin(); // Usa el hook personalizado

  const handleSubmit = (e) => {
    e.preventDefault();
    login(cedula, password);
  };

  return (
    <Box
      display="flex"
      justifyContent="center"
      alignItems="center"
      minHeight="100vh"
      flexDirection="column"
    >
    {/* Imagen fuera del borde */}
        <img
        src="/seniat.png" // Ruta correcta si la imagen está en public/assets
        alt="Seniat"
        style={{
        width: "400px",
        height: "auto",
        marginBottom: "16px",
        }}
        />
      {/* Título fuera del borde */}
      <Typography
        variant="h4"
        component="h4"
        sx={{
          textAlign: "center",
          fontFamily: "'Inter', sans-serif", // Ajuste en la fuente
          fontWeight: "bold",
          textShadow: "3px 3px 3px rgba(0, 0, 0, 0.5)", // Agrega una sombra ligera
        }}
      >
        Control de Documentos
      </Typography>

      <Container
        component="main"
        maxWidth="xs"
        sx={{
          border: "1px solid #BEBEBE", // Borde del contenedor
          borderRadius: "8px", // Bordes redondeados
          padding: "24px", // Espaciado interno
          boxShadow: "0px 4px 12px rgba(0, 0, 0, 0.5)", // Agrega una sombra ligera
          marginTop: "16px", // Espaciado entre el título y el contenedor
        }}
      >
        {/* Título dentro del contenedor */}
        <Typography variant="h5" component="h5" gutterBottom sx={{ textAlign: "center" }}>
         Inicia Sesión
        </Typography>

        {error && <Alert severity="error">{error}</Alert>}
        
        <form onSubmit={handleSubmit} noValidate>
          <TextField
            margin="normal"
            required
            fullWidth
            id="cedula"
            label="Cédula"
            name="cedula"
            autoComplete="cedula"
            autoFocus
            value={cedula}
            onChange={(e) => setCedula(e.target.value)}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            name="password"
            label="Contraseña"
            type="password"
            id="password"
            autoComplete="current-password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
            disabled={loading}
          >
            {loading ? "Cargando..." : "Iniciar Sesión"}
          </Button>
        </form>
      </Container>
    </Box>
  );
};

export default Login;
