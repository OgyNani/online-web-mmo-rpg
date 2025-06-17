<?php

namespace App\Controller;

use App\Entity\UserCharacter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class UserCharacterController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function getUserCharacters(Request $request): JsonResponse
    {
        try {
            $user = $this->security->getUser();
            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            $userCharacters = $this->entityManager->getRepository(UserCharacter::class)
                ->findBy(['user' => $user]);

            $characters = [];

            foreach ($userCharacters as $character) {
                $characters[$character->getId()] = [
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
                ];
            }
                
            $characterCount = count($userCharacters);
            return new JsonResponse([
                'success' => true,
                'characters' => $characters,
                'availableSlots' => $user->getAvailableCharSlots(),
                'characterCount' => $characterCount,
                'canCreateCharacter' => $characterCount < $user->getAvailableCharSlots()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}