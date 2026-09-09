<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Only MySQL/MariaDB understands MODIFY COLUMN ... ENUM syntax.
        // Guarded so this migration doesn't break the test suite on SQLite.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE projects MODIFY status ENUM('pending','ongoing','completed') DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE projects MODIFY status ENUM('ongoing','completed') DEFAULT 'ongoing'");
        }
    }
};
