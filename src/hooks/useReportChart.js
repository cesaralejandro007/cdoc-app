import { useMemo } from "react";

const useChartOptions = (reportData) => {
  // Configuración del gráfico
  return useMemo(() => {
    if (!reportData) return {};

    const meses = Object.keys(reportData.todos);
    const entradaData = meses.map(mes => reportData.entrada[mes] || 0);
    const salidaData = meses.map(mes => reportData.salida[mes] || 0);
    const sinEntradaData = meses.map(mes => reportData.sin_entrada[mes] || 0);
    const todosData = meses.map(mes => reportData.todos[mes].cantidad || 0);

    return {
      chart: {
        type: 'line' // Puedes cambiar a 'bar' si prefieres barras
      },
      title: {
        text: 'Reporte de Documentos por Mes'
      },
      xAxis: {
        categories: meses // Los meses serán las categorías en el eje X
      },
      yAxis: {
        title: {
          text: 'Cantidad de Documentos'
        },
        max: 800, // Establecer el rango máximo en 800
        min: 0
      },
      series: [
        {
          name: 'Doc. Entrada',
          data: entradaData,
          color: 'green'
        },
        {
          name: 'Doc. Salida',
          data: salidaData,
          color: 'blue'
        },
        {
          name: 'Doc. Sin Entrada',
          data: sinEntradaData,
          color: 'orange'
        },
        {
          name: 'Todos los Documentos',
          data: todosData, // Datos de 'todos'
          color: 'red'
        }
      ]
    };
  }, [reportData]);
};

export default useChartOptions;
