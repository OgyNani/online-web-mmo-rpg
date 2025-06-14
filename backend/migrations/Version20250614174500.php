<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250614174500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make id columns SERIAL';
    }

    public function up(Schema $schema): void
    {
        // Create sequences for each table if they don't exist and set their current values
        $tables = [
            'character_class', 'character_equipment', 'character_inventory',
            'class_base_stats', 'item', 'item_rarity', 'item_type', 'location',
            'mob', 'npc', 'npc_type', 'race', 'user_characters', 'users',
            'user_vault', 'user_vault_slot'
        ];

        foreach ($tables as $table) {
            // Create sequence if it doesn't exist
            $this->addSql(sprintf('DO $$
                BEGIN
                    CREATE SEQUENCE IF NOT EXISTS %s_id_seq;
                    -- Try to set sequence value only if table and column exist
                    IF EXISTS (
                        SELECT 1 FROM information_schema.columns 
                        WHERE table_name = \'%s\' 
                        AND column_name = \'id\'
                    ) THEN
                        -- Get current max value
                        DECLARE
                            max_id integer;
                        BEGIN
                            EXECUTE \'SELECT COALESCE(MAX(id), 0) + 1 FROM \' || quote_ident(\'%s\') INTO max_id;
                            PERFORM setval(\'%s_id_seq\', max_id, false);
                        END;

                        -- Set default value if it doesn\'t have one
                        IF NOT EXISTS (
                            SELECT 1 FROM information_schema.columns 
                            WHERE table_name = \'%s\' 
                            AND column_name = \'id\' 
                            AND column_default IS NOT NULL
                        ) THEN
                            EXECUTE \'ALTER TABLE \' || quote_ident(\'%s\') || \' ALTER COLUMN id SET DEFAULT nextval(\'\'\' || quote_ident(\'%s_id_seq\') || \'\'\')\';
                        END IF;
                    END IF;
                END
                $$;', $table, $table, $table, $table, $table, $table, $table));
        }
    }

    public function down(Schema $schema): void
    {
        // We can't safely roll this back without knowing which sequences existed before
        $this->addSql('-- Migration cannot be reverted');
    }
}
