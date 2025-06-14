import React from 'react';
import { UserCharacter } from '../../types/character';
import './characterList.css';

interface CharacterListProps {
    characters: UserCharacter[];
    selectedCharacter: UserCharacter | null;
    onSelectCharacter: (character: UserCharacter) => void;
}

export const CharacterList: React.FC<CharacterListProps> = ({ characters, selectedCharacter, onSelectCharacter }) => {
    return (
        <div className="character-list">
            {characters.map((character, index) => (
                <div 
                    key={character.id || index}
                    className={`character-slot ${character.name && selectedCharacter?.name === character.name ? 'selected' : ''}`}
                    onClick={() => onSelectCharacter(character)}
                >
                    <div className="character-icon">
                        {character.name ? (
                            <>
                                <div className="char-class-icon">{character.class[0]}</div>
                                <div className="char-info">
                                    <div className="char-name">{character.name}</div>
                                    <div className="char-details">
                                        Level {character.level || 1} {character.class}
                                    </div>
                                </div>
                            </>
                        ) : (
                            <div className="empty-slot">Empty Character Slot</div>
                        )}
                    </div>
                </div>
            ))}
        </div>
    );
};
