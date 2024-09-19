// src/hooks/useLogin.js
import { useState } from "react";
import { useNavigate } from "react-router-dom"; // Importa useNavigate

const useLogin = () => {
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate(); // Usa useNavigate para la navegación

  const login = async (cedula, clave) => {
    setLoading(true);
    setError("");
  
    try {
      const response = await fetch("https://localhost/cdoc-app/api/auth/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          cedula,
          clave,
        }),
      });
  
      if (!response.ok) {
        const errorMessage = await response.json();
        setError(errorMessage.message || "Error en la solicitud.");
        return;
      }
  
      const data = await response.json();
  
      if (data.OK) {
        const token = data.data.token;
        localStorage.setItem("token", token);
        navigate("/home");
      } else {
        setError(data.message || "Error desconocido.");
      }
    } catch (err) {
      console.error("Error de conexión:", err); // Registra el error en la consola para más detalles
      setError("Error al conectar con el servidor.");
    } finally {
      setLoading(false);
    }
  };
  
  const logout = () => {
    localStorage.removeItem("token");
    navigate("/"); // Navega a la página de inicio sin recargar
  };

  return {
    login,
    logout,
    error,
    loading,
  };
};

export default useLogin;
