<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Spa;
use App\Models\SpaCategory;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Get all spas (you said you have 5)
        $spas = Spa::all();

        // Get categories by name
        $categories = SpaCategory::pluck('id', 'name');

        $services = [

            // Signature
            [
                'category' => 'Signature',
                'name' => 'Celestial Floatation',
                'description' => 'Weightless float in a warm Epsom salt pod — zero gravity, complete silence, total stillness.',
                'price' => 4000,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Signature',
                'name' => 'Mud Ritual',
                'description' => 'Warm mineral mud applied head-to-toe — detoxifies, nourishes, and transforms skin.',
                'price' => 3750,
                'duration_minutes' => 75,
            ],
            [
                'category' => 'Signature',
                'name' => 'Hydromassage',
                'description' => 'Powerful water jets deliver full-body muscle release and circulation boost simultaneously.',
                'price' => 3000,
                'duration_minutes' => 60,
            ],

            // Massages
            [
                'category' => 'Massages',
                'name' => 'Swedish Massage',
                'description' => 'Gentle full-body relaxation using long, flowing strokes to ease tension.',
                'price' => 1500,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Massages',
                'name' => 'Deep Tissue Massage',
                'description' => 'Targets deep muscle layers to release chronic tension and pain.',
                'price' => 2000,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Massages',
                'name' => 'Hot Stone Massage',
                'description' => 'Heated stones melt tension and deeply improve blood circulation.',
                'price' => 2500,
                'duration_minutes' => 75,
            ],

            // Facials
            [
                'category' => 'Facials',
                'name' => 'Classic Facial',
                'description' => 'Cleanse, exfoliate, tone, and moisturize for radiant, refreshed skin.',
                'price' => 1000,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Facials',
                'name' => 'Brightening Facial',
                'description' => 'Fades dark spots and uneven tone for a luminous, glowing complexion.',
                'price' => 1400,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Facials',
                'name' => 'Hydrating Facial',
                'description' => 'Deep moisture infusion for dry, dehydrated, or dull skin.',
                'price' => 1200,
                'duration_minutes' => 60,
            ],

            // Body treatments
            [
                'category' => 'Body treatments',
                'name' => 'Body Scrub',
                'description' => 'Full-body polish to remove dead skin and restore a healthy radiance.',
                'price' => 1400,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Body treatments',
                'name' => 'Slimming Wrap',
                'description' => 'Firms and tones targeted areas using active formulas and bandages.',
                'price' => 2000,
                'duration_minutes' => 75,
            ],
            [
                'category' => 'Body treatments',
                'name' => 'Hydrotherapy Soak',
                'description' => 'Therapeutic bath infused with minerals, salts, or essential oils.',
                'price' => 1200,
                'duration_minutes' => 45,
            ],

            // Nail & foot care
            [
                'category' => 'Nail & foot care',
                'name' => 'Classic Manicure',
                'description' => 'Shaping, cuticle care, and polish for perfectly groomed hands.',
                'price' => 500,
                'duration_minutes' => 45,
            ],
            [
                'category' => 'Nail & foot care',
                'name' => 'Classic Pedicure',
                'description' => 'Soak, exfoliate, trim, and polish for perfectly groomed feet.',
                'price' => 700,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Nail & foot care',
                'name' => 'Spa Mani & Pedi Combo',
                'description' => 'Upgraded combo with scrub, mask, and extended relaxing massage.',
                'price' => 1200,
                'duration_minutes' => 90,
            ],

            // Hair & scalp
            [
                'category' => 'Hair & scalp',
                'name' => 'Ayurvedic Hair Oiling',
                'description' => 'Warm herbal oil massage to nourish scalp and strengthen strands.',
                'price' => 900,
                'duration_minutes' => 45,
            ],
            [
                'category' => 'Hair & scalp',
                'name' => 'Keratin Smoothing',
                'description' => 'Reduces frizz and adds smooth, lasting shine to hair.',
                'price' => 4000,
                'duration_minutes' => 120,
            ],
            [
                'category' => 'Hair & scalp',
                'name' => 'Scalp Treatment',
                'description' => 'Targets dryness, dandruff, or oiliness directly at the root level.',
                'price' => 1000,
                'duration_minutes' => 30,
            ],

            // Waxing
            [
                'category' => 'Waxing',
                'name' => 'Eyebrow Wax & Shape',
                'description' => 'Defined brow shaping using warm wax for clean, precise results.',
                'price' => 200,
                'duration_minutes' => 15,
            ],
            [
                'category' => 'Waxing',
                'name' => 'Bikini Wax',
                'description' => 'Precise hair removal along the bikini line for a smooth finish.',
                'price' => 700,
                'duration_minutes' => 30,
            ],
            [
                'category' => 'Waxing',
                'name' => 'Full Leg Wax',
                'description' => 'Smooth, hair-free legs from ankle to upper thigh.',
                'price' => 1000,
                'duration_minutes' => 45,
            ],

            // Wellness
            [
                'category' => 'Wellness',
                'name' => 'Sauna Session',
                'description' => 'Dry heat to detox, relax muscles, and promote healthy circulation.',
                'price' => 600,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Wellness',
                'name' => 'Reiki Energy Healing',
                'description' => 'Gentle energy work to restore inner balance and deep calm.',
                'price' => 1400,
                'duration_minutes' => 60,
            ],
            [
                'category' => 'Wellness',
                'name' => 'Sound Bath Therapy',
                'description' => 'Singing bowls guide the body into a profoundly meditative state.',
                'price' => 1200,
                'duration_minutes' => 60,
            ],

            // Packages
            [
                'category' => 'Packages',
                'name' => 'Signature Spa Package',
                'description' => 'Massage + facial + body treatment bundled at a discounted rate.',
                'price' => 4500,
                'duration_minutes' => 240,
            ],
            [
                'category' => 'Packages',
                'name' => 'Bridal / Event Package',
                'description' => 'Custom multi-service day for brides, groups, or special occasions.',
                'price' => 6500,
                'duration_minutes' => 300,
            ],
            [
                'category' => 'Packages',
                'name' => 'Day Retreat',
                'description' => 'Full-day access to all facilities plus a curated treatment sequence.',
                'price' => 5500,
                'duration_minutes' => 480,
            ],
        ];

        foreach ($spas as $spa) {
            foreach ($services as $service) {
                Service::create([
                    'spa_id' => $spa->id,
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'duration_minutes' => $service['duration_minutes'],
                    'spa_category_id' => $categories[$service['category']] ?? null,
                    'is_available' => true,
                ]);
            }
        }
    }
}