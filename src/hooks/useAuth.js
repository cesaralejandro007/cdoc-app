// src/hooks/useLogin.js
import { useContext, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAlert } from './useAlert'; // Importar el hook de alertas
import { AuthContext } from '../context/AuthContext';

const useLogin = () => {
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const { login_session, deleteData } = useContext(AuthContext);
  const navigate = useNavigate();
  const { showAlert } = useAlert(); // Usar el hook de alertas

  const login = async (cedula, clave) => {
    setLoading(true);
    setError("");
  
    try {
      const response = await fetch("http://localhost/cdoc-app/api/auth/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ cedula, clave }),
      });
  
      if (!response.ok) {
        const errorMessage = await response.json();
        setError(errorMessage.message || "Error en la solicitud.");
        return;
      }
  
      const data = await response.json();

      // Verificar si la respuesta indica un inicio de sesión exitoso
      if (data.OK && data.code === 200 && data.message === "Inicio de sesión exitoso") {
        const token = data.data.token;
        const user = data.data.usuario;
  
        login_session({ user, token });

        // Mostrar alerta de inicio de sesión exitoso
        await showAlert(data.message, "Redirigiendo al menú de inicio...", "success", false);
        navigate("/home");
      } else {
        setError(data.message || "Error desconocido.");
      }
    } catch (err) {
      console.error("Error de conexión:", err);
      setError("Error al conectar con el servidor.");
      await showAlert('Error', "Error al conectar con el servidor.", 'error', false);
    } finally {
      setLoading(false);
    }
  };

  const logout = () => {
    navigate("/login");
    deleteData();
  };

  return {
    login,
    logout,
    error,
    loading,
  };
};

export default useLogin;
