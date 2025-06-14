<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614164654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE character_equipment (character_id INT NOT NULL, hat_id INT DEFAULT NULL, armor_id INT DEFAULT NULL, pants_id INT DEFAULT NULL, shoes_id INT DEFAULT NULL, weapon_id INT DEFAULT NULL, ability_id INT DEFAULT NULL, ring_id INT DEFAULT NULL, PRIMARY KEY(character_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B88C6A5980 ON character_equipment (hat_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B8F5AA3663 ON character_equipment (armor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B83A9532DD ON character_equipment (pants_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B8B75E1D7A ON character_equipment (shoes_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B895B82273 ON character_equipment (weapon_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B88016D8B2 ON character_equipment (ability_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_546877B8D0935A5A ON character_equipment (ring_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE character_inventory (item_custom_id VARCHAR(255) NOT NULL, character_id INT NOT NULL, item_id INT NOT NULL, PRIMARY KEY(character_id, item_custom_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_367DE80D1136BE75 ON character_inventory (character_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_367DE80D126F525E ON character_inventory (item_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B81136BE75 FOREIGN KEY (character_id) REFERENCES user_characters (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B88C6A5980 FOREIGN KEY (hat_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B8F5AA3663 FOREIGN KEY (armor_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B83A9532DD FOREIGN KEY (pants_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B8B75E1D7A FOREIGN KEY (shoes_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B895B82273 FOREIGN KEY (weapon_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B88016D8B2 FOREIGN KEY (ability_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment ADD CONSTRAINT FK_546877B8D0935A5A FOREIGN KEY (ring_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_inventory ADD CONSTRAINT FK_367DE80D1136BE75 FOREIGN KEY (character_id) REFERENCES user_characters (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_inventory ADD CONSTRAINT FK_367DE80D126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B81136BE75
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B88C6A5980
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B8F5AA3663
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B83A9532DD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B8B75E1D7A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B895B82273
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B88016D8B2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_equipment DROP CONSTRAINT FK_546877B8D0935A5A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_inventory DROP CONSTRAINT FK_367DE80D1136BE75
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character_inventory DROP CONSTRAINT FK_367DE80D126F525E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE character_equipment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE character_inventory
        SQL);
    }
}
