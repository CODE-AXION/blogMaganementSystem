<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Code Axion',
                'email' => 'codeaxion88@example.com',
                'password' => Hash::make('asdfasdf'),
            ],
            [
                'name' => 'Darkest Brush',
                'email' => 'darkestbrush99@example.com',
                'password' => Hash::make('code123'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john77@example.com',
                'password' => Hash::make('code123'),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alicejohnson22@example.com',
                'password' => Hash::make('code123'),
            ],
            [
                'name' => 'Mark Brown',
                'email' => 'markbrown44@example.com',
                'password' => Hash::make('code123'),
            ],
        ]);
    }
}
