<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'System administrator',
            'email'=>'taruna.kashyap04@gmail.com',
            'password'=>Hash::make('Admin@123'),
            'role'=>'admin',
            'phone'=>'1234567891',


        ]);
    }
}
