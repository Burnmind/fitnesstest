<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021034858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_group_fitness_classes');
        $this->addSql('ALTER TABLE subscription ADD subscribed_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD group_fitness_class_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D36A3D54E9 FOREIGN KEY (subscribed_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A2C6A548 FOREIGN KEY (group_fitness_class_id) REFERENCES group_fitness_classes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A3C664D36A3D54E9 ON subscription (subscribed_user_id)');
        $this->addSql('CREATE INDEX IDX_A3C664D3A2C6A548 ON subscription (group_fitness_class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE user_group_fitness_classes (user_id INT NOT NULL, group_fitness_classes_id INT NOT NULL, PRIMARY KEY(user_id, group_fitness_classes_id))');
        $this->addSql('CREATE INDEX idx_b671201cdd2e4a51 ON user_group_fitness_classes (group_fitness_classes_id)');
        $this->addSql('CREATE INDEX idx_b671201ca76ed395 ON user_group_fitness_classes (user_id)');
        $this->addSql('ALTER TABLE user_group_fitness_classes ADD CONSTRAINT fk_b671201ca76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_fitness_classes ADD CONSTRAINT fk_b671201cdd2e4a51 FOREIGN KEY (group_fitness_classes_id) REFERENCES group_fitness_classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT FK_A3C664D36A3D54E9');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT FK_A3C664D3A2C6A548');
        $this->addSql('DROP INDEX IDX_A3C664D36A3D54E9');
        $this->addSql('DROP INDEX IDX_A3C664D3A2C6A548');
        $this->addSql('ALTER TABLE subscription DROP subscribed_user_id');
        $this->addSql('ALTER TABLE subscription DROP group_fitness_class_id');
    }
}
