import React from 'react';
import { Row, Col, Card } from 'react-bootstrap';
import { CharacterClass } from '../../types/character';
import './styles.css';

interface ClassGridProps {
    classes: CharacterClass[];
    selectedClassId: number | null;
    onSelectClass: (classId: number) => void;
}

export const ClassGrid: React.FC<ClassGridProps> = ({ 
    classes, 
    selectedClassId, 
    onSelectClass 
}) => {
    return (
        <div className="class-grid">
            {classes.map(characterClass => (
                <div 
                    key={characterClass.id}
                    className={`class-card ${selectedClassId === characterClass.id ? 'selected' : ''}`}
                    onClick={() => onSelectClass(characterClass.id)}
                >
                    <div className="class-icon">
                        {characterClass.iconUrl ? (
                            <img 
                                src={characterClass.iconUrl} 
                                alt={characterClass.name}
                            />
                        ) : (
                            <div className="placeholder-icon">{characterClass.name[0]}</div>
                        )}
                    </div>
                    <div className="class-name">{characterClass.name}</div>
                </div>
            ))}
        </div>
    );
};
