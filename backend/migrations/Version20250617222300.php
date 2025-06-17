<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250617222300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add current_location to user_characters table';
    }

    public function up(Schema $schema): void
    {
        // Add current_location_id column as nullable first
        $this->addSql('ALTER TABLE user_characters ADD current_location_id INT');

        // Set Eldermarch as default location for existing characters
        $this->addSql('UPDATE user_characters SET current_location_id = (SELECT id FROM "location" WHERE name = \'Eldermarch\')');

        // Make it NOT NULL after setting values
        $this->addSql('ALTER TABLE user_characters ALTER COLUMN current_location_id SET NOT NULL');

        // Add foreign key constraint
        $this->addSql('ALTER TABLE user_characters ADD CONSTRAINT fk_1483a5e96bf700bf FOREIGN KEY (current_location_id) REFERENCES public."location"(id)');
    }

    public function down(Schema $schema): void
    {
        // Drop foreign key constraint first
        $this->addSql('ALTER TABLE user_characters DROP CONSTRAINT FK_1483A5E96BF700BF');

        // Drop column
        $this->addSql('ALTER TABLE user_characters DROP COLUMN current_location_id CASCADE');
    }
}
