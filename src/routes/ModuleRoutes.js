// src/routes/ModuleRoutes.js
import React from 'react';
import { Routes, Route } from 'react-router-dom';
import DocumentEntry from '../components/DocumentEntry';
import DocumentsExit from '../components/DocumentsExit';
import DocumentWithoutEntry from '../components/DocumentWithoutEntry';
import LogUser from '../components/logUser';
import LogSystem from '../components/logSystem';
import User from '../components/User';

const ModuleRoutes = () => {
  return (
    <Routes>
      <Route path="doc-entry" element={<DocumentEntry />} />
      <Route path="doc-exit" element={<DocumentsExit />} />
      <Route path="doc-without-entry" element={<DocumentWithoutEntry />} />
      <Route path="log-user" element={<LogUser/>} />
      <Route path="log-system" element={<LogSystem/>} />
      <Route path="users" element={<User/>} />
    </Routes>
  );
};

export default ModuleRoutes;
