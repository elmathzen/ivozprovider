<?php

namespace Controller\Auth;

use Doctrine\ORM\EntityManagerInterface;
use Ivoz\Provider\Domain\Model\User\User;
use Ivoz\Provider\Domain\Model\User\UserInterface;
use Ivoz\Provider\Domain\Service\TwoFactorAuth\TwoFactorAuthService;
use Model\Token;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class TwoFactorAuthController
{
    private TwoFactorAuthService $twoFactorAuthService;
    private TokenStorageInterface $tokenStorage;
    private JWTTokenManagerInterface $jwtManager;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TwoFactorAuthService $twoFactorAuthService,
        TokenStorageInterface $tokenStorage,
        JWTTokenManagerInterface $jwtManager,
        EntityManagerInterface $entityManager
    ) {
        $this->twoFactorAuthService = $twoFactorAuthService;
        $this->tokenStorage = $tokenStorage;
        $this->jwtManager = $jwtManager;
        $this->entityManager = $entityManager;
    }

    /**
     * Verify 2FA code and issue a full JWT token
     */
    public function verify(Request $request): Response
    {
        try {
            $content = json_decode($request->getContent(), true);
            if (!isset($content['code'])) {
                return new JsonResponse(['error' => 'Code is required'], Response::HTTP_BAD_REQUEST);
            }

            $code = $content['code'];
            $tempToken = $content['token'] ?? null;

            if (!$tempToken) {
                return new JsonResponse(['error' => 'Token is required'], Response::HTTP_BAD_REQUEST);
            }

            // Get user from temporary token
            $user = $this->getUserFromTempToken($tempToken);
            if (!$user) {
                return new JsonResponse(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
            }

            // Verify the code
            $isValid = $this->twoFactorAuthService->verifyCode($user, $code);
            if (!$isValid) {
                return new JsonResponse(['error' => 'Invalid code'], Response::HTTP_UNAUTHORIZED);
            }

            // Generate a full JWT token
            $token = $this->jwtManager->create($user);

            return new JsonResponse(['token' => $token]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Enable 2FA for the current user
     */
    public function enable(Request $request): Response
    {
        try {
            $user = $this->getCurrentUser();
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $secret = $this->twoFactorAuthService->enableTwoFactor($user);
            $qrCodeUrl = $this->twoFactorAuthService->getQrCodeUrl($user);
            $backupCodes = $this->twoFactorAuthService->getBackupCodes($user);

            return new JsonResponse([
                'secret' => $secret,
                'qrCodeUrl' => $qrCodeUrl,
                'backupCodes' => $backupCodes
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Disable 2FA for the current user
     */
    public function disable(Request $request): Response
    {
        try {
            $user = $this->getCurrentUser();
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $this->twoFactorAuthService->disableTwoFactor($user);

            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Regenerate backup codes for the current user
     */
    public function regenerateBackupCodes(Request $request): Response
    {
        try {
            $user = $this->getCurrentUser();
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $backupCodes = $this->twoFactorAuthService->regenerateBackupCodes($user);

            return new JsonResponse(['backupCodes' => $backupCodes]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Verify setup code during 2FA enablement
     */
    public function verifySetup(Request $request): Response
    {
        try {
            $user = $this->getCurrentUser();
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $content = json_decode($request->getContent(), true);
            if (!isset($content['code']) || !isset($content['secret'])) {
                return new JsonResponse(['error' => 'Code and secret are required'], Response::HTTP_BAD_REQUEST);
            }

            $code = $content['code'];
            $secret = $content['secret'];

            // Temporarily set the secret for verification
            $user->setTwoFactorSecret($secret);
            
            // Verify the code
            $isValid = $this->twoFactorAuthService->verifyCode($user, $code);
            
            if (!$isValid) {
                return new JsonResponse(['error' => 'Invalid verification code'], Response::HTTP_BAD_REQUEST);
            }

            // If valid, enable 2FA with the verified secret
            $this->twoFactorAuthService->enableTwoFactor($user);

            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get the current user
     */
    private function getCurrentUser(): ?UserInterface
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            throw new AccessDeniedException('No token found');
        }

        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            throw new AccessDeniedException('User not found');
        }

        return $user;
    }

    /**
     * Get user from temporary token
     */
    private function getUserFromTempToken(string $tempToken): ?UserInterface
    {
        try {
            // Parse the JWT token
            $tokenData = $this->jwtManager->parse($tempToken);
            
            // Check if this is a temporary token
            if (!isset($tokenData['temp']) || $tokenData['temp'] !== true) {
                return null;
            }
            
            // Get the user ID from the token
            $userId = $tokenData['id'] ?? null;
            if (!$userId) {
                return null;
            }
            
            // Get the user from the repository
            $user = $this->entityManager->getRepository(User::class)->find($userId);
            if (!$user instanceof UserInterface) {
                return null;
            }
            
            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }
}