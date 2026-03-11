<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData=[
            [
            'name'=> 'Saya Super Admin',
            'email' => 'superadmin@gmail.com',
            'role' => 'Super Admin',
            'password' => bcrypt('023456')
            ],
            [
                'name'=> 'Saya Admin',
                'email' => 'admin@gmail.com',
                'role' => 'Admin',
                'password' => bcrypt('123456')
            ],
            [
                'name'=> 'Saya User',
                'email' => 'user@gmail.com',
                'role' => 'User',
                'password' => bcrypt('223456')
            ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }

    }
}
