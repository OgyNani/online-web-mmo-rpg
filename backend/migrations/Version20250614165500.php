<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614165500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE user_vault_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE user_vault_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_vault (id INT NOT NULL, user_id INT NOT NULL, vault_capacity INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_1DF2B279A76ED395 ON user_vault (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_vault_slot (id INT NOT NULL, vault_id INT NOT NULL, item_id INT DEFAULT NULL, item_custom_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FBBE9F7158AC2DF8 ON user_vault_slot (vault_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FBBE9F71126F525E ON user_vault_slot (item_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_vault ADD CONSTRAINT FK_1DF2B279A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_vault_slot ADD CONSTRAINT FK_FBBE9F7158AC2DF8 FOREIGN KEY (vault_id) REFERENCES user_vault (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_vault_slot ADD CONSTRAINT FK_FBBE9F71126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE user_vault_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE user_vault_slot_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_vault DROP CONSTRAINT FK_1DF2B279A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_vault_slot DROP CONSTRAINT FK_FBBE9F7158AC2DF8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_vault_slot DROP CONSTRAINT FK_FBBE9F71126F525E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_vault
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_vault_slot
        SQL);
    }
}
