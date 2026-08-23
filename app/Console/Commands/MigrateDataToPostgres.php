<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

#[Signature('data:migrate-postgres')]
#[Description('Migrates data from SQLite to PostgreSQL')]
class MigrateDataToPostgres extends Command
{
    public function handle()
    {
        $this->info('Starting data migration from SQLite to PostgreSQL...');

        $tables = DB::connection('sqlite')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        $tables = array_map(fn($t) => $t->name, $tables);

        // Disable foreign key checks for Postgres during migration
        // Note: Postgres uses session_replication_role for this
        DB::connection('pgsql')->statement("SET session_replication_role = 'replica';");

        foreach ($tables as $table) {
            if ($table === 'migrations') continue;
            
            $this->info("Migrating table: {$table}");
            
            // Clear existing data in target table
            DB::connection('pgsql')->table($table)->truncate();
            
            // Get all rows from source
            $rows = DB::connection('sqlite')->table($table)->get()->map(function($row) {
                return (array) $row;
            })->toArray();
            
            if (empty($rows)) {
                $this->line(" - No data to migrate for {$table}.");
                continue;
            }

            // Chunk inserts
            $chunks = array_chunk($rows, 500);
            $bar = $this->output->createProgressBar(count($chunks));
            $bar->start();

            foreach ($chunks as $chunk) {
                DB::connection('pgsql')->table($table)->insert($chunk);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->line(" - Migrated " . count($rows) . " rows for {$table}.");
            
            // Reset Postgres sequences so primary keys auto-increment correctly
            if (Schema::connection('pgsql')->hasColumn($table, 'id')) {
                try {
                    $maxId = DB::connection('pgsql')->table($table)->max('id') ?? 0;
                    if (is_numeric($maxId)) {
                        DB::connection('pgsql')->statement("SELECT setval('{$table}_id_seq', " . max($maxId, 1) . ", true)");
                    }
                } catch (\Exception $e) {
                    // Sequence might not exist, skip
                }
            }
        }

        DB::connection('pgsql')->statement("SET session_replication_role = 'origin';");

        $this->info('Data migration completed successfully!');
    }
}
