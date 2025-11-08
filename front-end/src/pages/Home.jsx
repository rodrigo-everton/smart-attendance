import { useState } from "react";
import colors from "../styles/colors";

export default function Home() {
  const [raOuEmail, setRaOuEmail] = useState("");
  const [senha, setSenha] = useState("");
  const [lembrar, setLembrar] = useState(false);

  const handleLogin = (e) => {
    e.preventDefault();
    console.log({ raOuEmail, senha, lembrar });
  };

  return (
    <div
      style={{
        backgroundColor: colors.primary,
        color: colors.light,
        minHeight: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
      }}
    >
      <div
        style={{
          width: "320px",
          backgroundColor: colors.primary,
          padding: "2rem",
          borderRadius: "12px",
          display: "flex",
          flexDirection: "column",
          alignItems: "center",
          boxShadow: "0 0 15px rgba(0,0,0,0.3)",
        }}
      >
        <h1
          style={{
            fontSize: "3rem",
            fontWeight: "900",
            letterSpacing: "2px",
            marginBottom: "1rem",
          }}
        >
          CEUB
        </h1>

        <hr style={{ width: "100%", borderColor: colors.light, opacity: 0.4 }} />

        <h2
          style={{
            color: colors.accent,
            marginTop: "1rem",
            fontWeight: "700",
          }}
        >
          Smart Attendance
        </h2>

        <p
          style={{
            fontWeight: "600",
            marginBottom: "1rem",
          }}
        >
          Registro Acadêmico
        </p>

        <hr style={{ width: "100%", borderColor: colors.light, opacity: 0.4 }} />

        <form
          onSubmit={handleLogin}
          style={{
            width: "100%",
            display: "flex",
            flexDirection: "column",
            marginTop: "1.5rem",
            gap: "0.8rem",
          }}
        >
          <input
            type="text"
            placeholder="RA ou E-Mail ou CPF"
            value={raOuEmail}
            onChange={(e) => setRaOuEmail(e.target.value)}
            style={{
              padding: "0.8rem",
              borderRadius: "20px",
              border: "none",
              outline: "none",
              width: "100%",
            }}
          />

          <input
            type="password"
            placeholder="Senha"
            value={senha}
            onChange={(e) => setSenha(e.target.value)}
            style={{
              padding: "0.8rem",
              borderRadius: "20px",
              border: "none",
              outline: "none",
              width: "100%",
            }}
          />

          <label
            style={{
              display: "flex",
              alignItems: "center",
              gap: "0.4rem",
              fontSize: "0.9rem",
              cursor: "pointer",
            }}
          >
            <input
              type="checkbox"
              checked={lembrar}
              onChange={() => setLembrar(!lembrar)}
              style={{ accentColor: colors.accent }}
            />
            Lembrar de mim por 30 dias
          </label>

          <button
            type="submit"
            style={{
              marginTop: "0.5rem",
              backgroundColor: colors.accent,
              borderRadius: "20px",
              padding: "0.8rem",
              fontWeight: "bold",
              color: colors.light,
              display: "flex",
              alignItems: "center",
              justifyContent: "center",
              gap: "0.5rem",
              transition: "0.3s",
            }}
            onMouseEnter={(e) =>
              (e.currentTarget.style.backgroundColor = colors.secondary)
            }
            onMouseLeave={(e) =>
              (e.currentTarget.style.backgroundColor = colors.accent)
            }
          >
            <span role="img" aria-label="login">
              🔐
            </span>
            Acessar
          </button>
        </form>
      </div>
    </div>
  );
}

