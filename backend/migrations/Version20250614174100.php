<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614174100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add columns with default values
        $this->addSql('ALTER TABLE class_base_stats ADD raw_speed INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE class_base_stats ADD max_raw_speed INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE user_characters ADD speed INT NOT NULL DEFAULT 0');

        // Update class stats
        $this->addSql("UPDATE class_base_stats cbs SET raw_speed = 0, max_raw_speed = 50 WHERE character_id IN (SELECT id FROM character_class WHERE name = 'Warrior')");
        $this->addSql("UPDATE class_base_stats cbs SET raw_speed = 0, max_raw_speed = 25 WHERE character_id IN (SELECT id FROM character_class WHERE name = 'Mage')");
        $this->addSql("UPDATE class_base_stats cbs SET raw_speed = 0, max_raw_speed = 75 WHERE character_id IN (SELECT id FROM character_class WHERE name = 'Hunter')");
        $this->addSql("UPDATE class_base_stats cbs SET raw_speed = 0, max_raw_speed = 75 WHERE character_id IN (SELECT id FROM character_class WHERE name = 'Rogue')");
        $this->addSql("UPDATE class_base_stats cbs SET raw_speed = 0, max_raw_speed = 25 WHERE character_id IN (SELECT id FROM character_class WHERE name = 'Priest')");
        $this->addSql("UPDATE class_base_stats cbs SET raw_speed = 0, max_raw_speed = 50 WHERE character_id IN (SELECT id FROM character_class WHERE name = 'Paladin')");

        // Remove default constraints
        $this->addSql('ALTER TABLE class_base_stats ALTER COLUMN raw_speed DROP DEFAULT');
        $this->addSql('ALTER TABLE class_base_stats ALTER COLUMN max_raw_speed DROP DEFAULT');
        $this->addSql('ALTER TABLE user_characters ALTER COLUMN speed DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE class_base_stats DROP COLUMN raw_speed');
        $this->addSql('ALTER TABLE class_base_stats DROP COLUMN max_raw_speed');
        $this->addSql('ALTER TABLE user_characters DROP COLUMN speed');
    }
}
