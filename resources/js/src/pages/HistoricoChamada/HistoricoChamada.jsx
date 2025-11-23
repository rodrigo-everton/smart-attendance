import { useEffect, useState } from "react";
import styles from "./HistoricoChamada.module.css";
import { FaCheckCircle, FaTimesCircle } from "react-icons/fa";

export default function HistoricoChamada() {
  const [time, setTime] = useState("");

  const chamadas = [
    { data: "Set 29, 2025", hora: "8:20 AM", presente: true },
    { data: "Out 12, 2025", hora: "8:00 AM", presente: true },
    { data: "Out 21, 2025", hora: "8:00 AM", presente: false },
    { data: "Nov 01, 2025", hora: "8:00 AM", presente: false },
    { data: "Nov 09, 2025", hora: "8:00 AM", presente: true },
  ];

  useEffect(() => {
    const updateClock = () => {
      const now = new Date();
      const hours = now.getHours().toString().padStart(2, "0");
      const minutes = now.getMinutes().toString().padStart(2, "0");
      setTime(`${hours}:${minutes}`);
    };
    updateClock();
    const timer = setInterval(updateClock, 60000);
    return () => clearInterval(timer);
  }, []);

  return (
    <div className={styles.container}>
      <header className={styles.header}>
        <div className={styles.greeting}>
          <span>Olá</span>
          <div className={styles.avatar}>J</div>
        </div>
        <span className={styles.time}>{time}</span>
      </header>

      <main className={styles.main}>
        <h2 className={styles.title}>Histórico de Chamadas</h2>
        <p className={styles.subtitle}>Smart Attendance Chamadas</p>

        <div className={styles.lista}>
          {chamadas.map((c, i) => (
            <div
              key={i}
              className={`${styles.item} ${
                c.presente ? styles.presente : styles.faltou
              }`}
            >
              <div className={styles.info}>
                <div className={styles.avatar}>J</div>
                <div>
                  <p className={styles.data}>{c.data}</p>
                  <p className={styles.hora}>{c.hora}</p>
                </div>
              </div>
              {c.presente ? (
                <FaCheckCircle className={styles.iconPresente} />
              ) : (
                <FaTimesCircle className={styles.iconFaltou} />
              )}
            </div>
          ))}
        </div>

        <button className={styles.voltar}>Voltar</button>
      </main>
    </div>
  );
}
