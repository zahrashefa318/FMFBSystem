import React, { useState } from "react";
import SplashSequence from "./components/SplashSequence";

function MainPage() {
  return (
    <div style={{ padding: 24 }}>
      <h1>FMFB — Main Dashboard</h1>
      <p>Welcome! The splash is done.</p>
    </div>
  );
}

export default function MainApp() {
  console.log("MainApp mounted");
  const [ready, setReady] = useState(false);
  return (
    <>
      {!ready && <SplashSequence onDone={() => setReady(true)} />}
      {ready && <MainPage />}
    </>
  );
}
