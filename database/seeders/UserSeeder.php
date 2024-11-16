<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        foreach ($users as $user) {
            User::create([
                'name' => $user,
                'email' => $user . '@mail.com',
                'password' => bcrypt($user . 'senha')
            ]);
        }
    }
}
