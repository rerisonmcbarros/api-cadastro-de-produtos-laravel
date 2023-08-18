<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Adminitrador',
            'email' => 'admin@email.com',
            'password' => 'password123',
            'is_admin' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
