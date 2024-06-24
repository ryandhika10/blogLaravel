<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ])->assignRole('admin');

        User::create([
            'name' => 'penulis',
            'email' => 'penulis@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ])->assignRole('penulis');

        User::create([
            'name' => 'pembaca',
            'email' => 'pembaca@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ])->assignRole('pembaca');
    }
}
