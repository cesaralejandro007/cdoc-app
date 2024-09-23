import React, { createContext, useState, useEffect } from 'react';

// Crea el contexto
export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true); // Estado para controlar la carga inicial

  // Recupera el estado del usuario de localStorage al montar la aplicación
  useEffect(() => {
    const storedSession = localStorage.getItem('session'); // Cambiado de 'user' a 'session'
    if (storedSession) {
      const parsedSession = JSON.parse(storedSession);
      setUser(parsedSession); // Almacena el objeto completo
    }
    setLoading(false); // Marca como completada la recuperación de los datos
  }, []);

  // Función para iniciar sesión y almacenar el usuario
  const login_session = (userData) => {
    const { user, token } = userData;

    // Crear una copia del objeto de usuario sin la contraseña
    const { contrasena, ...userWithoutPassword } = user;

    // Almacenar un nuevo objeto que contenga el usuario sin la contraseña y el token
    const sessionData = {
      user: userWithoutPassword,
      token: token,
    };

    // Guardar en localStorage
    localStorage.setItem('session', JSON.stringify(sessionData));

    setUser(sessionData); // Actualiza el estado del usuario
  };

  // Función para cerrar sesión
  const deleteData = () => {
    setUser(null);
    localStorage.removeItem('session'); // Elimina la sesión de localStorage
  };

  return (
    <AuthContext.Provider value={{ user, login_session, deleteData, loading }}>
      {!loading && children} {/* Solo renderiza los hijos si la carga ha finalizado */}
    </AuthContext.Provider>
  );
};
