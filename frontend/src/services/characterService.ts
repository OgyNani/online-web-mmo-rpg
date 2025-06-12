import { CharacterClass, CharacterFormData, CharacterRace } from '../types/character';

const API_URL = 'http://localhost:8000/api';

export const characterService = {
    async getClasses(): Promise<CharacterClass[]> {
        const token = localStorage.getItem('token');
        const headers: Record<string, string> = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };

        const response = await fetch(`${API_URL}/classes`, { headers });
        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.error || 'Failed to load character classes');
        }
        
        return data.data;
    },

    async getRaces(): Promise<CharacterRace[]> {
        const token = localStorage.getItem('token');
        const headers: Record<string, string> = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };

        const response = await fetch(`${API_URL}/races`, { headers });
        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.error || 'Failed to load races');
        }
        
        return data.data;
    },

    async createCharacter(formData: CharacterFormData): Promise<void> {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('Not authenticated. Please log in.');
        }

        const response = await fetch(`${API_URL}/create-character`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.error || 'Failed to create character');
        }
    }
};
