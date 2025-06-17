<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250617174600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add character_statuses and account_statuses tables';
    }

    public function up(Schema $schema): void
    {
        // Create character_statuses table
        $this->addSql('CREATE TABLE character_statuses (
            id SERIAL PRIMARY KEY,
            status VARCHAR(50) NOT NULL UNIQUE
        )');

        // Create account_statuses table
        $this->addSql('CREATE TABLE account_statuses (
            id SERIAL PRIMARY KEY,
            status VARCHAR(50) NOT NULL UNIQUE
        )');

        // Insert initial character statuses
        $this->addSql("INSERT INTO character_statuses (status) VALUES ('alive')");
        $this->addSql("INSERT INTO character_statuses (status) VALUES ('dead')");

        // Insert initial account statuses
        $this->addSql("INSERT INTO account_statuses (status) VALUES ('active')");
        $this->addSql("INSERT INTO account_statuses (status) VALUES ('suspend')");
        $this->addSql("INSERT INTO account_statuses (status) VALUES ('banned')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS character_statuses');
        $this->addSql('DROP TABLE IF EXISTS account_statuses');
    }
}
