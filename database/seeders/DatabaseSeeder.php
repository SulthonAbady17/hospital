<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Symfony\Component\String\b;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'sulthon',
            'email' => 'sulthon@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'verifikator1',
            'email' => 'v1@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'v1',
        ]);

        User::factory()->create([
            'name' => 'verifikator2',
            'email' => 'v2@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'v2',
        ]);
    }
}
