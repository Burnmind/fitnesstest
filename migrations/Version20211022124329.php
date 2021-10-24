<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022124329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO \"subscription_contact\" (id, name, code) VALUES (nextval('subscription_contact_id_seq'), 'Телефон', 'phone')");
        $this->addSql("INSERT INTO \"subscription_contact\" (id, name, code) VALUES (nextval('subscription_contact_id_seq'), 'Email', 'email')");
        $this->addSql("INSERT INTO \"sex\" (id, name) VALUES (nextval('sex_id_seq'), 'Мужской')");
        $this->addSql("INSERT INTO \"sex\" (id, name) VALUES (nextval('sex_id_seq'), 'Женский')");
        $this->addSql("INSERT INTO \"user\" (id, username, roles, password, full_name, is_verified, is_blocked, email,
            photo, date_of_birth, phone, sex_id) VALUES (nextval('user_id_seq'), 'admin', '[\"ROLE_ADMIN\"]', '\$argon2id\$v=19\$m=65536,t=4,p=1$34ha22VC+QgnSDEfsz7Mtw$6pKGqzTx1EU218iv8xJNTup93uGE7VaeNDRb1Tt+Mik', 'admin', true, false, 'admin@mail.ru', '', '1990-01-01 00:00:00', '+79999999999', 1)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
