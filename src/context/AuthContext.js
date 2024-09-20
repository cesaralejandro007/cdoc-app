import React, { createContext, useState, useEffect } from 'react';

// Crea el contexto
export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true); // Estado para controlar la carga inicial

  // Recupera el estado del usuario de localStorage al montar la aplicación
  useEffect(() => {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      setUser(JSON.parse(storedUser));
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
  
    setUser(userWithoutPassword); // Actualiza el estado del usuario
  };
  
  
  // Función para cerrar sesión
  const deleteData = () => {
    setUser(null);
    localStorage.removeItem('user'); // Elimina el usuario de localStorage
  };

  return (
    <AuthContext.Provider value={{ user, login_session, deleteData, loading }}>
      {!loading && children} {/* Solo renderiza los hijos si la carga ha finalizado */}
    </AuthContext.Provider>
  );
};
