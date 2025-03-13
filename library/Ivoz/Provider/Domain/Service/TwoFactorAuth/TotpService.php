<?php

namespace Ivoz\Provider\Domain\Service\TwoFactorAuth;

/**
 * Time-based One-Time Password (TOTP) implementation
 * Based on RFC 6238 (https://tools.ietf.org/html/rfc6238)
 */
class TotpService
{
    private const ALGORITHM = 'sha1';
    private const DIGITS = 6;
    private const PERIOD = 30;
    private const SECRET_LENGTH = 16;

    /**
     * Generate a new random secret key
     */
    public function generateSecret(): string
    {
        $secret = random_bytes(self::SECRET_LENGTH);
        return $this->base32Encode($secret);
    }

    /**
     * Generate a QR code URL for the Google Authenticator app
     */
    public function getQrCodeUrl(string $label, string $secret, string $issuer = 'IvozProvider'): string
    {
        $url = sprintf(
            'otpauth://totp/%s:%s?secret=%s&issuer=%s&algorithm=%s&digits=%d&period=%d',
            urlencode($issuer),
            urlencode($label),
            $secret,
            urlencode($issuer),
            self::ALGORITHM,
            self::DIGITS,
            self::PERIOD
        );

        return $url;
    }

    /**
     * Verify a TOTP code
     */
    public function verify(string $secret, string $code, int $window = 1): bool
    {
        if (strlen($code) !== self::DIGITS) {
            return false;
        }

        $timestamp = time();
        
        // Check if the code is valid for any of the timestamps in the window
        for ($i = -$window; $i <= $window; $i++) {
            $checkTime = $timestamp + ($i * self::PERIOD);
            $generatedCode = $this->generateCode($secret, $checkTime);
            
            if (hash_equals($generatedCode, $code)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Generate a TOTP code for a specific timestamp
     */
    public function generateCode(string $secret, ?int $timestamp = null): string
    {
        if ($timestamp === null) {
            $timestamp = time();
        }

        // Calculate counter value (number of time steps)
        $timeStep = floor($timestamp / self::PERIOD);
        
        // Decode the secret from base32
        $decodedSecret = $this->base32Decode($secret);
        
        // Pack time into binary (64-bit)
        $binary = pack('J', $timeStep);
        
        // Generate HMAC hash
        $hash = hash_hmac(self::ALGORITHM, $binary, $decodedSecret, true);
        
        // Extract a 4-byte dynamic binary code from the hash
        $offset = ord($hash[strlen($hash) - 1]) & 0x0F;
        $value = (
            ((ord($hash[$offset]) & 0x7F) << 24) |
            ((ord($hash[$offset + 1]) & 0xFF) << 16) |
            ((ord($hash[$offset + 2]) & 0xFF) << 8) |
            (ord($hash[$offset + 3]) & 0xFF)
        );
        
        // Generate the code by taking modulo 10^DIGITS
        $modulo = pow(10, self::DIGITS);
        $code = str_pad($value % $modulo, self::DIGITS, '0', STR_PAD_LEFT);
        
        return $code;
    }

    /**
     * Generate backup codes
     */
    public function generateBackupCodes(int $count = 10): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = $this->generateBackupCode();
        }
        return $codes;
    }

    /**
     * Generate a single backup code
     */
    private function generateBackupCode(): string
    {
        $bytes = random_bytes(4);
        $value = unpack('N', $bytes)[1] % 1000000000;
        return str_pad((string) $value, 9, '0', STR_PAD_LEFT);
    }

    /**
     * Base32 encode
     */
    private function base32Encode(string $data): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $binary = '';
        $padding = 0;
        
        // Convert string to binary
        for ($i = 0; $i < strlen($data); $i++) {
            $binary .= str_pad(decbin(ord($data[$i])), 8, '0', STR_PAD_LEFT);
        }
        
        // Pad binary to multiple of 5 bits
        $padding = strlen($binary) % 5;
        if ($padding > 0) {
            $binary .= str_repeat('0', 5 - $padding);
        }
        
        // Convert 5-bit chunks to base32 characters
        $result = '';
        for ($i = 0; $i < strlen($binary); $i += 5) {
            $chunk = substr($binary, $i, 5);
            $result .= $alphabet[bindec($chunk)];
        }
        
        return $result;
    }

    /**
     * Base32 decode
     */
    private function base32Decode(string $data): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $binary = '';
        
        // Convert base32 characters to binary
        for ($i = 0; $i < strlen($data); $i++) {
            $char = $data[$i];
            $index = strpos($alphabet, $char);
            if ($index === false) {
                continue; // Skip invalid characters
            }
            $binary .= str_pad(decbin($index), 5, '0', STR_PAD_LEFT);
        }
        
        // Convert binary to string (8 bits per character)
        $result = '';
        for ($i = 0; $i + 8 <= strlen($binary); $i += 8) {
            $chunk = substr($binary, $i, 8);
            $result .= chr(bindec($chunk));
        }
        
        return $result;
    }
}