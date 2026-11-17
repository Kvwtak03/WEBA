// --- 1. KOMPONENTA TLAČÍTKA (Button) ---
function Button({ text, color, inverse }) {
  
  const buttonStyle = {
    backgroundColor: color, 
    color: inverse ? 'white' : 'black', // Pokud je inverse true, text je bílý
    border: 'none',
    padding: '12px 15px',
    fontWeight: 'bold',
    cursor: 'pointer',
    fontSize: '16px',
  };

  return (
    <button style={buttonStyle}>
      {text}
    </button>
  );
}

// --- 2. KOMPONENTA PANELU (Panel) ---
function Panel({ buttons, shadow }) {
  const panelStyle = {
    display: 'inline-flex',
    overflow: 'hidden', // Zajistí, že rohy panelu oříznou zakulacení krajních tlačítek
    borderRadius: '15px',
    boxShadow: shadow ? '4px 4px rgba(49, 49, 49, 0.23)' : 'none', // Aplikuje stín, pokud je shadow true
    margin: '15px', 
  };

  return (
    <div style={panelStyle}>
      {/* 
        Vezmeme pole tlačítek (buttons) a pomocí metody .map() ho "přeložíme" na seznam React komponent <Button />.
      */}
      {buttons.map((btn, index) => (
        <Button
          key={index} // React vyžaduje unikátní klíč při cyklení
          text={btn.text}
          color={btn.color}
          inverse={btn.inverse} 
        />
      ))}
    </div>
  );
}

// --- 3. VSTUPNÍ DATA ---
const buttons = [
  {text: "add", color: "#eee"},
  {text: "edit", color: "#eee"},
  {text: "delete", color: "#FF5733", inverse: true}
];
      
const buttons2 = [
  {text: "a", color: "#34eb8f"},
  {text: "b", color: "#1f8753", inverse: true},
  {text: "c", color: "#34eb8f"},
  {text: "d", color: "#1f8753", inverse: true},
  {text: "e", color: "#34eb8f"}
];

const buttons3 = [
  {text: "info", color: "#349beb", inverse: true},
];

// --- 4. VYKRESLENÍ DO HTML (Mounting) ---
const rootElement = document.getElementById('root');

if (rootElement) {
  const root = ReactDOM.createRoot(rootElement);
  root.render(
    <>
      <Panel shadow buttons={buttons} />
      <Panel buttons={buttons} />
      <Panel buttons={buttons2} />
      <Panel buttons={buttons3} />
      <Panel shadow buttons={buttons3} />
    </>
  );
}