<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Services: ensure column rename and FK to employees
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'assigned_professional_id') && !Schema::hasColumn('services', 'assigned_employer_id')) {
                $this->dropForeignByColumnIfExists('services', 'assigned_professional_id');
                $table->renameColumn('assigned_professional_id', 'assigned_employer_id');
            }
        });

        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'assigned_employer_id')) {
                $this->dropForeignByColumnIfExists('services', 'assigned_employer_id');
                // Sanitize orphan values before creating FK
                DB::statement('UPDATE `services` s LEFT JOIN `employees` e ON e.id = s.assigned_employer_id SET s.assigned_employer_id = NULL WHERE s.assigned_employer_id IS NOT NULL AND e.id IS NULL');
                $table->foreign('assigned_employer_id')->references('id')->on('employees')->nullOnDelete();
            }
        });

        // appointment_services: ensure column rename and FK to employees
        Schema::table('appointment_services', function (Blueprint $table) {
            if (Schema::hasColumn('appointment_services', 'assigned_professional_id') && !Schema::hasColumn('appointment_services', 'assigned_employer_id')) {
                $this->dropForeignByColumnIfExists('appointment_services', 'assigned_professional_id');
                $table->renameColumn('assigned_professional_id', 'assigned_employer_id');
            }
        });

        Schema::table('appointment_services', function (Blueprint $table) {
            if (Schema::hasColumn('appointment_services', 'assigned_employer_id')) {
                $this->dropForeignByColumnIfExists('appointment_services', 'assigned_employer_id');
                // Sanitize orphan values before creating FK
                DB::statement('UPDATE `appointment_services` a LEFT JOIN `employees` e ON e.id = a.assigned_employer_id SET a.assigned_employer_id = NULL WHERE a.assigned_employer_id IS NOT NULL AND e.id IS NULL');
                $table->foreign('assigned_employer_id')->references('id')->on('employees')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        // appointment_services: revert FK to professionals and rename back if needed
        Schema::table('appointment_services', function (Blueprint $table) {
            if (Schema::hasColumn('appointment_services', 'assigned_employer_id')) {
                $this->dropForeignByColumnIfExists('appointment_services', 'assigned_employer_id');
                $table->renameColumn('assigned_employer_id', 'assigned_professional_id');
            }
        });

        Schema::table('appointment_services', function (Blueprint $table) {
            if (Schema::hasColumn('appointment_services', 'assigned_professional_id')) {
                $this->dropForeignByColumnIfExists('appointment_services', 'assigned_professional_id');
                $table->foreign('assigned_professional_id')->references('id')->on('professionals')->nullOnDelete();
            }
        });

        // Services: revert FK to professionals and rename back if needed
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'assigned_employer_id')) {
                $this->dropForeignByColumnIfExists('services', 'assigned_employer_id');
                $table->renameColumn('assigned_employer_id', 'assigned_professional_id');
            }
        });

        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'assigned_professional_id')) {
                $this->dropForeignByColumnIfExists('services', 'assigned_professional_id');
                $table->foreign('assigned_professional_id')->references('id')->on('professionals')->nullOnDelete();
            }
        });
    }
    
    private function dropForeignByColumnIfExists(string $tableName, string $columnName): void
    {
        $databaseName = DB::getDatabaseName();
        $constraint = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->select('CONSTRAINT_NAME')
            ->where('TABLE_SCHEMA', $databaseName)
            ->where('TABLE_NAME', $tableName)
            ->where('COLUMN_NAME', $columnName)
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');
        
        if ($constraint) {
            DB::statement("ALTER TABLE `{$tableName}` DROP FOREIGN KEY `{$constraint}`");
        }
    }
};


