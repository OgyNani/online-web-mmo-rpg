<?php

namespace App\Controller;

use App\Entity\UserCharacter;
use App\Entity\CharacterClass;
use App\Entity\Race;
use App\Entity\ClassBaseStats;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CharacterController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function createCharacter(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            // Validate required fields
            if (!isset($data['name'], $data['classId'], $data['raceId'], $data['sex'])) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Missing required fields'
                ], 400);
            }

            // Check if name is already taken
            $existingCharacter = $this->entityManager->getRepository(UserCharacter::class)
                ->findOneBy(['name' => $data['name']]);
            
            if ($existingCharacter) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Character name is already taken'
                ], 400);
            }

            // Get the current user
            $user = $this->security->getUser();
            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            // Get class and race entities
            $class = $this->entityManager->getRepository(CharacterClass::class)->find($data['classId']);
            $race = $this->entityManager->getRepository(Race::class)->find($data['raceId']);

            if (!$class || !$race) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Invalid class or race'
                ], 400);
            }

            // Get base stats for the class
            $baseStats = $this->entityManager->getRepository(ClassBaseStats::class)
                ->findOneBy(['characterClass' => $class]);

            if (!$baseStats) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Class base stats not found'
                ], 500);
            }

            // Create new character
            $character = new UserCharacter();
            $character->setUser($user);
            $character->setName($data['name']);
            $character->setClass($class);
            $character->setRace($race);
            $character->setSex($data['sex']);
            $character->setLevel(1);
            $character->setExp(0);
            
            // Set initial stats from class base stats
            $character->setCurrentHp($baseStats->getRawHp());
            $character->setHp($baseStats->getRawHp());
            $character->setDefence($baseStats->getRawDefence());
            $character->setAttack($baseStats->getRawAttack());
            $character->setLuck($baseStats->getRawLuck());

            $this->entityManager->persist($character);
            $this->entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Character created successfully',
                'character' => [
                    'id' => $character->getId(),
                    'name' => $character->getName(),
                    'class' => $character->getClass()->getName(),
                    'race' => $character->getRace()->getName(),
                    'sex' => $character->getSex(),
                    'level' => $character->getLevel(),
                    'stats' => [
                        'hp' => $character->getHp(),
                        'currentHp' => $character->getCurrentHp(),
                        'defence' => $character->getDefence(),
                        'attack' => $character->getAttack(),
                        'luck' => $character->getLuck()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
