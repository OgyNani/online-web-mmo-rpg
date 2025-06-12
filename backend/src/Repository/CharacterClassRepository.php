<?php

namespace App\Repository;

use App\Entity\CharacterClass;
use App\Entity\ClassBaseStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CharacterClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterClass::class);
    }

    public function findAllWithStats()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.stats', 'stats')
            ->addSelect('stats')
            ->getQuery()
            ->getResult();
    }
}
