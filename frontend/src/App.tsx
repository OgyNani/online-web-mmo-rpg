import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { LoginPage } from './pages/auth/LoginPage';
import { RegisterPage } from './pages/auth/RegisterPage';
import { MenuPage } from './pages/menu/MenuPage';
import { CreateCharacterPage } from './pages/menu/CreateCharacterPage';
import { AuthProvider, useAuth } from './context/AuthContext';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';

const ProtectedRoute: React.FC<{ element: React.ReactElement }> = ({ element }) => {
  const { isAuthenticated } = useAuth();
  return isAuthenticated ? element : <Navigate to="/login" />;
};

const AppRoutes = () => {
  const { isAuthenticated } = useAuth();

  return (
    <Routes>
      <Route path="/login" element={
        isAuthenticated ? <Navigate to="/menu" /> : <LoginPage />
      } />
      <Route path="/register" element={
        isAuthenticated ? <Navigate to="/menu" /> : <RegisterPage />
      } />
      <Route path="/menu" element={
        <ProtectedRoute element={<MenuPage />} />
      } />
      <Route path="/create-character" element={
        <ProtectedRoute element={<CreateCharacterPage />} />
      } />
      <Route path="/" element={
        isAuthenticated ? <Navigate to="/menu" /> : <Navigate to="/login" />
      } />
    </Routes>
  );
};

function App() {
  return (
    <AuthProvider>
      <Router>
        <div className="App">
          <AppRoutes />
        </div>
      </Router>
    </AuthProvider>
  );
}

export default App;
