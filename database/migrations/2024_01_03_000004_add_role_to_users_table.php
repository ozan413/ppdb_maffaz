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
        // Add role_id and username to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->onDelete('set null');
            $table->string('username')->unique()->after('name');
            $table->boolean('is_active')->default(true)->after('password');
        });

        // Create default admin user
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        
        DB::table('users')->insert([
            'role_id' => $adminRoleId,
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@maskanulhuffadz.ac.id',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'username', 'is_active']);
        });
    }
};
