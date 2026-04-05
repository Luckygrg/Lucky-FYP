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
            ['name' => 'Priya Tamang',    'email' => 'luckygrxx+priya@gmail.com'],
            ['name' => 'Rohan Shakya',    'email' => 'luckygrxx+rohan@gmail.com'],
            ['name' => 'Nisha Magar',     'email' => 'luckygrxx+nisha@gmail.com'],
            ['name' => 'Rhythm Guurng',   'email' => 'luckygrxx+rhythm@gmail.com'],
            ['name' => 'Kritika Basnet',  'email' => 'luckygrxx+kritika@gmail.com'],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['name' => $customer['name'], 'role' => 'customer'],
                [
                    'name'     => $customer['name'],
                    'email'    => $customer['email'],
                    'password' => Hash::make('password123'),
                    'role'     => 'customer',
                ]
            );
        }
    }
}
