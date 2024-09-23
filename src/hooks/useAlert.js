// src/hooks/useAlert.js
import Swal from 'sweetalert2';

export const useAlert = () => {
  const showAlert = async (title, text, icon = 'info', showConfirmButton = true) => {
    await Swal.fire({
      title,
      text,
      icon,
      showConfirmButton: showConfirmButton, // Controla si se muestra el botón de confirmación
      showCancelButton: false, // No mostrar botón de cancelar
      timer: showConfirmButton ? undefined : 2000, // Cierra la alerta automáticamente si no hay botón
      timerProgressBar: true, // Muestra barra de progreso si hay un temporizador
    });
  };

  return { showAlert };
};
