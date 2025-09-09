import './bootstrap';
import React from "react";
import { createRoot } from "react-dom/client";
import MainApp from "./mainApp";   // file: resources/js/mainApp.jsx

console.log("ENTRY: mounting <MainApp />");

const el = document.getElementById("root");
if (el) {
  createRoot(el).render(
    <React.StrictMode>
      <MainApp />   {/* MUST be capitalized */}
    </React.StrictMode>
  );
}

