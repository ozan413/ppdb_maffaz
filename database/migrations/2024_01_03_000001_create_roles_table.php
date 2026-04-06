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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // admin, panitia, ustad, santri
            $table->string('display_name')->nullable();
            $table->timestamps();
        });

        // Seed default roles
        DB::table('roles')->insert([
            ['name' => 'admin', 'display_name' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'panitia', 'display_name' => 'Panitia PPDB', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ustad', 'display_name' => 'Ustad', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'santri', 'display_name' => 'Santri', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
