<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020123546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD sex_id INT');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6495A2DB2A0 FOREIGN KEY (sex_id) REFERENCES sex (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D6495A2DB2A0 ON "user" (sex_id)');

        $this->addSql('UPDATE "user" SET sex_id=1');
        $this->addSql('ALTER TABLE "user" ALTER COLUMN sex_id SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6495A2DB2A0');
        $this->addSql('DROP INDEX IDX_8D93D6495A2DB2A0');
        $this->addSql('ALTER TABLE "user" DROP sex_id');
    }
}
