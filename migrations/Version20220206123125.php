<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206123125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pay_check_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pay_check (id INT NOT NULL, employee_id INT NOT NULL, sum DOUBLE PRECISION NOT NULL, union_contribution DOUBLE PRECISION NOT NULL, services_charge DOUBLE PRECISION NOT NULL, total_sum DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_746F038A8C03F15C ON pay_check (employee_id)');
        $this->addSql('ALTER TABLE pay_check ADD CONSTRAINT FK_746F038A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pay_check_id_seq CASCADE');
        $this->addSql('DROP TABLE pay_check');
    }
}
