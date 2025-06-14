import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Container, Row, Col, Button } from 'react-bootstrap';
import { useAuth } from '../../hooks/useAuth';
import { CharacterList } from '../../components/character/CharacterList';
import { UserCharacter } from '../../types/character';
import { characterService } from '../../services/characterService';
import './menuPage.css';

export const MenuPage = () => {
    const navigate = useNavigate();
    const { logout, user } = useAuth();
    const [selectedCharacter, setSelectedCharacter] = useState<UserCharacter | null>(null);
    const [characters, setCharacters] = useState<UserCharacter[]>([
        // Placeholder empty slots
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
        { id: null, name: '', class: '', level: 1 },
    ]);

    useEffect(() => {
        const fetchCharacters = async () => {
            try {
                const userCharacters = await characterService.getUserCharacters();
                console.log('Loaded characters:', userCharacters);
                // Fill remaining slots with empty characters
                const emptySlots = Array(8 - userCharacters.length).fill({ id: null, name: '', class: '', level: 1 });
                const allSlots = [...userCharacters, ...emptySlots];
                console.log('All slots:', allSlots);
                setCharacters(allSlots);
            } catch (error) {
                console.error('Failed to load characters:', error);
            }
        };

        fetchCharacters();
    }, []);

    const handleCreateCharacter = () => {
        navigate('/create-character');
    };

    const handleLogout = () => {
        logout();
        navigate('/login');
    };

    const handleSelectCharacter = (character: UserCharacter) => {
        console.log('Character clicked:', character);
        
        if (character.name === '') {
            // Empty slot
            console.log('Empty slot, navigating to create');
            navigate('/create-character');
        } else {
            // Existing character
            console.log('Existing character selected:', character);
            setSelectedCharacter(character);
        }
    };

    return (
        <div className="game-menu">
            <Container>
                <Row className="justify-content-center">
                    <Col md={10} lg={8}>
                        <div className="menu-header">
                            <div className="account-info">
                                <span className="username">{user?.email}</span>
                                <Button variant="link" className="logout-btn" onClick={handleLogout}>
                                    Log Out
                                </Button>
                            </div>
                        </div>

                        <CharacterList 
                            characters={characters}
                            selectedCharacter={selectedCharacter}
                            onSelectCharacter={handleSelectCharacter}
                        />

                        <div className="menu-footer">
                            <Button variant="secondary" onClick={handleLogout}>Logout</Button>
                            <Button 
                                variant="primary" 
                                onClick={() => console.log('Starting game with character:', selectedCharacter)}
                                disabled={!selectedCharacter}
                            >
                                Play
                            </Button>
                            <Button variant="info" onClick={handleCreateCharacter}>Create Character</Button>
                        </div>
                    </Col>
                </Row>
            </Container>
        </div>
    );
};
