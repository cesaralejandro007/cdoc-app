import { useState, useEffect, useContext } from 'react';
import { AuthContext } from '../context/AuthContext';

export const useFetch = (url, method = 'GET', body = null, headers = {}, shouldFetch = true) => {
  const [data, setData] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);
  const { user } = useContext(AuthContext);

  useEffect(() => {
    const fetchData = async () => {
      if (!shouldFetch || !url) return; // Salir si no debería realizar la petición
  
      setIsLoading(true);
      try {
        const response = await fetch(url, {
          method,
          headers: {
            Authorization: `Bearer ${user.token}`,
            'Content-Type': 'application/json',
            ...headers, // Permite agregar headers personalizados
          },
          body: body ? JSON.stringify(body) : null,
        });
  
        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Error en la solicitud');
        }
  
        const result = await response.json();
        setData(result);
      } catch (err) {
        setError(err.message);
      } finally {
        setIsLoading(false);
      }
    };
  
    fetchData();
  }, [url, user.token, shouldFetch]); // Solo dependencias necesarias
  

  return { data, isLoading, error };
};
