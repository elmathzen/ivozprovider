<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\LoggableMigration;

final class Version20250313231900 extends LoggableMigration
{
    public function getDescription(): string
    {
        return 'Add two-factor authentication fields to Users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE Users ADD twoFactorEnabled TINYINT(1) UNSIGNED NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE Users ADD twoFactorSecret VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE Users ADD twoFactorBackupCodes VARCHAR(1000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE Users DROP twoFactorEnabled');
        $this->addSql('ALTER TABLE Users DROP twoFactorSecret');
        $this->addSql('ALTER TABLE Users DROP twoFactorBackupCodes');
    }
}