<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206074946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, fio VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, date_birth TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, salary_type VARCHAR(50) NOT NULL, payment_schedule VARCHAR(50) NOT NULL, salary DOUBLE PRECISION NOT NULL, hour_tariff DOUBLE PRECISION NOT NULL, commission_rate DOUBLE PRECISION NOT NULL, is_union_affiliation BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP TABLE employee');
    }
}
