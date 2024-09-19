// src/App.js
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import HomePage from './components/HomePage';
import Login from './components/Login';
import PrivateRoute from './routes/PrivateRoute';
import ModuleRoutes from './routes/ModuleRoutes'; // Mantén este archivo si quieres usarlo

function isAuthenticated() {
  const token = localStorage.getItem('token');
  return token !== null;
}

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/Login" element={<Login />} />
        {/* Ruta protegida para HomePage */}
        <Route
          path="/home/*"
          element={
            <PrivateRoute isAuthenticated={isAuthenticated()}>
              <HomePage />
            </PrivateRoute>
          }
        >
          <Route path="modules/*" element={<ModuleRoutes />} />
        </Route>
      </Routes>
    </Router>
  );
}

export default App;
