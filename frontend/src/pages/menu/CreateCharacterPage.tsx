import React, { useState, useEffect } from 'react';
import { Container, Row, Col, Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { CharacterForm } from '../../components/character/CharacterForm';
import { characterService } from '../../services/characterService';
import { CharacterClass, CharacterRace, CharacterFormData } from '../../types/character';

export const CreateCharacterPage: React.FC = () => {
  const navigate = useNavigate();
  const [classes, setClasses] = useState<CharacterClass[]>([]);
  const [races, setRaces] = useState<CharacterRace[]>([]);
  const [error, setError] = useState<string>('');

  useEffect(() => {
    const loadData = async () => {
      try {
        const [classesData, racesData] = await Promise.all([
          characterService.getClasses(),
          characterService.getRaces()
        ]);
        
        setClasses(classesData);
        setRaces(racesData);
      } catch (err) {
        const error = err instanceof Error ? err.message : 'Failed to load data';
        setError(error);
        if (error.includes('Not authenticated')) {
          navigate('/login');
        }
      }
    };

    loadData();
  }, [navigate]);

  const handleSubmit = async (formData: CharacterFormData) => {
    try {
      await characterService.createCharacter(formData);
      navigate('/menu');
    } catch (err) {
      const error = err instanceof Error ? err.message : 'Failed to create character';
      setError(error);
      if (error.includes('Not authenticated')) {
        navigate('/login');
      }
    }
  };

  return (
    <div className="character-creation" style={{
      minHeight: '100vh',
      background: '#121212',
      padding: '2rem 0'
    }}>
      <Container>
        <Row className="justify-content-center">
          <Col md={10} lg={8}>
            <CharacterForm
              classes={classes}
              races={races}
              onSubmit={handleSubmit}
              onCancel={() => navigate('/menu')}
              error={error}
            />
          </Col>
        </Row>
      </Container>
    </div>
  );
};
