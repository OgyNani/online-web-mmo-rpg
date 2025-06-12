import React, { useState, FormEvent } from 'react';
import { Form, Button, Alert, Container, Row, Col } from 'react-bootstrap';
import { CharacterClass, CharacterRace, CharacterFormData } from '../../types/character';
import { ClassGrid } from './ClassGrid';
import { StatsTable } from './CharacterStats';

interface CharacterFormProps {
    classes: CharacterClass[];
    races: CharacterRace[];
    onSubmit: (data: CharacterFormData) => Promise<void>;
    onCancel: () => void;
    error?: string;
}

export const CharacterForm: React.FC<CharacterFormProps> = ({ 
    classes, 
    races, 
    onSubmit,
    onCancel,
    error 
}) => {
    const [selectedClassId, setSelectedClassId] = useState<number | null>(null);
    const [formData, setFormData] = useState<CharacterFormData>({
        name: '',
        classId: '',
        raceId: '',
        sex: ''
    });

    const selectedClass = classes.find(c => c.id === selectedClassId);

    const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        await onSubmit(formData);
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    return (
        <div className="character-form">
            <Form onSubmit={handleSubmit}>
                {error && (
                    <Alert variant="danger" className="mb-4">
                        {error}
                    </Alert>
                )}

                <div className="character-selection-area mb-5">
                    <h2 className="text-white mb-4">Choose Your Class</h2>
                    <Row>
                        <Col md={8}>
                            <ClassGrid 
                                classes={classes}
                                selectedClassId={selectedClassId}
                                onSelectClass={(classId) => {
                                    setSelectedClassId(classId);
                                    setFormData(prev => ({ ...prev, classId: classId.toString() }));
                                }}
                            />
                        </Col>
                        <Col md={4}>
                            {selectedClass ? (
                                <StatsTable 
                                    baseStats={selectedClass.baseStats}
                                    maxStats={selectedClass.maxStats}
                                />
                            ) : (
                                <div className="stats-table text-center p-4">
                                    <h3 className="mb-3">Character Stats</h3>
                                    <p className="text-muted">Select a class to view stats</p>
                                </div>
                            )}
                        </Col>
                    </Row>
                </div>

                <div className="character-details-area">
                    <h2 className="text-white mb-4">Character Details</h2>
                    <Row className="mb-4">
                        <Col md={12}>
                            <Form.Group>
                                <Form.Label>Character Name</Form.Label>
                                <Form.Control
                                    type="text"
                                    name="name"
                                    value={formData.name}
                                    onChange={handleChange}
                                    required
                                    placeholder="Enter character name"
                                />
                            </Form.Group>
                        </Col>
                    </Row>

                    <Row className="mb-5">
                        <Col md={6}>
                            <Form.Group>
                                <Form.Label>Race</Form.Label>
                                <Form.Select
                                    name="raceId"
                                    value={formData.raceId}
                                    onChange={handleChange}
                                    required
                                >
                                    <option value="">Select a race</option>
                                    {races.map(r => (
                                        <option key={r.id} value={r.id}>
                                            {r.name}
                                        </option>
                                    ))}
                                </Form.Select>
                            </Form.Group>
                        </Col>
                        <Col md={6}>
                            <Form.Group>
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
                        </Col>
                    </Row>

                    <Row>
                        <Col md={6}>
                            <Button variant="primary" type="submit" className="w-100 py-3">
                                Create Character
                            </Button>
                        </Col>
                        <Col md={6}>
                            <Button variant="secondary" type="button" className="w-100 py-3" onClick={onCancel}>
                                Back to Menu
                            </Button>
                        </Col>
                    </Row>
                </div>
            </Form>
        </div>
    );
};
