// src/App.js
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import HomePage from './components/HomePage';
import Login from './components/Login';
import ModuleRoutes from './routes/ModuleRoutes';
import { UserProvider } from './context/UserContext'; // Importa el UserProvider

function App() {
  return (
    <UserProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="/login" element={<Login />} />
          {/* Ruta protegida para HomePage */}
          <Route path="/home/*" element={<HomePage />}>
            <Route path="modules/*" element={<ModuleRoutes />} />
          </Route>
        </Routes>
      </Router>
    </UserProvider>
  );
}

export default App;
