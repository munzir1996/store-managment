<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin@admin.com',
            'phone' => '0123456789',
            'alt_phone' => '9876543210',
            'address' => 'Arkawet',
            'balance' => 50,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
        ]);

        // $this->call(UserSeeder::class);
    }
}
