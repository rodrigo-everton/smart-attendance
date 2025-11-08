import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import Aluno from "./pages/Aluno";
import FAQ from "./pages/FAQ";
import Historico from "./pages/HistoricoChamada";
import Presenca from "./pages/Presenca";
import Header from "./components/Header";
import Footer from "./components/Footer";

function App() {
  return (
    <Router>
      <Header />
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
