import { useEffect, useState } from "react";
import api from "../services/api";

export default function Home() {
  const [dados, setDados] = useState([]);

  useEffect(() => {
    api.get("/dados")
      .then(res => setDados(res.data))
      .catch(err => console.error(err));
  }, []);

  return (
    <div>
      <h1>Bem-vindo ao site!</h1>
      <ul>
        {dados.map((item, idx) => (
          <li key={idx}>{item.nome}</li>
        ))}
      </ul>
    </div>
  );
}
