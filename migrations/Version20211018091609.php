<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018091609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD date_of_birth TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('UPDATE "user" SET date_of_birth=\'1990-01-01\'');
        $this->addSql('ALTER TABLE "user" ALTER COLUMN date_of_birth SET NOT NULL');

        $this->addSql('ALTER TABLE "user" ADD phone VARCHAR(255)');
        $this->addSql('UPDATE "user" SET phone=\'+79999999999\'');
        $this->addSql('ALTER TABLE "user" ALTER COLUMN phone SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP date_of_birth');
        $this->addSql('ALTER TABLE "user" DROP phone');
    }
}
