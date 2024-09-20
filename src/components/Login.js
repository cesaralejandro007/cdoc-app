// src/components/Login.js
import React, { useState } from "react";
import { TextField, Button, Typography, Container, Alert, Box } from "@mui/material";
import useLogin from "../hooks/useAuth"; // Asegúrate de que la ruta esté correcta

const Login = () => {
  const [cedula, setCedula] = useState("");
  const [password, setPassword] = useState("");
  const { login, error, loading } = useLogin();

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
      sx={{
        padding: 2, // Añade un padding para pantallas pequeñas
      }}
    >
      {/* Imagen responsiva */}
      <img
        src="/seniat.png"
        alt="Seniat"
        style={{
          maxWidth: "100%", // Asegura que la imagen no se desborde
          height: "auto",    // Mantiene la proporción
          marginBottom: "16px",
        }}
      />

      {/* Título */}
      <Typography
        variant="h4"
        component="h4"
        sx={{
          textAlign: "center",
          fontFamily: "'Inter', sans-serif",
          fontWeight: "bold",
          textShadow: "3px 3px 3px rgba(0, 0, 0, 0.5)",
          marginBottom: "16px", // Ajuste para separar el título del formulario
        }}
      >
        Control de Documentos
      </Typography>

      {/* Contenedor del formulario */}
      <Container
        component="main"
        maxWidth="xs"
        sx={{
          width: { xs: "100%", sm: "400px" }, // Full width en pantallas pequeñas y 400px en mayores
          border: "1px solid #BEBEBE",
          borderRadius: "8px",
          padding: "24px",
          boxShadow: "0px 4px 12px rgba(0, 0, 0, 0.5)",
          marginTop: "16px",
        }}
      >
        <Typography variant="h5" component="h5" gutterBottom sx={{ textAlign: "center" }}>
          Inicia Sesión
        </Typography>

        {error && <Alert severity="error">{error}</Alert>}

        <form onSubmit={handleSubmit} noValidate>
          {/* Campo de cédula */}
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

          {/* Campo de contraseña */}
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

          {/* Botón de inicio de sesión */}
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
            disabled={loading}
            sx={{
              mt: 2, // Añade margen superior al botón
            }}
          >
            {loading ? "Cargando..." : "Iniciar Sesión"}
          </Button>
        </form>
      </Container>
    </Box>
  );
};

export default Login;
