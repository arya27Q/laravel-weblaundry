<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ini untuk membuat user login admin kamu
        User::factory()->create([
            'name' => 'Admin Laundry',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // passwordnya jadi: password
        ]);

        // INI YANG PENTING: Panggil Seeder Laundry yang kita buat tadi
        $this->call([
            LaundrySeeder::class,
        ]);
    }
}