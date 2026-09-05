<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // يتنفذ فقط لو نوع الداتابيز MySQL ولا يكسر التيستات على SQLite
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE job_applicants MODIFY status ENUM('new','reviewing','interview','hired','rejected') DEFAULT 'new'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE job_applicants MODIFY status ENUM('pending','reviewed','hired','rejected') DEFAULT 'pending'");
        }
    }
};