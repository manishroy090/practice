<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name'=>"manish",
            'email'=>'manishkuyadav090@gmail.com',
            'password'=>Hash::make('9824888696')
        ];
        User::insert($user);
    }
}
