<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    private const RACES = [
        'Human',
        'Orc',
        'Dwarf',
        'Elf'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::RACES as $raceName) {
            $race = new Race();
            $race->setName($raceName);
            $manager->persist($race);
        }

        $manager->flush();
    }
}
