import { useContext } from 'react';
import { useFetch } from '../hooks/useRequest';
import { useAlert } from '../hooks/useAlert'; // Importa tu hook de alertas
import { AuthContext } from '../context/AuthContext';
import { TextField,Autocomplete } from '@mui/material';
import { createRoot } from 'react-dom/client';
import Swal from 'sweetalert2';


const showEditAlert = async (documento, user) => {
  // Obtener tipos de remitentes
  const ResNombreRem = await fetch("http://localhost/cdoc-app/api/documents/sender-type", {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${user.token}`,
    },
  });

  if (!ResNombreRem.ok) {
    const errorData = await ResNombreRem.json();
    throw new Error(errorData.message || 'Error al obtener tipos de remitente');
  }
  const tiposRemitentes = await ResNombreRem.json();

  // Obtener tipos de documentos
  const RestipoDoc = await fetch("http://localhost/cdoc-app/api/documents/document-type", {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${user.token}`,
    },
  });

  if (!RestipoDoc.ok) {
    const errorData = await RestipoDoc.json();
    throw new Error(errorData.message || 'Error al obtener tipos de documentos');
  }
  const tiposDocumentos = await RestipoDoc.json();

  // Crear un contenedor de React para usar los componentes de Material-UI
  const div = document.createElement('div');
  const root = createRoot(div);

  // Listas de opciones para Autocomplete
  const opcionesDocumentos = tiposDocumentos.data.map((tipo) => tipo.nombre_doc);
  const opcionesRemitentes = tiposRemitentes.data.map((tipo) => tipo.nombre_rem);

  // Renderizar los componentes de Material-UI en el contenedor
  root.render(
    <>
      <TextField
        id="numeroDocumento"
        label="Nº de Documento"
        defaultValue={documento.numero_doc}
        variant="outlined"
        fullWidth
        margin="dense"
      />
      <TextField
        id="fechaEntrada"
        label="Fecha de entrada"
        type="date"
        defaultValue={documento.fecha_entrada}
        InputLabelProps={{ shrink: true }}
        variant="outlined"
        fullWidth
        margin="dense"
      />

      <Autocomplete
        id="tipoDocumento"
        options={opcionesDocumentos}
        defaultValue={documento.nombre_doc}
        renderInput={(params) => (
          <TextField {...params} label="Tipo de Documento" variant="outlined" margin="dense" />
        )}
        fullWidth
        disableClearable
      />

      <Autocomplete
        id="tipoRemitente"
        options={opcionesRemitentes}
        defaultValue={documento.nombre_rem}
        renderInput={(params) => (
          <TextField {...params} label="Tipo de Remitente" variant="outlined" margin="dense" />
        )}
        fullWidth
        disableClearable
      />

      <TextField
        id="descripcion"
        label="Descripción del Documento"
        multiline
        rows={3}
        defaultValue={documento.descripcion}
        variant="outlined"
        fullWidth
        margin="dense"
      />
    </>
  );

  return await Swal.fire({
    title: 'Editar Documento',
    html: div,
    showCancelButton: true,
    confirmButtonColor: '#e67e22', // Rojo para el botón de confirmación
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',
    focusConfirm: false,
    preConfirm: () => {
      return {
        numeroDocumento: document.getElementById('numeroDocumento').value,
        fechaEntrada: document.getElementById('fechaEntrada').value,
        descripcion: document.getElementById('descripcion').value,
        tipoDocumento: document.querySelector('#tipoDocumento').value,
        tipoRemitente: document.querySelector('#tipoRemitente').value,
      };
    },
  });
};


// Función para manejar la edición del documento
const editDocument = async (url, user, datos) => {
  const response = await fetch(url, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${user.token}`,
    },
    body: JSON.stringify(datos),
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.message || 'Error al editar el documento');
  }

  return await response.json();
};

// Función para eliminar un documento
const deleteDocument = async (url, user, id) => {
  const response = await fetch(`${url}/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${user.token}`,
    },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.message || 'Error al eliminar el documento');
  }

  return await response.json();
};

export const useCrud = (url) => {
  const { user } = useContext(AuthContext);
  const { data, setData, isLoading, error } = useFetch(url);  // Asegúrate de tener `setData` disponible desde `useFetch`
  const { showAlert } = useAlert(); // Usa el hook de alertas

  // Función para eliminar un documento con confirmación
  const handleDelete = async (id) => {
    const documento = data.data.find((item) => item.id_documento === id);

    if (!documento) {
      return showAlert('Error', 'Documento no encontrado.', 'error');
    }

    // Mostrar SweetAlert de confirmación
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar el documento: ${documento.numero_doc}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#9d2323', // Rojo para el botón de confirmación

      });

    if (result.isConfirmed) {
      try {
        await deleteDocument(url, user, id);
        await showAlert('Éxito', 'Documento eliminado correctamente.', 'success');

        // Actualizar el estado `data` después de eliminar
        setData((prevData) =>
          prevData.filter((item) => item.id_documento !== id)
        );
      } catch (error) {
        await showAlert('Error', error.message, 'error');
      }
    }
  };

  // Función para editar un documento
  const handleEdit = async (id, documento) => {
    if (!documento || documento.id_documento !== id) {
      return showAlert('Error', 'Documento no encontrado.', 'error');
    }

    const result = await showEditAlert(documento, user);
    if (result.isConfirmed) {
      const datos = { ...documento, ...result.value };
      const editar_url = 'http://localhost/cdoc-app/api/documents/edit/1';
      try {
        const data = await editDocument(editar_url, user, datos);
        await showAlert('Éxito', 'Documento editado correctamente.', 'success'); // Usa el hook de alertas

        setData((prevItems) =>
          prevItems.map((item) => (item.id_documento === id ? data : item))
        );
      } catch (error) {
        await showAlert('Error', error.message, 'error'); // Usa el hook de alertas
      }
    }
  };

  // Función para migrar un documento
  const handleMigrate = (id) => {
    console.log(`Migrar documento con ID: ${id}`);
  };

  return {
    data,      // Usar `data` directamente
    isLoading,
    error,
    handleEdit,
    handleDelete,
    handleMigrate,
  };
};
