// hooks/useHomePageData.js
import { useState, useEffect, useContext, useRef } from 'react';
import { useNavigate } from 'react-router-dom';
import { AuthContext } from '../context/AuthContext';
import { useAlert } from './useAlert';

export const useHomePageData = () => {
  const { user, loading } = useContext(AuthContext);
  const [reportData, setReportData] = useState(null);
  const [docEntrada, setDocEntrada] = useState(0);
  const [docSinEntrada, setDocSinEntrada] = useState(0);
  const [docSalida, setDocSalida] = useState(0);
  const [docAll, setDocAll] = useState(0);
  const [isLoading, setIsLoading] = useState(true);
  const navigate = useNavigate();
  const { showAlert } = useAlert();
  const hasFetchedData = useRef(false); // Bandera para evitar llamadas repetitivas

  // Este useEffect es para redirigir al usuario si no está autenticado
  useEffect(() => {
    if (!loading && !user) {
      navigate('/login');
    }
  }, [user, loading, navigate]);

  useEffect(() => {
    // Ejecutar solo si `user` está definido, tiene un token, y aún no se han cargado los datos
    if (!user || !user.token || hasFetchedData.current) {
      setIsLoading(false);
      return;
    }

    const fetchData = async () => {
      try {
        hasFetchedData.current = true; // Marcar que ya se han cargado los datos
        // Función para realizar las llamadas a las diferentes APIs
        const fetchFromApi = async (url) => {
          const response = await fetch(url, {
            method: 'POST',
            headers: {
              Authorization: `Bearer ${user.token}`,
              'Content-Type': 'application/json',
            },
          });

          if (!response.ok) {
            if (response.status === 401) {
              const errorData = await response.json();
              await showAlert('Error', errorData.message || 'Token no válido. Inicie sesión nuevamente.', 'error', true);
              navigate('/login');
            }
            return null;
          }

          const data = await response.json();
          return data.total || 0; // Asume que cada respuesta tiene un campo `total`
        };

        // Llamadas a las diferentes APIs en paralelo
        const [totalEntrada, totalAll, totalSinEntrada, totalSalida] = await Promise.all([
          fetchFromApi('http://localhost/cdoc-app/api/home/get-doc-entrada'),
          fetchFromApi('http://localhost/cdoc-app/api/home/get-doc-all'),
          fetchFromApi('http://localhost/cdoc-app/api/home/get-doc-sin-entrada'),
          fetchFromApi('http://localhost/cdoc-app/api/home/get-doc-salida'),
        ]);

        // Guardar los datos obtenidos
        setDocAll(totalAll);
        setDocEntrada(totalEntrada);
        setDocSinEntrada(totalSinEntrada);
        setDocSalida(totalSalida);

        // Obtener reporte general si es necesario
        const reportResponse = await fetch('http://localhost/cdoc-app/api/home/report', {
          method: 'POST',
          headers: {
            Authorization: `Bearer ${user.token}`,
            'Content-Type': 'application/json',
          },
        });

        if (reportResponse.ok) {
          const reportData = await reportResponse.json();
          setReportData(reportData);
        }

      } catch (error) {
        console.error('Error al obtener los datos de la API', error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, [user, showAlert, navigate]); // `navigate` no debería cambiar, pero solo depende de `user` y `showAlert`

  return { reportData, docAll, docEntrada, docSinEntrada, docSalida, isLoading, user, loading };
};
