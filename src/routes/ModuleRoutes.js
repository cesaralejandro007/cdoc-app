// src/routes/ModuleRoutes.js
import React from 'react';
import { Routes, Route } from 'react-router-dom';
import DocumentEntry from '../components/DocumentEntry';
import DocumentsExit from '../components/DocumentsExit';
import DocumentWithoutEntry from '../components/DocumentWithoutEntry';

const ModuleRoutes = () => {
  return (
    <Routes>
      <Route path="doc-entry" element={<DocumentEntry />} />
      <Route path="doc-exit" element={<DocumentsExit />} />
      <Route path="doc-without-entry" element={<DocumentWithoutEntry />} />
    </Routes>
  );
};

export default ModuleRoutes;
