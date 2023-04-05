<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\LoggableMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324084602 extends LoggableMigration
{
    public function getDescription(): string
    {
        return 'Add holidayEnable field to ExternalCallFilters table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ExternalCallFilters ADD holidayEnabled TINYINT(1) UNSIGNED DEFAULT \'1\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ExternalCallFilters DROP holidayEnabled');
    }
}
