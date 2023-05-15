<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'role_id' => 1,
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        \App\Models\Category::factory(20)->create();
    }
}
