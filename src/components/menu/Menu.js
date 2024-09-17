import React from "react";
import { Link } from "react-router-dom";

const Menu = () => {
  return (
    <div>
      <h2>Menú de Opciones</h2>
      <ul>
        <li>
          <Link to="/Salir">Opción 1</Link>
        </li>
        <li>
          <Link to="/opcion1">Opción 1</Link>
        </li>
        <li>
          <Link to="/opcion2">Opción 2</Link>
        </li>
        <li>
          <Link to="/opcion3">Opción 3</Link>
        </li>
      </ul>
    </div>
  );
};

export default Menu;
