<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Informasi Kontak
            ['key' => 'contact_address', 'value' => 'Komplek Perkantoran Bukit Cinto Kenang, Sengeti, Kabupaten Muaro Jambi, Jambi 36381'],
            ['key' => 'contact_phone_ext', 'value' => '(0741) 123456'],
            ['key' => 'contact_email', 'value' => 'kontak@dtph-muarojambi.go.id'],
            ['key' => 'contact_hours', 'value' => 'Senin — Jumat'],
            ['key' => 'contact_hours_time', 'value' => '08.00 - 16.00 WIB'],
            
            // Media Sosial
            ['key' => 'social_whatsapp', 'value' => '+62 812-3456-7890'],
            ['key' => 'social_facebook', 'value' => 'https://www.facebook.com/profile.php?id=100054251648081&locale=id_ID'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/dtph.pertanian_muarojambi/'],
            ['key' => 'social_twitter', 'value' => ''],
            
            // Peta (Menggunakan URL embed dari maps_embed_url, karena iframe butuh src URL embed bukan short link)
            ['key' => 'maps_embed_url', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15951.353427506246!2d103.4883499!3d-1.2520866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e25786f02172777%3A0xc07842c1694f4c28!2sDinas%20Tanaman%20Pangan%20Dan%20Hortikultura%20Kabupaten%20Muaro%20Jambi!5e0!3m2!1sid!2sid!4v1714570000000!5m2!1sid!2sid'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
