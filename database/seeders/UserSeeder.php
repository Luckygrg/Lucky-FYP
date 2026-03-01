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
            ['name' => 'Rebika Gurung',   'email' => 'luckygrxx@gmail.com'],
            ['name' => 'Anita Sharma',    'email' => 'anita@spalush.com'],
            ['name' => 'Prakash Thapa',   'email' => 'prakash@spalush.com'],
            ['name' => 'Sunita Rai',      'email' => 'sunita@spalush.com'],
            ['name' => 'Bikash Karki',    'email' => 'bikash@spalush.com'],
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
            ['name' => 'Priya Tamang',    'email' => 'priya@example.com'],
            ['name' => 'Rohan Shrestha',  'email' => 'rohan@example.com'],
            ['name' => 'Nisha Magar',     'email' => 'nisha@example.com'],
            ['name' => 'Sanjay Pandey',   'email' => 'sanjay@example.com'],
            ['name' => 'Kritika Basnet',  'email' => 'kritika@example.com'],
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
