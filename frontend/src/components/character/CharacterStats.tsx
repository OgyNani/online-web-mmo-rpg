import React from 'react';
import { Table } from 'react-bootstrap';
import { CharacterStats } from '../../types/character';

interface StatsTableProps {
    baseStats: CharacterStats;
    maxStats: CharacterStats;
}

export const StatsTable: React.FC<StatsTableProps> = ({ baseStats, maxStats }) => {
    return (
        <div className="stats-table">
            <h3 className="mb-3">Character Stats</h3>
            <table>
                <thead>
                    <tr>
                        <th>Stat</th>
                        <th>Base</th>
                        <th>Max</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Strength</td>
                        <td>{baseStats.strength}</td>
                        <td>{maxStats.strength}</td>
                    </tr>
                    <tr>
                        <td>Dexterity</td>
                        <td>{baseStats.dexterity}</td>
                        <td>{maxStats.dexterity}</td>
                    </tr>
                    <tr>
                        <td>Intelligence</td>
                        <td>{baseStats.intelligence}</td>
                        <td>{maxStats.intelligence}</td>
                    </tr>
                    <tr>
                        <td>Vitality</td>
                        <td>{baseStats.vitality}</td>
                        <td>{maxStats.vitality}</td>
                    </tr>
                    <tr>
                        <td>Wisdom</td>
                        <td>{baseStats.wisdom}</td>
                        <td>{maxStats.wisdom}</td>
                    </tr>
                    <tr>
                        <td>Speed</td>
                        <td>{baseStats.speed}</td>
                        <td>{maxStats.speed}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    );
};
