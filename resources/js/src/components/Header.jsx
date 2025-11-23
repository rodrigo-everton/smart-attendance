import { Link } from "react-router-dom";

export default function Header() {
  return (
    <header className="p-4 bg-gray-800 text-white flex justify-around">
      <Link to="/">Home</Link>
      <Link to="/aluno">Aluno</Link>
      <Link to="/faq">FAQ</Link>
      <Link to="/historico">Historico</Link>
      <Link to="/presenca">Presenca</Link>
    </header>
  );
}
