// src/hooks/useLogin.js
import { useContext, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';
import { AuthContext } from '../context/AuthContext'; // Importa el UserContext

const useLogin = () => {
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const { login_session, deleteData } = useContext(AuthContext); // Usa el contexto
  const navigate = useNavigate();

  const login = async (cedula, clave) => {
    setLoading(true);
    setError("");

    try {
      const response = await fetch("http://localhost/cdoc-app/api/auth/login", {
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
        const user = data.data.usuario;

        // Guarda los datos del usuario en el contexto sin localStorage
        login_session({user, token });

        // Mostrar alerta de inicio de sesión exitoso
        Swal.fire({
          title: data.message,
          text: "Redirigiendo al menú de inicio...",
          icon: "success",
          timer: 2000, // Tiempo antes de redirigir
          showConfirmButton: false,
        }).then(() => {
          // Redirige al home después de que la alerta se cierre
          navigate("/home");
        });
      } else {
        setError(data.message || "Error desconocido.");
      }
    } catch (err) {
      console.error("Error de conexión:", err);
      setError("Error al conectar con el servidor.");
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
