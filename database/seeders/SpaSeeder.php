<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spa;
use App\Models\User;

class SpaSeeder extends Seeder
{
    /**
     * One spa per spa_owner user. Uses updateOrCreate so values can be refreshed on re-run.
     */
    public function run(): void
    {
        $spas = [
            'lucky@spalush.com' => [
                'name'          => 'Serenity Bliss Spa',
                'location'      => 'Thamel, Kathmandu',
                'city'          => 'Kathmandu',
                'description'   => 'A luxurious urban retreat nestled in the heart of Thamel. Serenity Bliss offers world-class massages, herbal body wraps, and rejuvenating facials inspired by ancient Himalayan wellness traditions.',
                'price_range'   => '$$$$',
                'is_featured'   => false,
                'rating'        => 0,
                'review_count'  => 0,
                'tags'          => ['Massages', 'Facials', 'Wellness'],
                'phone'         => '+977-9801234567',
                'email'         => 'serenity@spalush.com',
                'opening_hours' => 'Daily 9:00am - 9:00pm',
                'is_active'     => true,
                'status'        => 'approved',
            ],
            'rebika@spalush.com' => [
                'name'          => 'Lotus Garden Wellness',
                'location'      => 'Lazimpat, Kathmandu',
                'city'          => 'Kathmandu',
                'description'   => 'Inspired by the purity of the lotus flower, this sanctuary offers a full range of holistic treatments including hot stone therapy, aromatherapy, and yoga sessions for complete mind-body harmony.',
                'price_range'   => '$$$',
                'is_featured'   => false,
                'rating'        => 0,
                'review_count'  => 0,
                'tags'          => ['Massages', 'Facials', 'Wellness'],
                'phone'         => '+977-9807654321',
                'email'         => 'lotus@spalush.com',
                'opening_hours' => 'Daily 9:00am - 9:00pm',
                'is_active'     => true,
                'status'        => 'approved',
            ],
            'kristi@spalush.com' => [
                'name'          => 'Alpine Zen Retreat',
                'location'      => 'Lakeside, Pokhara',
                'city'          => 'Pokhara',
                'description'   => 'Set against the stunning backdrop of Phewa Lake and the Annapurna range, Alpine Zen combines traditional Nepali healing techniques with modern spa therapies for an unforgettable experience.',
                'price_range'   => '$$$',
                'is_featured'   => false,
                'rating'        => 0,
                'review_count'  => 0,
                'tags'          => ['Massages', 'Facials', 'Wellness'],
                'phone'         => '+977-9811223344',
                'email'         => 'alpine@spalush.com',
                'opening_hours' => 'Daily 9:00am - 9:00pm',
                'is_active'     => true,
                'status'        => 'pending',
            ],
            'salina@spalush.com' => [
                'name'          => 'Golden Aura Beauty & Spa',
                'location'      => 'New Road, Pokhara',
                'city'          => 'Pokhara',
                'description'   => 'Golden Aura specialises in beauty-focused spa treatments — from glow facials and skin brightening to manicures, nail art, and luxury hair care — all delivered in a serene golden ambiance.',
                'price_range'   => '$$$',
                'is_featured'   => false,
                'rating'        => 0,
                'review_count'  => 0,
                'tags'          => ['Massages', 'Facials', 'Wellness'],
                'phone'         => '+977-9855667788',
                'email'         => 'goldenaura@spalush.com',
                'opening_hours' => 'Daily 9:00am - 9:00pm',
                'is_active'     => true,
                'status'        => 'pending',
            ],
            'lancy@spalush.com' => [
                'name'          => 'Tranquil Peaks Spa',
                'location'      => 'Durbar Marg, Kathmandu',
                'city'          => 'Kathmandu',
                'description'   => 'Tranquil Peaks brings together East-meets-West wellness philosophy. Signature treatments include Tibetan singing bowl therapy, CBD oil massage, and detox body rituals.',
                'price_range'   => '$$$',
                'is_featured'   => false,
                'rating'        => 0,
                'review_count'  => 0,
                'tags'          => ['Massages', 'Facials', 'Wellness'],
                'phone'         => '+977-9899001122',
                'email'         => 'tranquil@spalush.com',
                'opening_hours' => 'Daily 9:00am - 9:00pm',
                'is_active'     => true,
                'status'        => 'pending',
            ],
        ];

        foreach ($spas as $email => $data) {
            $user = User::where('email', $email)->where('role', 'spa_owner')->first();

            if (!$user) {
                $this->command->warn("Spa owner [{$email}] not found — skipping.");
                continue;
            }

            Spa::updateOrCreate(
                ['user_id' => $user->id],
                $data
            );
        }

        $this->command->info('SpaSeeder: ' . count($spas) . ' spas seeded (one per owner).');
    }
}
