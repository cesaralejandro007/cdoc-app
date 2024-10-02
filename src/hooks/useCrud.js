import { useState, useEffect } from 'react';
import { useFetch } from '../hooks/useRequest';
import Swal from 'sweetalert2';

export const useCrud = (url) => {
  const { data, isLoading, error } = useFetch(url);
  const [items, setItems] = useState([]);

  useEffect(() => {
    if (data && data.documentos) {
      setItems(data.documentos); // Aquí llenas el estado 'items' con los documentos
    }
  }, [data]);

  // Función para editar un documento
  const handleEdit = (id) => {
    // Encuentra el documento por su id
    const documentToEdit = items.find(item => item.id_documento === id); 

    if (documentToEdit) {
      // Llamamos a SweetAlert para mostrar el modal
      Swal.fire({
        title: 'Editar Documento',
        html: `
          <label>Entrada / Sin entrada:</label>
          <select id="estatus" class="swal2-input">
            <option value="1" ${documentToEdit.estatus === '1' ? 'selected' : ''}>Entrada</option>
            <option value="0" ${documentToEdit.estatus === '0' ? 'selected' : ''}>Sin entrada</option>
          </select>
          <label>Nº de Documento:</label>
          <input id="numeroDocumento" type="text" class="swal2-input" value="${documentToEdit.numero_doc}" />
          <label>Fecha de entrada:</label>
          <input id="fechaEntrada" type="date" class="swal2-input" value="${documentToEdit.fecha_entrada}" />
          <label>Descripción del Documento:</label>
          <textarea id="descripcion" class="swal2-input">${documentToEdit.descripcion}</textarea>
        `,
        focusConfirm: false,
        preConfirm: () => {
          return {
            estatus: document.getElementById('estatus').value,
            numeroDocumento: document.getElementById('numeroDocumento').value,
            fechaEntrada: document.getElementById('fechaEntrada').value,
            descripcion: document.getElementById('descripcion').value
          };
        }
      }).then((result) => {
        if (result.isConfirmed) {
          handleSave({ ...documentToEdit, ...result.value });
        }
      });
    }
  };

  // Función para guardar los cambios del documento editado
  const handleSave = (updatedDocument) => {
    setItems(items.map(item => (item.id_documento === updatedDocument.id_documento ? updatedDocument : item)));
  };

  // Función para eliminar un documento
  const handleDelete = (id) => {
    setItems(items.filter(item => item.id_documento !== id));
  };

  // Función para migrar un documento
  const handleMigrate = (id) => {
    console.log(`Migrar documento con ID: ${id}`);
  };

  return {
    items,
    data,
    isLoading,
    error,
    handleEdit,
    handleSave,
    handleDelete,
    handleMigrate
  };
};
