import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Home from "./pages/Home/Home";
import Aluno from "./pages/Aluno/Aluno";
import FAQ from "./pages/FAQ/FAQ";
import Historico from "./pages/HistoricoChamada/HistoricoChamada";
import Presenca from "./pages/Presenca/Presenca";
import Header from "./components/Header";
import Footer from "./components/Footer";

function App() {
  return (
    <Router>
      <main className="min-h-screen p-4">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/aluno" element={<Aluno />} />
          <Route path="/faq" element={<FAQ />} />
          <Route path="/historico" element={<Historico />} />
          <Route path="/presenca" element={<Presenca />} />
        </Routes>
      </main>
      <Footer />
    </Router>
  );
}

export default App;
