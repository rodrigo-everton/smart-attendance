import { useEffect, useState } from "react";
import styles from "./FAQ.module.css";
import { FaQuestionCircle } from "react-icons/fa";
import { IoIosArrowDown, IoIosArrowUp } from "react-icons/io";

export default function FAQ() {
  const [time, setTime] = useState("");
  const [openIndex, setOpenIndex] = useState(null);

  const faqs = [
    {
      q: "Como faço para registrar minha presença?",
      a: "Basta abrir o app, acessar a tela de 'Registrar Presença' e escanear o QR Code do professor.",
    },
    {
      q: "Preciso fazer algo depois de escanear o QR Code?",
      a: "Não. Sua presença será registrada automaticamente após a leitura do código.",
    },
    {
      q: "O que acontece se eu escanear o QR Code depois do tempo permitido?",
      a: "A presença não será registrada, pois o período de chamada terá sido encerrado.",
    },
    {
      q: "Como posso verificar se minha presença foi registrada?",
      a: "Acesse a tela de 'Histórico' para visualizar todas as presenças registradas.",
    },
    {
      q: "Preciso de internet para registrar minha presença?",
      a: "Sim, é necessário estar conectado à internet para enviar o registro ao sistema.",
    },
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

  const toggleFAQ = (index) => {
    setOpenIndex(openIndex === index ? null : index);
  };

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
        <h2 className={styles.title}>Preciso de Ajuda!</h2>

        <div className={styles.banner}>
          <FaQuestionCircle className={styles.bannerIcon} />
          <h3>FAQ</h3>
        </div>

        <div className={styles.faqList}>
          {faqs.map((item, index) => (
            <div key={index} className={styles.faqItem}>
              <button
                className={styles.faqQuestion}
                onClick={() => toggleFAQ(index)}
              >
                {item.q}
                {openIndex === index ? (
                  <IoIosArrowUp className={styles.arrow} />
                ) : (
                  <IoIosArrowDown className={styles.arrow} />
                )}
              </button>
              {openIndex === index && (
                <div className={styles.faqAnswer}>{item.a}</div>
              )}
            </div>
          ))}
        </div>

        <button className={styles.backButton}>Voltar</button>
      </main>
    </div>
  );
}
