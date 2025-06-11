<?php

namespace App\DataFixtures;

use App\Entity\CharacterClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CharacterClassFixtures extends Fixture
{
    private const CLASSES = [
        'Warrior',
        'Mage',
        'Hunter',
        'Rogue',
        'Priest',
        'Paladin'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CLASSES as $className) {
            $class = new CharacterClass();
            $class->setName($className);
            $manager->persist($class);
        }

        $manager->flush();
    }
}
