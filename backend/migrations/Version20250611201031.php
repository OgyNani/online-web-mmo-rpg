<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611201031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE user_characters_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_characters (id INT NOT NULL, user_id INT NOT NULL, class_id INT NOT NULL, race_id INT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(1) NOT NULL, level INT NOT NULL, exp INT NOT NULL, current_hp INT NOT NULL, hp INT NOT NULL, defence INT NOT NULL, attack INT NOT NULL, luck INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9D4E87E2A76ED395 ON user_characters (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9D4E87E2EA000B10 ON user_characters (class_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9D4E87E26E59D40D ON user_characters (race_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_characters ADD CONSTRAINT FK_9D4E87E2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_characters ADD CONSTRAINT FK_9D4E87E2EA000B10 FOREIGN KEY (class_id) REFERENCES "character_class" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_characters ADD CONSTRAINT FK_9D4E87E26E59D40D FOREIGN KEY (race_id) REFERENCES "race" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE user_characters_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_characters DROP CONSTRAINT FK_9D4E87E2A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_characters DROP CONSTRAINT FK_9D4E87E2EA000B10
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_characters DROP CONSTRAINT FK_9D4E87E26E59D40D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_characters
        SQL);
    }
}
