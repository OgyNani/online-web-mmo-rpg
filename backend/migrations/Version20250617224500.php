<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250617224500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add available_char_slots to user table';
    }

    public function up(Schema $schema): void
    {
        // Add available_char_slots column as nullable first
        $this->addSql('ALTER TABLE "user" ADD available_char_slots INT');

        // Set default value 1 for existing users
        $this->addSql('UPDATE "user" SET available_char_slots = 1');

        // Make it NOT NULL after setting values
        $this->addSql('ALTER TABLE "user" ALTER COLUMN available_char_slots SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" DROP COLUMN available_char_slots');
    }
}
