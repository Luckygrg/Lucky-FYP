<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Spa Owners ────────────────────────────────────────────────────────
        $spaOwners = [
            ['name' => 'Lucky Gurung',   'email' => 'lucky@spalush.com'],
            ['name' => 'Rebika Gurung',    'email' => 'rebika@spalush.com'],
            ['name' => 'Kristi Shrees',   'email' => 'kristi@spalush.com'],
            ['name' => 'Lancy Rai',      'email' => 'lancy@spalush.com'],
            ['name' => 'Salina Shrestha',    'email' => 'salina@spalush.com'],
        ];

        foreach ($spaOwners as $owner) {
            User::firstOrCreate(
                ['email' => $owner['email']],
                [
                    'name'     => $owner['name'],
                    'password' => Hash::make('password123'),
                    'role'     => 'spa_owner',
                ]
            );
        }

        // ── Customers ─────────────────────────────────────────────────────────
        $customers = [
            ['name' => 'Priya Tamang',    'email' => 'priya@gmail.com'],
            ['name' => 'Rohan Shakya',  'email' => 'rohan@gmail.com'],
            ['name' => 'Nisha Magar',     'email' => 'nisha@gmail.com'],
            ['name' => 'Rhythm Guurng',   'email' => 'rhythm@gmail.com'],
            ['name' => 'Kritika Basnet',  'email' => 'kritika@gmail.com'],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'name'     => $customer['name'],
                    'password' => Hash::make('password123'),
                    'role'     => 'customer',
                ]
            );
        }
    }
}
