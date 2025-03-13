<?php

namespace Model;

class TwoFactor
{
    /**
     * @var string|null
     */
    private $secret;

    /**
     * @var string|null
     */
    private $qrCodeUrl;

    /**
     * @var array
     */
    private $backupCodes = [];

    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string|null $secret
     * @return TwoFactor
     */
    public function setSecret(?string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQrCodeUrl(): ?string
    {
        return $this->qrCodeUrl;
    }

    /**
     * @param string|null $qrCodeUrl
     * @return TwoFactor
     */
    public function setQrCodeUrl(?string $qrCodeUrl): self
    {
        $this->qrCodeUrl = $qrCodeUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function getBackupCodes(): array
    {
        return $this->backupCodes;
    }

    /**
     * @param array $backupCodes
     * @return TwoFactor
     */
    public function setBackupCodes(array $backupCodes): self
    {
        $this->backupCodes = $backupCodes;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return TwoFactor
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }
}