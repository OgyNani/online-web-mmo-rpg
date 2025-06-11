<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611194429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE class_base_stats_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE class_base_stats (id INT NOT NULL, character_id INT NOT NULL, raw_hp INT NOT NULL, raw_defence INT NOT NULL, raw_attack INT NOT NULL, raw_luck INT NOT NULL, max_raw_hp INT NOT NULL, max_raw_defence INT NOT NULL, max_raw_attack INT NOT NULL, max_raw_luck INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_5C6104DA1136BE75 ON class_base_stats (character_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE class_base_stats ADD CONSTRAINT FK_5C6104DA1136BE75 FOREIGN KEY (character_id) REFERENCES "character_class" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE class_base_stats_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE class_base_stats DROP CONSTRAINT FK_5C6104DA1136BE75
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE class_base_stats
        SQL);
    }
}
