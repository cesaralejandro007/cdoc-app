// src/hooks/useLogin.js
import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom"; // Importa useNavigate

const useLogin = () => {
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate(); // Usa useNavigate para la navegación

  const login = async (email, password) => {
    setLoading(true);
    setError("");
    try {
      const response = await axios.post("http://localhost/api/login", {
        email,
        password,
      });
      const token = response.data.token;
      localStorage.setItem("token", token);

      navigate("/menu"); // Navega a /menu sin recargar la página
    } catch (err) {
      setError("Credenciales incorrectas. Inténtalo de nuevo.");
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
