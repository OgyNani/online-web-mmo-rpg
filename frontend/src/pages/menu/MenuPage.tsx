import React from 'react';
import { Container, Row, Col, Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

export const MenuPage: React.FC = () => {
  const navigate = useNavigate();
  const { logout } = useAuth();

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={8} lg={6}>
          <div className="bg-white p-4 shadow rounded">
            <h2 className="text-center mb-4">Game Menu</h2>
            
            <div className="d-grid gap-3">
              <Button 
                variant="primary" 
                size="lg"
                onClick={() => navigate('/create-character')}
              >
                Create Character
              </Button>
              
              <Button 
                variant="secondary" 
                size="lg"
                onClick={() => navigate('/characters')}
              >
                My Characters
              </Button>

              <Button 
                variant="danger" 
                onClick={() => {
                  logout();
                  navigate('/login');
                }}
              >
                Logout
              </Button>
            </div>
          </div>
        </Col>
      </Row>
    </Container>
  );
};
