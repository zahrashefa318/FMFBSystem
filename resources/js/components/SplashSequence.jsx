// resources/js/components/SplashSequence.jsx
import React, { useEffect, useRef, useState, useMemo } from "react";

export default function SplashSequence({ onDone }) {
  // Memoize so the reference is stable and doesn't retrigger effects
  const images = useMemo(() => [
    "/images/F1.png",
    "/images/M.png",
    "/images/F2.png",
    "/images/B.png",
  ], []);

  const letters = ["F","M","F","B"];

  const [step, setStep] = useState(0);
  const [imgReady, setImgReady] = useState(false);
  const timerRef = useRef(null);

  // Debug
  useEffect(() => { console.log("Splash mounted"); }, []);

  // Preload once
  useEffect(() => {
    images.forEach(src => { const i = new Image(); i.src = src; });
  }, [images]);

  // Drive the sequence
  useEffect(() => {
    setStep(0);
    setImgReady(false);
    let i = 0;

    timerRef.current = setInterval(() => {
      i += 1;
      if (i < images.length) {
        setImgReady(false);
        setStep(i);
      } else {
        clearInterval(timerRef.current);
        console.log("Splash done");
        onDone?.();
      }
    }, 1250);

    return () => { if (timerRef.current) clearInterval(timerRef.current); };
    // IMPORTANT: do NOT depend on `images` (it would retrigger on every render unless memoized)
  }, [onDone]); // <— only onDone here
  // If you didn't use useMemo above, change deps to [] instead.

  if (step >= images.length) return null;

  return (
    <div style={{
      position:"fixed", inset:0, display:"grid", placeItems:"center",
      background:"#341539", color:"#fff", zIndex:9999
    }}>
      {!imgReady && (
        <div style={{ fontSize:"min(20vw,160px)", fontWeight:800, opacity:.25 }}>
          {letters[step]}
        </div>
      )}
      <img
        src={images[step]}
        alt={`splash-${step}`}
        onLoad={() => setImgReady(true)}
        onError={() => console.warn("Image failed:", images[step])}
        style={{ width:"min(60vw,420px)", height:"auto", objectFit:"contain",
                 display: imgReady ? "block" : "none" }}
      />
    </div>
  );
}
