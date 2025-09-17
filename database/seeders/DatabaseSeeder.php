<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'default' => true,
            'allowed_pages' => json_encode(['welcome']),
        ]);

        Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'default' => true,
            'allowed_pages' => json_encode(['*']),
        ]);

        User::factory()->create([
            'name' => 'yyuh',
            'email' => 'yyuhdev@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);
    }
}
