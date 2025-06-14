import React from 'react';
import { CharacterClass } from '../../types/character';
import { Row, Col } from 'react-bootstrap';
import './styles.css';

interface ClassGridProps {
    classes: CharacterClass[];
    selectedClassId: number | null;
    onSelectClass: (classId: number) => void;
}

export const ClassGrid: React.FC<ClassGridProps> = ({ classes, selectedClassId, onSelectClass }) => {
    return (
        <Row className="g-3">
            {classes.map((characterClass) => (
                <Col xs={6} sm={4} md={3} key={characterClass.id}>
                    <div
                        className={`class-card ${selectedClassId === characterClass.id ? 'selected' : ''}`}
                        onClick={() => onSelectClass(characterClass.id)}
                    >
                        <div className="class-icon">
                            {characterClass.name[0]}
                        </div>
                        <div className="class-name">
                            {characterClass.name}
                        </div>
                    </div>
                </Col>
            ))}
        </Row>
    );
};
