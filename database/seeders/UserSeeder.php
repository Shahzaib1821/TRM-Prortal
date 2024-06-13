<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'email' => 'shahrukh@gmail.com',
                'company' => 'TRM',
                'role' => 'admin',
                'active' => 1,
                'is_deleted' => 0,
            ],
            [
                'name' => 'shahrukh',
                'password' => Hash::make('TheridgelineMarketing0@'),
            ]
        );

        // You can add more user data as needed
    }
}
