<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('test123');

        User::create(
            [
                'name' => 'User One',
                'email' => 'user1@test.com',
                'password' => $password,
            ]
        );
        User::create(
            [
                'name' => 'User Two',
                'email' => 'user2@test.com',
                'password' => $password,
            ]
        );
        User::create(
            [
                'name' => 'User Three',
                'email' => 'user3@test.com',
                'password' => $password,
            ]
        );
        User::create(
            [
                'name' => 'User Four',
                'email' => 'user4@test.com',
                'password' => $password,
            ]
        );
    }
}
