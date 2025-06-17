<?php

namespace App\DataFixtures;

use App\Entity\CharacterClass;
use App\Entity\ClassBaseStats;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CharacterClassWithStatsFixtures extends Fixture
{
    private const CLASSES = [
        'Warrior' => [
            'raw_hp' => 100,
            'raw_defence' => 0,
            'raw_attack' => 0,
            'raw_luck' => 0,
            'max_raw_hp' => 800,
            'max_raw_defence' => 40,
            'max_raw_attack' => 60,
            'max_raw_luck' => 30,
        ],
        'Mage' => [
            'raw_hp' => 100,
            'raw_defence' => 0,
            'raw_attack' => 0,
            'raw_luck' => 0,
            'max_raw_hp' => 700,
            'max_raw_defence' => 25,
            'max_raw_attack' => 75,
            'max_raw_luck' => 50,
        ],
        'Hunter' => [
            'raw_hp' => 100,
            'raw_defence' => 0,
            'raw_attack' => 0,
            'raw_luck' => 0,
            'max_raw_hp' => 700,
            'max_raw_defence' => 25,
            'max_raw_attack' => 80,
            'max_raw_luck' => 50,
        ],
        'Rogue' => [
            'raw_hp' => 100,
            'raw_defence' => 0,
            'raw_attack' => 0,
            'raw_luck' => 0,
            'max_raw_hp' => 600,
            'max_raw_defence' => 20,
            'max_raw_attack' => 100,
            'max_raw_luck' => 60,
        ],
        'Priest' => [
            'raw_hp' => 100,
            'raw_defence' => 0,
            'raw_attack' => 0,
            'raw_luck' => 0,
            'max_raw_hp' => 800,
            'max_raw_defence' => 25,
            'max_raw_attack' => 50,
            'max_raw_luck' => 50,
        ],
        'Paladin' => [
            'raw_hp' => 100,
            'raw_defence' => 0,
            'raw_attack' => 0,
            'raw_luck' => 0,
            'max_raw_hp' => 900,
            'max_raw_defence' => 50,
            'max_raw_attack' => 55,
            'max_raw_luck' => 20,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CLASSES as $className => $stats) {
            $existingClass = $manager->getRepository(CharacterClass::class)->findOneBy(['name' => $className]);
            
            if (!$existingClass) {
                $class = new CharacterClass();
                $class->setName($className);
                $manager->persist($class);
                $manager->flush();
            } else {
                $class = $existingClass;
            }

            $existingStats = $manager->getRepository(ClassBaseStats::class)
                ->findOneBy(['characterClass' => $class]);

            if (!$existingStats) {
                $baseStats = new ClassBaseStats();
                $baseStats->setCharacterClass($class);
                $baseStats->setRawHp($stats['raw_hp']);
                $baseStats->setRawDefence($stats['raw_defence']);
                $baseStats->setRawAttack($stats['raw_attack']);
                $baseStats->setRawLuck($stats['raw_luck']);
                $baseStats->setMaxRawHp($stats['max_raw_hp']);
                $baseStats->setMaxRawDefence($stats['max_raw_defence']);
                $baseStats->setMaxRawAttack($stats['max_raw_attack']);
                $baseStats->setMaxRawLuck($stats['max_raw_luck']);
                
                $manager->persist($baseStats);
            }
        }

        $manager->flush();
    }
}
