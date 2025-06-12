<?php

namespace App\Controller;

use App\Entity\UserCharacter;
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

            $data = json_decode($request->getContent(), true);

            if (!isset($data['user_id'])) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'Missing required fields'
                ], 400);
            }

            $userCharacters = $this->entityManager->getRepository(UserCharacter::class)
                ->findBy(['user' => $data['user_id']]);

            $characters = [];

            foreach ($userCharacters as $character) {
                $characters[$character->getId()] = [
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
                ];
            }
                
            return new JsonResponse([
                'success' => true,
                'characters' => $characters
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}