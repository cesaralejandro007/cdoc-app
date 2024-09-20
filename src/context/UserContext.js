// src/context/UserContext.js
import { createContext, useState } from 'react';

// Crea el contexto para el usuario
export const UserContext = createContext(null);

export const UserProvider = ({ children }) => {
  const [user, setUser] = useState(null);

  const saveUser = (userData) => {
    setUser(userData); // Guarda los datos del usuario solo en memoria
  };

  const logout = () => {
    setUser(null); // Limpia los datos del usuario al cerrar sesión
  };

  return (
    <UserContext.Provider value={{ user, saveUser, logout }}>
      {children}
    </UserContext.Provider>
  );
};
