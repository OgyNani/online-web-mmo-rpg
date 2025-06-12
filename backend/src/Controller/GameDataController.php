<?php

namespace App\Controller;

use App\Entity\CharacterClass;
use App\Entity\Race;
use App\Repository\CharacterClassRepository;
use App\Repository\ClassBaseStatsRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class GameDataController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CharacterClassRepository $classRepository,
        private ClassBaseStatsRepository $classBaseStatsRepository,
        private RaceRepository $raceRepository
    ) {}

    #[Route('/classes', name: 'get_classes', methods: ['GET'])]
    public function getClasses(): JsonResponse
    {
        try {
            $classes = $this->classRepository->findAllWithStats();
            $data = array_map(function($class) {
                $stats = $class->getStats();
                
                $baseStats = [
                    'strength' => $stats ? $stats->getRawAttack() : 10,
                    'dexterity' => $stats ? $stats->getRawDefence() : 10,
                    'intelligence' => $stats ? $stats->getRawLuck() : 10,
                    'vitality' => $stats ? $stats->getRawHp() : 10,
                    'wisdom' => $stats ? $stats->getRawLuck() : 10
                ];
                
                $maxStats = [
                    'strength' => $stats ? $stats->getMaxRawAttack() : 100,
                    'dexterity' => $stats ? $stats->getMaxRawDefence() : 100,
                    'intelligence' => $stats ? $stats->getMaxRawLuck() : 100,
                    'vitality' => $stats ? $stats->getMaxRawHp() : 100,
                    'wisdom' => $stats ? $stats->getMaxRawLuck() : 100
                ];
                
                return [
                    'id' => $class->getId(),
                    'name' => $class->getName(),
                    'baseStats' => $baseStats,
                    'maxStats' => $maxStats
                ];
            }, $classes);
            
            return new JsonResponse([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/races', name: 'get_races', methods: ['GET'])]
    public function getRaces(): JsonResponse
    {
        try {
            $races = $this->raceRepository->findAll();
            $data = array_map(function($race) {
                return [
                    'id' => $race->getId(),
                    'name' => $race->getName()
                ];
            }, $races);
            
            return new JsonResponse([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
