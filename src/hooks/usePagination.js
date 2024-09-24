import { useState, useCallback } from 'react';

export const usePagination = (paginationPageSizeSelector) => {
    const [paginationPageSize, setPaginationPageSize] = useState(paginationPageSizeSelector[0]);
    const [gridApi, setGridApi] = useState(null);

    const onGridReady = useCallback((params) => {
        setGridApi(params.api);  // Aquí obtenemos la API de la tabla
    }, []);

    const onPageSizeChanged = useCallback((event) => {
        const newPageSize = Number(event.target.value);
        setPaginationPageSize(newPageSize);
        if (gridApi && gridApi.paginationSetPageSize) {
            gridApi.paginationSetPageSize(newPageSize);  // Asegúrate de usar paginationSetPageSize
        }
    }, [gridApi]);

    return {
        paginationPageSize,
        onGridReady,
        onPageSizeChanged,
    };
};
