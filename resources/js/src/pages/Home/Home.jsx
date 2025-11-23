import { useState } from "react";
import styles from "./Home.module.css";

export default function Home() {
  const [raOuEmail, setRaOuEmail] = useState("");
  const [senha, setSenha] = useState("");
  const [lembrar, setLembrar] = useState(false);

  const handleLogin = (e) => {
    e.preventDefault();
    console.log({ raOuEmail, senha, lembrar });
  };

  return (
    <div className={styles.container}>
      <div className={styles.card}>
        <h1 className={styles.logo}>CEUB</h1>

        <hr className={styles.hr} />

        <h2 className={styles.title}>Smart Attendance</h2>
        <p className={styles.subtitle}>Registro Acadêmico</p>

        <hr className={styles.hr} />

        <form onSubmit={handleLogin} className={styles.form}>
          <input
            type="text"
            placeholder="RA ou E-Mail ou CPF"
            value={raOuEmail}
            onChange={(e) => setRaOuEmail(e.target.value)}
            className={styles.input}
          />

          <input
            type="password"
            placeholder="Senha"
            value={senha}
            onChange={(e) => setSenha(e.target.value)}
            className={styles.input}
          />

          <label className={styles.checkboxLabel}>
            <input
              type="checkbox"
              checked={lembrar}
              onChange={() => setLembrar(!lembrar)}
            />
            Lembrar de mim por 30 dias
          </label>

          <button type="submit" className={styles.button}>
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
