
import React, { useState, useEffect, createContext, useContext } from 'react';
import { HashRouter as Router, Routes, Route, Navigate, Link, useLocation } from 'react-router-dom';
import { User, UserRole, Product, ArtisanEvent, Reservation } from './types';
import { store } from './store';

// Pages
import Home from './pages/Home';
import Catalogue from './pages/Catalogue';
import Artisans from './pages/Artisans';
import Events from './pages/Events';
import Profile from './pages/Profile';
import Auth from './pages/Auth';
import FAQPage from './pages/FAQPage';
import Contact from './pages/Contact';
import AdminDashboard from './pages/AdminDashboard';
import ArtisanDashboard from './pages/ArtisanDashboard';
import ProductDetail from './pages/ProductDetail';
import EventDetail from './pages/EventDetail';
import ArtisanDetail from './pages/ArtisanDetail';
import About from './pages/About';

interface AppContextType {
  currentUser: User | null;
  setCurrentUser: (user: User | null) => void;
  logout: () => void;
}

const AppContext = createContext<AppContextType | undefined>(undefined);

export const useApp = () => {
  const context = useContext(AppContext);
  if (!context) throw new Error('useApp must be used within AppProvider');
  return context;
};

const Navbar: React.FC = () => {
  const { currentUser, logout } = useApp();
  const location = useLocation();

  const isActive = (path: string) => location.pathname === path;

  return (
    <nav className="sticky top-0 z-50 bg-[#bfa58a] text-[#3e2723] shadow-md px-6 py-4 flex justify-between items-center">
      <Link to="/" className="flex items-center gap-3">
        <div className="w-10 h-10 rounded-full border-2 border-[#3e2723] flex items-center justify-center p-1">
          <img src="https://picsum.photos/seed/logoart/50/50" alt="Logo" className="rounded-full" />
        </div>
        <span className="text-2xl font-bold brand-font tracking-widest uppercase">Artisphère</span>
      </Link>

      <div className="hidden md:flex gap-8 font-semibold uppercase text-sm tracking-tighter">
        <Link to="/catalogue" className={isActive('/catalogue') ? 'underline decoration-2' : 'hover:underline'}>Catalogue</Link>
        <Link to="/artisans" className={isActive('/artisans') ? 'underline decoration-2' : 'hover:underline'}>Artisans</Link>
        <Link to="/events" className={isActive('/events') ? 'underline decoration-2' : 'hover:underline'}>Evènements</Link>
        {currentUser ? (
          <div className="flex gap-4">
            <Link to="/profile" className={isActive('/profile') ? 'underline decoration-2' : 'hover:underline'}>Profil</Link>
            <button onClick={logout} className="hover:text-red-800 transition-colors">Déconnexion</button>
          </div>
        ) : (
          <Link to="/auth" className="bg-[#3e2723] text-white px-4 py-1 rounded hover:opacity-90 transition-opacity">Connexion</Link>
        )}
      </div>
    </nav>
  );
};

const Footer: React.FC = () => {
  return (
    <footer className="bg-[#d8ccc0] text-[#3e2723] py-8 mt-auto border-t border-[#bfa58a]">
      <div className="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h4 className="font-bold mb-4 brand-font uppercase">Artisphère</h4>
          <p className="text-sm opacity-80">Promouvoir le talent local et l'artisanat de qualité près de chez vous.</p>
        </div>
        <div className="flex flex-col gap-2 text-sm">
          <Link to="/about" className="hover:underline">À propos de nous</Link>
          <Link to="/mentions-legales" className="hover:underline">Mentions Légales</Link>
          <Link to="/faq" className="hover:underline">FAQ</Link>
        </div>
        <div className="text-sm">
          <p>© 2025 Artisphère. Fait avec passion.</p>
        </div>
      </div>
    </footer>
  );
};

const App: React.FC = () => {
  const [currentUser, setCurrentUser] = useState<User | null>(null);

  useEffect(() => {
    const saved = localStorage.getItem('logged_user');
    if (saved) setCurrentUser(JSON.parse(saved));
  }, []);

  const logout = () => {
    localStorage.removeItem('logged_user');
    setCurrentUser(null);
  };

  const updateCurrentUser = (user: User | null) => {
    setCurrentUser(user);
    if (user) localStorage.setItem('logged_user', JSON.stringify(user));
  };

  return (
    <AppContext.Provider value={{ currentUser, setCurrentUser: updateCurrentUser, logout }}>
      <Router>
        <div className="min-h-screen flex flex-col">
          <Navbar />
          <main className="flex-grow">
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/catalogue" element={<Catalogue />} />
              <Route path="/catalogue/:id" element={<ProductDetail />} />
              <Route path="/artisans" element={<Artisans />} />
              <Route path="/artisans/:id" element={<ArtisanDetail />} />
              <Route path="/events" element={<Events />} />
              <Route path="/events/:id" element={<EventDetail />} />
              <Route path="/auth" element={currentUser ? <Navigate to="/profile" /> : <Auth />} />
              <Route path="/profile" element={currentUser ? <Profile /> : <Navigate to="/auth" />} />
              <Route path="/admin" element={currentUser?.role === UserRole.ADMIN ? <AdminDashboard /> : <Navigate to="/" />} />
              <Route path="/artisan-dashboard" element={currentUser?.role === UserRole.ARTISAN ? <ArtisanDashboard /> : <Navigate to="/" />} />
              <Route path="/faq" element={<FAQPage />} />
              <Route path="/contact" element={<Contact />} />
              <Route path="/about" element={<About />} />
            </Routes>
          </main>
          <Footer />
        </div>
      </Router>
    </AppContext.Provider>
  );
};

export default App;
