<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class
        ]);
        // Create a default user
        // User::factory()->create([
        //     'email' => 'shahzaib@gmail.com',
        //     'password' => Hash::make('123456'),
        // ]);

        // Generate additional seed data as needed
        // User::factory(10)->create();
    }
}
