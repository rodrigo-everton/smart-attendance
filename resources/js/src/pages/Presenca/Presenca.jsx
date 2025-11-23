import { useEffect, useState } from "react";
import styles from "./Presenca.module.css";
import { FaQuestionCircle, FaHistory } from "react-icons/fa";
import { AiOutlineScan } from "react-icons/ai";

export default function Presenca() {
  const [time, setTime] = useState("");

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
        <div className={styles.scanIcon}>
          <AiOutlineScan />
        </div>
        <p className={styles.text}>
          Aponte a câmera para o QR Code do professor e sua presença será
          registrada automaticamente
        </p>
        <button className={styles.scanButton}>Scanear</button>
      </main>

      <footer className={styles.footer}>
        <div className={styles.footerItem}>
          <FaQuestionCircle className={styles.footerIcon} />
          <span>Preciso de ajuda!</span>
        </div>
        <div className={styles.footerItem}>
          <FaHistory className={styles.footerIcon} />
          <span>Histórico</span>
        </div>
      </footer>
    </div>
  );
}
