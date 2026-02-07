<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário para fins de teste
        User::factory()->create([
            'name' => 'Private Code',
            'email' => 'privatecode@email.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(4)->create();
    }
}
