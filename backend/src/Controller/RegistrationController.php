<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\AccountStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['username'])) {
            return $this->json([
                'error' => 'Missing required fields'
            ], Response::HTTP_BAD_REQUEST);
        }

        $existingUser = $entityManager->getRepository(User::class)->findOneBy([
            'email' => $data['email']
        ]);

        if ($existingUser) {
            return $this->json([
                'error' => 'Email already exists'
            ], Response::HTTP_CONFLICT);
        }

        $existingUsername = $entityManager->getRepository(User::class)->findOneBy([
            'username' => $data['username']
        ]);

        if ($existingUsername) {
            return $this->json([
                'error' => 'Username already exists'
            ], Response::HTTP_CONFLICT);
        }

        $activeStatus = $this->entityManager->getRepository(AccountStatus::class)
            ->findOneBy(['status' => 'active']);

        if (!$activeStatus) {
            return $this->json([
                'success' => false,
                'error' => 'Account status "active" not found'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setRoles(['ROLE_PLAYER']);
        $user->setIsActive(true);
        $user->setStatus($activeStatus);
        $user->setAvailableCharSlots(1);

        $user->generateApiToken();
        
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'User registered successfully',
            'token' => $user->getApiToken(),
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'roles' => $user->getRoles()
            ]
        ], Response::HTTP_CREATED);
    }
}
