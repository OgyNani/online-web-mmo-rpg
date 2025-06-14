export interface CharacterFormData {
    name: string;
    classId: string;
    raceId: string;
    sex: string;
}

export interface CharacterStats {
    strength: number;
    dexterity: number;
    intelligence: number;
    vitality: number;
    wisdom: number;
}

export interface CharacterClass {
    id: number;
    name: string;
    baseStats: CharacterStats;
    maxStats: CharacterStats;
    iconUrl?: string;
    description: string;
}

export interface CharacterRace {
    id: string;
    name: string;
    description: string;
}

export interface UserCharacter {
    id: number | null;
    name: string;
    class: string;
    level: number;
    stats?: {
        hp: number;
        currentHp: number;
        defence: number;
        attack: number;
        luck: number;
    };
}
