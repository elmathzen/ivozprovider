<?php

namespace Ivoz\Provider\Domain\Service\TwoFactorAuth;

use Ivoz\Provider\Domain\Model\User\UserInterface;
use Ivoz\Provider\Domain\Model\User\UserRepository;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class TwoFactorAuthService
{
    private TotpService $totpService;
    private UserRepository $userRepository;
    private CacheItemPoolInterface $cache;
    
    // Maximum number of failed attempts before rate limiting
    private const MAX_ATTEMPTS = 5;
    
    // Lockout period in seconds (10 minutes)
    private const LOCKOUT_PERIOD = 600;

    public function __construct(
        TotpService $totpService,
        UserRepository $userRepository,
        CacheItemPoolInterface $cache
    ) {
        $this->totpService = $totpService;
        $this->userRepository = $userRepository;
        $this->cache = $cache;
    }

    /**
     * Enable 2FA for a user
     */
    public function enableTwoFactor(UserInterface $user): string
    {
        // Generate a new secret
        $secret = $this->totpService->generateSecret();
        
        // Generate backup codes
        $backupCodes = $this->totpService->generateBackupCodes();
        
        // Validate backup codes format
        $this->validateBackupCodes($backupCodes);
        
        // Update user
        $user->setTwoFactorSecret($secret);
        $user->setTwoFactorBackupCodes(json_encode($backupCodes));
        $user->setTwoFactorEnabled(true);
        
        return $secret;
    }
    
    /**
     * Validate backup codes format
     *
     * @param array $backupCodes
     * @throws \InvalidArgumentException
     */
    private function validateBackupCodes(array $backupCodes): void
    {
        if (count($backupCodes) === 0) {
            throw new \InvalidArgumentException('Backup codes array cannot be empty');
        }
        
        foreach ($backupCodes as $code) {
            if (!is_string($code)) {
                throw new \InvalidArgumentException('Backup code must be a string');
            }
            
            if (strlen($code) !== 9) {
                throw new \InvalidArgumentException('Backup code must be 9 characters long');
            }
            
            if (!preg_match('/^\d{9}$/', $code)) {
                throw new \InvalidArgumentException('Backup code must contain only digits');
            }
        }
    }

    /**
     * Disable 2FA for a user
     */
    public function disableTwoFactor(UserInterface $user): void
    {
        $user->setTwoFactorSecret(null);
        $user->setTwoFactorBackupCodes(null);
        $user->setTwoFactorEnabled(false);
    }

    /**
     * Verify a TOTP code for a user
     */
    public function verifyCode(UserInterface $user, string $code): bool
    {
        if (!$user->getTwoFactorEnabled()) {
            return false;
        }

        $secret = $user->getTwoFactorSecret();
        if (!$secret) {
            return false;
        }
        
        // Check for rate limiting
        $userId = $user->getId();
        $cacheKey = 'two_factor_attempts_' . $userId;
        
        // Check if user is locked out
        $lockoutKey = 'two_factor_lockout_' . $userId;
        $lockoutItem = $this->cache->getItem($lockoutKey);
        if ($lockoutItem->isHit()) {
            throw new CustomUserMessageAuthenticationException('Too many failed attempts. Please try again later.');
        }
        
        // Check if it's a backup code
        if (strlen($code) === 9) {
            $isValid = $this->verifyBackupCode($user, $code);
        } else {
            // Verify TOTP code
            $isValid = $this->totpService->verify($secret, $code);
        }
        
        // If the code is valid, reset the attempts counter
        if ($isValid) {
            $this->cache->deleteItem($cacheKey);
            return true;
        }
        
        // If the code is invalid, increment the attempts counter
        $attemptsItem = $this->cache->getItem($cacheKey);
        $attempts = $attemptsItem->isHit() ? $attemptsItem->get() : 0;
        $attempts++;
        
        // If too many attempts, lock the account temporarily
        if ($attempts >= self::MAX_ATTEMPTS) {
            $lockoutItem->set(true);
            $lockoutItem->expiresAfter(self::LOCKOUT_PERIOD);
            $this->cache->save($lockoutItem);
            $this->cache->deleteItem($cacheKey);
            throw new CustomUserMessageAuthenticationException('Too many failed attempts. Please try again later.');
        }
        
        // Save the updated attempts counter
        $attemptsItem->set($attempts);
        $attemptsItem->expiresAfter(300); // 5 minutes
        $this->cache->save($attemptsItem);
        
        return false;
    }

    /**
     * Verify a backup code for a user
     */
    private function verifyBackupCode(UserInterface $user, string $code): bool
    {
        $backupCodesJson = $user->getTwoFactorBackupCodes();
        if (!$backupCodesJson) {
            return false;
        }

        $backupCodes = json_decode($backupCodesJson, true);
        if (!is_array($backupCodes)) {
            return false;
        }

        $index = array_search($code, $backupCodes);
        if ($index === false) {
            return false;
        }

        // Remove the used backup code
        unset($backupCodes[$index]);
        $user->setTwoFactorBackupCodes(json_encode(array_values($backupCodes)));

        return true;
    }

    /**
     * Get QR code URL for a user
     */
    public function getQrCodeUrl(UserInterface $user): ?string
    {
        $secret = $user->getTwoFactorSecret();
        if (!$secret) {
            return null;
        }

        $label = $user->getEmail() ?: $user->getFullName();
        $issuer = 'IvozProvider';

        return $this->totpService->getQrCodeUrl($label, $secret, $issuer);
    }

    /**
     * Get backup codes for a user
     */
    public function getBackupCodes(UserInterface $user): array
    {
        $backupCodesJson = $user->getTwoFactorBackupCodes();
        if (!$backupCodesJson) {
            return [];
        }

        $backupCodes = json_decode($backupCodesJson, true);
        if (!is_array($backupCodes)) {
            return [];
        }

        return $backupCodes;
    }

    /**
     * Generate new backup codes for a user
     */
    public function regenerateBackupCodes(UserInterface $user): array
    {
        $backupCodes = $this->totpService->generateBackupCodes();
        
        // Validate backup codes format
        $this->validateBackupCodes($backupCodes);
        
        $user->setTwoFactorBackupCodes(json_encode($backupCodes));
        
        return $backupCodes;
    }
}