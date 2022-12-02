<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Creates a default admin
        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'is_admin' => true
        ]);

        //Creates a default user
        User::firstOrCreate([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => 'password',
            'is_admin' => false
        ]);

        User::factory()->count(10)->create();
    }
}
