<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\LoggableMigration;

/**
* Auto-generated Migration: Please modify to your needs!
*/
final class Version20240827113855 extends LoggableMigration
{
    public function getDescription(): string
    {
        return 'Added empty passwords for Administrators';
    }

    public function up(Schema $schema): void
    {
    // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Administrators CHANGE pass pass VARCHAR(80) DEFAULT \'\' COMMENT \'[password]\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Administrators CHANGE pass pass VARCHAR(80) NOT NULL COMMENT \'[password]\'');
    }
}