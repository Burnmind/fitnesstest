<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020153513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscription (id INT NOT NULL, contact_type_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A3C664D35F63AD12 ON subscription (contact_type_id)');
        $this->addSql('CREATE TABLE subscription_contact (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_group_fitness_classes (user_id INT NOT NULL, group_fitness_classes_id INT NOT NULL, PRIMARY KEY(user_id, group_fitness_classes_id))');
        $this->addSql('CREATE INDEX IDX_B671201CA76ED395 ON user_group_fitness_classes (user_id)');
        $this->addSql('CREATE INDEX IDX_B671201CDD2E4A51 ON user_group_fitness_classes (group_fitness_classes_id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D35F63AD12 FOREIGN KEY (contact_type_id) REFERENCES subscription_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_fitness_classes ADD CONSTRAINT FK_B671201CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_fitness_classes ADD CONSTRAINT FK_B671201CDD2E4A51 FOREIGN KEY (group_fitness_classes_id) REFERENCES group_fitness_classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT FK_A3C664D35F63AD12');
        $this->addSql('DROP SEQUENCE subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_contact_id_seq CASCADE');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_contact');
        $this->addSql('DROP TABLE user_group_fitness_classes');
    }
}
