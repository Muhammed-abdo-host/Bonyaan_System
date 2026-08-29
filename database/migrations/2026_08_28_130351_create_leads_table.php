<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->nullable();
            $table->string('building_type');
            $table->decimal('area', 10, 2);
            $table->unsignedInteger('floors');
            $table->string('finishing_tier');
            $table->decimal('estimated_cost', 12, 2)->nullable();
            $table->enum('status', ['new', 'contacted', 'converted', 'rejected'])->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
