// src/components/Login.js
import React, { useState } from "react";
import { TextField, Button, Typography, Container, Alert, Box } from "@mui/material";
import useLogin from "../hooks/useAuth"; /// Asegúrate de que la ruta esté correcta

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
    >
      <img
        src="/seniat.png"
        alt="Seniat"
        style={{ width: "400px", height: "auto", marginBottom: "16px" }}
      />
      <Typography
        variant="h4"
        component="h4"
        sx={{
          textAlign: "center",
          fontFamily: "'Inter', sans-serif",
          fontWeight: "bold",
          textShadow: "3px 3px 3px rgba(0, 0, 0, 0.5)",
        }}
      >
        Control de Documentos
      </Typography>

      <Container
        component="main"
        maxWidth="xs"
        sx={{
          width: "400px",
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
