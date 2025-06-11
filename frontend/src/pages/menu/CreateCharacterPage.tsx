import React, { useState, useEffect } from 'react';
import { Container, Row, Col, Button, Form, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

interface GameClass {
  id: number;
  name: string;
}

interface Race {
  id: number;
  name: string;
}

interface CharacterFormData {
  name: string;
  classId: string;
  raceId: string;
  sex: string;
}

export const CreateCharacterPage: React.FC = () => {
  const navigate = useNavigate();
  const [classes, setClasses] = useState<GameClass[]>([]);
  const [races, setRaces] = useState<Race[]>([]);
  const [formData, setFormData] = useState<CharacterFormData>({
    name: '',
    classId: '',
    raceId: '',
    sex: ''
  });
  const [error, setError] = useState<string>('');

  useEffect(() => {
    // Fetch classes
    fetch('http://localhost:8000/api/classes')
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          setClasses(data.data);
        } else {
          setError(`Failed to load character classes: ${data.error}`);
          console.error('Classes error:', data.error);
          console.error('Stack trace:', data.trace);
        }
      })
      .catch(err => {
        setError('Failed to load character classes');
        console.error('Classes fetch error:', err);
      });

    // Fetch races
    fetch('http://localhost:8000/api/races')
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          setRaces(data.data);
        } else {
          setError(`Failed to load races: ${data.error}`);
          console.error('Races error:', data.error);
          console.error('Stack trace:', data.trace);
        }
      })
      .catch(err => {
        setError('Failed to load races');
        console.error('Races fetch error:', err);
      });
  }, []);

  const handleChange = (e: React.ChangeEvent<HTMLElement>) => {
    if (e.target instanceof HTMLInputElement || e.target instanceof HTMLSelectElement) {
      const { name, value } = e.target;
      setFormData(prev => ({
        ...prev,
        [name]: value
      }));
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');

    try {
      const token = localStorage.getItem('token');
      if (!token) {
        setError('Not authenticated. Please log in.');
        navigate('/login');
        return;
      }

      const response = await fetch('http://localhost:8000/api/create-character', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (data.success) {
        // Character created successfully, redirect to menu
        navigate('/menu');
      } else {
        setError(data.error || 'Failed to create character');
      }
    } catch (err) {
      console.error('Error creating character:', err);
      setError('Failed to create character. Please try again.');
    }
  };

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={8} lg={6}>
          <div className="bg-white p-4 shadow rounded">
            <div className="d-flex justify-content-between align-items-center mb-4">
              <h2>Create Character</h2>
              <Button 
                variant="secondary"
                onClick={() => navigate('/menu')}
              >
                Back to Menu
              </Button>
            </div>

            {error && (
              <Alert variant="danger" className="mb-4">
                {error}
              </Alert>
            )}
            <Form onSubmit={handleSubmit}>
              <Form.Group className="mb-3">
                <Form.Label>Character Name</Form.Label>
                <Form.Control 
                  type="text" 
                  name="name"
                  value={formData.name}
                  onChange={handleChange}
                  placeholder="Enter character name"
                  required 
                />
              </Form.Group>

              <Form.Group className="mb-3">
                <Form.Label>Class</Form.Label>
                <Form.Select 
                  name="classId"
                  value={formData.classId}
                  onChange={handleChange}
                  required
                >
                  <option value="">Select class</option>
                  {classes.map(c => (
                    <option key={c.id} value={c.id}>{c.name}</option>
                  ))}
                </Form.Select>
              </Form.Group>

              <Form.Group className="mb-3">
                <Form.Label>Race</Form.Label>
                <Form.Select 
                  name="raceId"
                  value={formData.raceId}
                  onChange={handleChange}
                  required
                >
                  <option value="">Select race</option>
                  {races.map(r => (
                    <option key={r.id} value={r.id}>{r.name}</option>
                  ))}
                </Form.Select>
              </Form.Group>

              <Form.Group className="mb-3">
                <Form.Label>Sex</Form.Label>
                <Form.Select 
                  name="sex"
                  value={formData.sex}
                  onChange={handleChange}
                  required
                >
                  <option value="">Select sex</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </Form.Select>
              </Form.Group>

              <div className="d-grid gap-2">
                <Button variant="primary" type="submit">
                  Create Character
                </Button>
              </div>
            </Form>
          </div>
        </Col>
      </Row>
    </Container>
  );
};
