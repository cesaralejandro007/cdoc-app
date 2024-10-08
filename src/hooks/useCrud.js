import { useContext } from 'react';
import { useFetch } from '../hooks/useRequest';
import { useAlert } from '../hooks/useAlert'; // Importa tu hook de alertas
import { AuthContext } from '../context/AuthContext';
import { TextField, Autocomplete } from '@mui/material';
import { createRoot } from 'react-dom/client';
import Swal from 'sweetalert2';



const showMigrateAlert = async (id, user) => {
  // Obtener tipos de destinatarios
  const destinatarios = await fetch("http://localhost/cdoc-app/api/documents/recipient", {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${user.token}`,
    },
  });

  if (!destinatarios.ok) {
    const errorData = await destinatarios.json();
    throw new Error(errorData.message || 'Error al obtener tipos de remitente');
  }
  const tiposDestinatarios = await destinatarios.json();

  // Crear un contenedor de React para usar los componentes de Material-UI
  const div = document.createElement('div');
  const root = createRoot(div);


  const uniqueDestinatario = {};

  // Recorrer los tipos de remitentes y agregarlos solo si no están repetidos
  const opcionesDestinatarios = tiposDestinatarios.data.reduce((acc, tipo) => {
    if (!uniqueDestinatario[tipo.nombre_des]) {
      uniqueDestinatario[tipo.nombre_des] = true;  // Marcar como existente
      acc.push({
        key: tipo.id_destinatario,
        label: tipo.nombre_des,
      });
    }
    return acc;
  }, []);

  // Renderizar los componentes de Material-UI en el contenedor
  root.render(
    <>
      <TextField
        id="fechaSalida"
        label="Fecha de salida"
        type="date"
        InputLabelProps={{ shrink: true }}
        variant="outlined"
        fullWidth
        margin="dense"
      />
      <Autocomplete
        id="tipoDestinatario"
        options={opcionesDestinatarios}
        getOptionLabel={(option) => option.label} // Mostrar el nombre del remitente
        renderInput={(params) => (
          <TextField {...params} label="Tipo de destinatario" variant="outlined" margin="dense" />
        )}
        fullWidth
        disableClearable
      />
    </>
  );

  return await Swal.fire({
    title: 'Selecciona un destinatario',
    html: div,
    showCancelButton: true,
    confirmButtonColor: '#1E88E5',
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',
    focusConfirm: false,
    preConfirm: () => {
      // Obtener el objeto Autocomplete para tipo de remitente
      const tipoDestinatarioSelect = document.querySelector('#tipoDestinatario').value;

      // Encontrar el documento seleccionado en el arreglo de opcionesDocumentos
      const destinatarioSeleccionado = opcionesDestinatarios.find(opt => opt.label === tipoDestinatarioSelect);

      return {
        fecha_salida: document.getElementById('fechaSalida').value,
        id_documento: id,
        id_destinatario: destinatarioSeleccionado ? destinatarioSeleccionado.key : null, // Obtener el id del documento
      };
    },
  });

};

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

  const uniqueDocumentos = {};

  // Recorrer los tipos de documentos y agregarlos solo si no están repetidos
  const opcionesDocumentos = tiposDocumentos.data.reduce((acc, tipo) => {
    if (!uniqueDocumentos[tipo.nombre_doc]) { // Corregir aquí para comparar por nombre del documento
      uniqueDocumentos[tipo.nombre_doc] = true;  // Marcar como existente
      acc.push({
        key: tipo.id_tipo_documento,
        label: tipo.nombre_doc, // También corregir para que use el nombre del documento
      });
    }
    return acc;
  }, []);

  const uniqueRemitentes = {};

  // Recorrer los tipos de remitentes y agregarlos solo si no están repetidos
  const opcionesRemitentes = tiposRemitentes.data.reduce((acc, tipo) => {
    if (!uniqueRemitentes[tipo.nombre_rem]) {
      uniqueRemitentes[tipo.nombre_rem] = true;  // Marcar como existente
      acc.push({
        key: tipo.id_remitente,
        label: tipo.nombre_rem,
      });
    }
    return acc;
  }, []);


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
        getOptionLabel={(option) => option.label} // Mostrar el nombre del documento
        defaultValue={opcionesDocumentos.find((opt) => opt.label === documento.nombre_doc)} // Establecer valor por defecto
        renderInput={(params) => (
          <TextField {...params} label="Tipo de Documento" variant="outlined" margin="dense" />
        )}
        fullWidth
        disableClearable
      />

      <Autocomplete
        id="tipoRemitente"
        options={opcionesRemitentes}
        getOptionLabel={(option) => option.label} // Mostrar el nombre del remitente
        defaultValue={opcionesRemitentes.find((opt) => opt.label === documento.nombre_rem)} // Establecer valor por defecto
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
    confirmButtonColor: '#e67e22',
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',
    focusConfirm: false,
    preConfirm: () => {
      // Obtener el objeto Autocomplete para tipo de documento
      const tipoDocumentoSelect = document.querySelector('#tipoDocumento').value;
      // Obtener el objeto Autocomplete para tipo de remitente
      const tipoRemitenteSelect = document.querySelector('#tipoRemitente').value;

      // Encontrar el documento seleccionado en el arreglo de opcionesDocumentos
      const documentoSeleccionado = opcionesDocumentos.find(opt => opt.label === tipoDocumentoSelect);
      // Encontrar el remitente seleccionado en el arreglo de opcionesRemitentes
      const remitenteSeleccionado = opcionesRemitentes.find(opt => opt.label === tipoRemitenteSelect);

      return {
        numero_doc: document.getElementById('numeroDocumento').value,
        fecha_entrada: document.getElementById('fechaEntrada').value,
        descripcion: document.getElementById('descripcion').value,
        id_tipo_documento: documentoSeleccionado ? documentoSeleccionado.key : null, // Obtener el id del documento
        id_remitente: remitenteSeleccionado ? remitenteSeleccionado.key : null, // Obtener el id del remitente
        nombre_doc: documentoSeleccionado ? documentoSeleccionado.label : null, // Obtener el nombre del documento
        nombre_rem: remitenteSeleccionado ? remitenteSeleccionado.label : null, // Obtener el nombre del remitente
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

  const handleDelete = async (id) => {
    const documento = data?.data?.find((item) => item.id_documento === id);

    if (!documento) {
      return showAlert('Error', 'Documento no encontrado.', 'error');
    }

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
        const delete_url = 'http://localhost/cdoc-app/api/documents/delete';
        await deleteDocument(delete_url, user, id);
        await showAlert('Éxito', 'Documento eliminado correctamente.', 'success');

        // Asegurarse de que `data.data` sea un array antes de intentar modificarlo
        if (Array.isArray(data.data)) {
          setData({
            ...data,
            data: data.data.filter((item) => item.id_documento !== id), // Actualiza solo el array `data.data`
          });
        }
      } catch (error) {
        await showAlert('Error', error.message, 'error');
      }
    }
  };

  const formatearFecha = (fechaISO) => {
    const [year, month, day] = fechaISO.split('-');
    return `${day}/${month}/${year}`;
  };

  const handleEdit = async (id, documento) => {
    if (!documento || documento.id_documento !== id) {
      return showAlert('Error', 'Documento no encontrado.', 'error');
    }

    const result = await showEditAlert(documento, user);
    if (result.isConfirmed) {
      const datos = { ...documento, ...result.value };
      datos.fecha_entrada_formateada = formatearFecha(datos.fecha_entrada);
      const editar_url = 'http://localhost/cdoc-app/api/documents/edit/' + id;
      try {
        const updatedData = await editDocument(editar_url, user, datos);

        // Verifica si la actualización fue exitosa
        if (updatedData.OK && updatedData.code === 200) {
          await showAlert('Éxito', updatedData.message || 'Documento editado correctamente.', 'success');

          // Asegurarse de que `data.data` sea un array antes de intentar modificarlo
          if (Array.isArray(data.data)) {
            setData({
              ...data,
              data: data.data.map((item) => (item.id_documento === id ? datos : item)), // Actualiza solo el array `data.data`
            });
          }
          console.log(data);
        } else {
          // Si la respuesta contiene un error, mostrar el mensaje de error
          await showAlert('Error', updatedData.message || 'Error al actualizar el documento.', 'error');
        }
      } catch (error) {
        await showAlert('Error', error.message, 'error');
      }
    }
  };

  // Función para migrar un documento
  const handleMigrate = async (id) => {
    const result = await showMigrateAlert(id, user);
    console.log(result);
    if (result.isConfirmed) {
      /*  datos.fecha_entrada_formateada = formatearFecha(datos.fecha_entrada);
       const editar_url = 'http://localhost/cdoc-app/api/documents/edit/' + id;
       try {
         const updatedData = await editDocument(editar_url, user, datos);
   
         if (updatedData.OK && updatedData.code === 200) {
           await showAlert('Éxito', updatedData.message || 'Documento editado correctamente.', 'success');
           
 
           if (Array.isArray(data.data)) {
             setData({
               ...data,
               data: data.data.map((item) => (item.id_documento === id ? datos : item)), // Actualiza solo el array `data.data`
             });
           }
           console.log(data);
         } else {
           await showAlert('Error', updatedData.message || 'Error al actualizar el documento.', 'error');
         }
       } catch (error) {
         await showAlert('Error', error.message, 'error');
       } */
    }
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
