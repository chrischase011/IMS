<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::updateOrCreate([
            'firstname' => 'Christopher Robin',
            'lastname' => 'Chase',
            'email' => 'christopherchase011@gmail.com',
            'password' => Hash::make('chasechase'),
            'phone' => '091234567890',
            'roles' => 1
        ]);

        User::updateOrCreate([
            'firstname' => 'Christopher Robin',
            'lastname' => 'Chase',
            'email' => 'christopherchase011+emp@gmail.com',
            'password' => Hash::make('chasechase'),
            'phone' => '091234567890',
            'roles' => 2
        ]);

        User::updateOrCreate([
            'firstname' => 'Christopher Robin',
            'lastname' => 'Chase',
            'email' => 'christopherchase011+cus@gmail.com',
            'password' => Hash::make('chasechase'),
            'phone' => '091234567890',
            'roles' => 3
        ]);
    }
}
