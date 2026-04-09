<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpaCategory;

class SpaCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Signature',
            'Massages',
            'Facials',
            'Body treatments',
            'Nail & foot care',
            'Hair & scalp',
            'Waxing',
            'Wellness',
            'Packages'
        ];

        foreach ($categories as $category) {
            SpaCategory::create([
                'name' => $category
            ]);
        }
    }
}
