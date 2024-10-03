import { useState, useEffect, useContext, useRef } from 'react';
import { AuthContext } from '../context/AuthContext';

export const useFetch = (url, method = 'GET', body = null, headers = {}, shouldFetch = true) => {
  const [data, setData] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);
  const { user } = useContext(AuthContext);

  // useRef para mantener una referencia estable de headers y body
  const headersRef = useRef({
    Authorization: `Bearer ${user.token}`,
    'Content-Type': 'application/json',
    ...headers,
  });

  const bodyRef = useRef(body ? JSON.stringify(body) : null);

  useEffect(() => {
    const fetchData = async () => {
      if (!shouldFetch || !url) return; // Salir si no debería realizar la petición

      setIsLoading(true);
      try {
        const response = await fetch(url, {
          method,
          headers: headersRef.current,
          body: bodyRef.current,
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
  }, [url, method, shouldFetch, user.token]); // Dependencias necesarias

  return { data, setData, isLoading, error };
};
