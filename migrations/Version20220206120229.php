<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206120229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE union_contribution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, fio VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, date_birth TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, salary_type VARCHAR(50) NOT NULL, payment_schedule VARCHAR(50) NOT NULL, salary DOUBLE PRECISION DEFAULT NULL, hour_tariff DOUBLE PRECISION DEFAULT NULL, commission_rate DOUBLE PRECISION DEFAULT NULL, is_union_affiliation BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE union_contribution (id INT NOT NULL, employee_id INT NOT NULL, sum DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_729870CA8C03F15C ON union_contribution (employee_id)');
        $this->addSql('ALTER TABLE union_contribution ADD CONSTRAINT FK_729870CA8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE union_contribution DROP CONSTRAINT FK_729870CA8C03F15C');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE union_contribution_id_seq CASCADE');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE union_contribution');
    }
}
