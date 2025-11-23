import styles from "./Aluno.module.css";
import { FaChalkboardTeacher, FaCheckSquare } from "react-icons/fa";
import qrCode from "../../assets/qr-code.png"; // substitua pelo seu QR real

export default function Aluno() {
  return (
    <div className={styles.container}>
      <div className={styles.card}>
        <h2 className={styles.title}>Como funciona?</h2>

        <div className={styles.step}>
          <FaChalkboardTeacher className={styles.icon} />
          <p>
            O docente acessa o Smart Attendance com seu RA, e-mail institucional
            ou CPF.
          </p>
        </div>

        <div className={styles.step}>
          <img src={qrCode} alt="QR Code" className={styles.qr} />
          <p>O docente escaneia o QR Code que será gerado pelo professor.</p>
        </div>

        <div className={styles.step}>
          <FaCheckSquare className={styles.icon} />
          <p>
            Com o app, o estudante escaneia o QR Code do professor para registrar
            presença.
          </p>
        </div>

        <button className={styles.button}>Próximo</button>
      </div>
    </div>
  );
}
