<?php

namespace App\Controller;

use App\Entity\UserCharacter;
use App\Entity\CharacterClass;
use App\Entity\Race;
use App\Entity\ClassBaseStats;
use App\Entity\CharacterStatus;
use App\Entity\Location;
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
            $user = $this->security->getUser();
            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            $data = json_decode($request->getContent(), true);
            
            if (!isset($data['name'], $data['classId'], $data['raceId'], $data['sex'])) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Missing required fields'
                ], 400);
            }

            $existingCharacter = $this->entityManager->getRepository(UserCharacter::class)
                ->findOneBy(['name' => $data['name']]);
            
            if ($existingCharacter) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Character name is already taken'
                ], 400);
            }

            $class = $this->entityManager->getRepository(CharacterClass::class)->find($data['classId']);
            $race = $this->entityManager->getRepository(Race::class)->find($data['raceId']);

            if (!$class || !$race) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Invalid class or race'
                ], 400);
            }

            $baseStats = $this->entityManager->getRepository(ClassBaseStats::class)
                ->findOneBy(['characterClass' => $class]);

            $aliveStatus = $this->entityManager->getRepository(CharacterStatus::class)
                ->findOneBy(['status' => 'alive']);

            $startLocation = $this->entityManager->getRepository(Location::class)
                ->findOneBy(['name' => 'Eldermarch']);

            if (!$baseStats || !$aliveStatus || !$startLocation) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Class base stats not found'
                ], 500);
            }

            if (!$aliveStatus) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Character status "alive" not found'
                ], 500);
            }

            if (!$startLocation) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Starting location "Eldermarch" not found'
                ], 500);
            }

            $character = new UserCharacter();
            $character->setUser($user);
            $character->setName($data['name']);
            $character->setClass($class);
            $character->setRace($race);
            $character->setSex($data['sex']);
            $character->setLevel(1);
            $character->setExp(0);
            
            $character->setCurrentHp($baseStats->getRawHp());
            $character->setHp($baseStats->getRawHp());
            $character->setDefence($baseStats->getRawDefence());
            $character->setAttack($baseStats->getRawAttack());
            $character->setLuck($baseStats->getRawLuck());
            $character->setSpeed($baseStats->getRawSpeed());
            $character->setStatus($aliveStatus);
            $character->setCurrentLocation($startLocation);

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
                    'status' => $character->getStatus(),
                    'location' => $character->getCurrentLocation(),
                    'stats' => [
                        'hp' => $character->getHp(),
                        'currentHp' => $character->getCurrentHp(),
                        'defence' => $character->getDefence(),
                        'attack' => $character->getAttack(),
                        'luck' => $character->getLuck(),
                        'speed' => $character->getSpeed()
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
