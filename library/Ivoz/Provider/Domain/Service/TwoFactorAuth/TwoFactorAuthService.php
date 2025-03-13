<?php

namespace Ivoz\Provider\Domain\Service\TwoFactorAuth;

use Ivoz\Provider\Domain\Model\User\UserInterface;
use Ivoz\Provider\Domain\Model\User\UserRepository;

class TwoFactorAuthService
{
    private TotpService $totpService;
    private UserRepository $userRepository;

    public function __construct(
        TotpService $totpService,
        UserRepository $userRepository
    ) {
        $this->totpService = $totpService;
        $this->userRepository = $userRepository;
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
        
        // Update user
        $user->setTwoFactorSecret($secret);
        $user->setTwoFactorBackupCodes(json_encode($backupCodes));
        $user->setTwoFactorEnabled(true);
        
        return $secret;
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

        // Check if it's a backup code
        if (strlen($code) === 9) {
            return $this->verifyBackupCode($user, $code);
        }

        // Verify TOTP code
        return $this->totpService->verify($secret, $code);
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
        $user->setTwoFactorBackupCodes(json_encode($backupCodes));
        
        return $backupCodes;
    }
}