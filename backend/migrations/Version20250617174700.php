<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250617174700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add status relationships to users and user_characters tables';
    }

    public function up(Schema $schema): void
    {
        // Add status_id columns as nullable first
        $this->addSql('ALTER TABLE "user" ADD status_id INT');
        $this->addSql('ALTER TABLE user_characters ADD status_id INT');

        // Set default statuses - 'active' for users and 'alive' for characters
        $this->addSql('UPDATE "user" SET status_id = (SELECT id FROM account_statuses WHERE status = \'active\')');
        $this->addSql('UPDATE user_characters SET status_id = (SELECT id FROM character_statuses WHERE status = \'alive\')');

        // Now make them NOT NULL after setting values
        $this->addSql('ALTER TABLE "user" ALTER COLUMN status_id SET NOT NULL');
        $this->addSql('ALTER TABLE user_characters ALTER COLUMN status_id SET NOT NULL');

        // Add foreign key constraints
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_1483A5E96BF700BD FOREIGN KEY (status_id) REFERENCES account_statuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_characters ADD CONSTRAINT FK_1483A5E96BF700BE FOREIGN KEY (status_id) REFERENCES character_statuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // Drop foreign key constraints first
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_1483A5E96BF700BD');
        $this->addSql('ALTER TABLE user_characters DROP CONSTRAINT FK_1483A5E96BF700BE');

        // Drop columns
        $this->addSql('ALTER TABLE "user" DROP COLUMN status_id');
        $this->addSql('ALTER TABLE user_characters DROP COLUMN status_id');
    }
}
