<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Domain;
use App\Models\Package;
use App\Models\Template;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Vendor::insert([
            ['id' => 1, 'vendor_name' => 'Niaga Hoster'],
            ['id' => 2, 'vendor_name' => 'Domainesia'],
            ['id' => 3, 'vendor_name' => 'Digital Oceans'],
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Support',
            'username' => 'support',
            'email' => 'support@gmail.com',
            'password' => Hash::make(12345678),
            'role' => 'support'
        ]);
        // for ($i = 0; $i < 50; $i++) {
        //     Domain::insert([
        //         'domain_name' => 'domain' . $i . '.' . Str::random(3) . '.com',
        //         'start_date' => Date::now()->subDays(rand(1, 365))->format('Y-m-d'),
        //         'expired_date' => Date::now()->addDays(rand(1, 365))->format('Y-m-d'),
        //         'description' => Str::random(100),
        //         'vendor_id' => rand(1, 3),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        $data_package = [
            [
                'package_name' => 'Paket Simple Pemula',
                'package_description' => '',
                'package_price' => '899000',
                'package_hosting_storage' => '0.6',
                'package_hosting_email' => '1',
                'package_support' => false,
                'package_video_profile' => false,
            ],
            [
                'package_name' => 'Paket Simple Medium',
                'package_description' => '',
                'package_price' => '1000000',
                'package_hosting_storage' => '1',
                'package_hosting_email' => '1',
                'package_support' => false,
                'package_video_profile' => false,
            ],
            [
                'package_name' => 'Paket Simple Bisnis',
                'package_description' => '',
                'package_price' => '1299000',
                'package_hosting_storage' => '5',
                'package_hosting_email' => '1',
                'package_support' => true,
                'package_video_profile' => false,
            ],
            [
                'package_name' => 'Paket Simple Bisnis Plus',
                'package_description' => '',
                'package_price' => '1599000',
                'package_hosting_storage' => '25',
                'package_hosting_email' => '5',
                'package_support' => true,
                'package_video_profile' => true,
            ],
        ];

        Package::insert($data_package);
        $data_template = [
            [
                'template_name' => 'Template Bag Shop',
                'template_url' => 'https://katalog.pages.id/tokoku-ryo-ikhsan-2/',
                'template_image' => 'template_bagshop.webp',
            ],
            [
                'template_name' => 'Template Laptops',
                'template_url' => 'https://katalog.pages.id/tokoku-rama3/',
                'template_image' => 'template_laptops.webp',
            ],
            [
                'template_name' => 'Template Affiliate 4',
                'template_url' => 'https://katalog.pages.id/affiliate-4/',
                'template_image' => 'template_affiliate_4.png',
            ],
            [
                'template_name' => 'Template Furniture 3',
                'template_url' => 'https://katalog.pages.id/jbfurnite-3-2803022/',
                'template_image' => 'template_furniture_3.png',
            ],
            [
                'template_name' => 'Template Commerce 1',
                'template_url' => 'https://katalog.pages.id/jb-commerce-1-2106022/',
                'template_image' => 'template_commerce_1.png',
            ],
            [
                'template_name' => 'Template Affiliate 3',
                'template_url' => 'https://katalog.pages.id/affiliate-3/',
                'template_image' => 'template_affiliate_3.png',
            ],
            [
                'template_name' => 'Template Cosmetics',
                'template_url' => 'https://webz.biz/template-7-2/',
                'template_image' => 'template_cosmetics.webp',
            ],
            [
                'template_name' => 'Template Affiliate 5',
                'template_url' => 'https://katalog.pages.id/affiliate-5/',
                'template_image' => 'template_affiliate_5.png',
            ],
            [
                'template_name' => 'Template Affiliate 2',
                'template_url' => 'https://katalog.pages.id/affiliate-2/',
                'template_image' => 'template_affiliate_2.png',
            ],
            [
                'template_name' => 'Template Day Spa',
                'template_url' => 'https://katalog.pages.id/template-33/',
                'template_image' => 'template_day_spa.png',
            ],
            [
                'template_name' => 'Template Donation 3',
                'template_url' => 'https://katalog.pages.id/donasi-3-0803022/',
                'template_image' => 'template_donation_3.png',
            ],
            [
                'template_name' => 'Template Affiliate 17',
                'template_url' => 'https://katalog.pages.id/affiliate-17/',
                'template_image' => 'template_affiliate_17.png',
            ],
            [
                'template_name' => 'Template Books 1',
                'template_url' => 'https://katalog.pages.id/buku-1-1703022/',
                'template_image' => 'template_books_1.png',
            ],
            [
                'template_name' => 'Template Compro 2',
                'template_url' => 'https://katalog.pages.id/compro-2-2704022/',
                'template_image' => 'template_compro_2.png',
            ],
            [
                'template_name' => 'Template Fresh 2',
                'template_url' => 'https://katalog.pages.id/template-24/',
                'template_image' => 'template_fresh_2.png',
            ],
            [
                'template_name' => 'Template Finance 1',
                'template_url' => 'https://katalog.pages.id/finance-1-2403022/',
                'template_image' => 'template_finance_1.png',
            ],
            [
                'template_name' => 'Template Car 2',
                'template_url' => 'https://katalog.pages.id/otomotif-2-1402022/',
                'template_image' => 'template_car_2.png',
            ],
            [
                'template_name' => 'Template Mens Parfume ',
                'template_url' => 'https://katalog.pages.id/fashion-2202022/',
                'template_image' => 'template_mens_parfume.png',
            ],
            [
                'template_name' => 'Template Car 1',
                'template_url' => 'https://katalog.pages.id/otomotif-1402022/',
                'template_image' => 'template_car_1.png',
            ],
            [
                'template_name' => 'Template Bicylcle 2',
                'template_url' => 'https://katalog.pages.id/sepeda-2-2405022/',
                'template_image' => 'template_bicycle_2.png',
            ],
        ];
        Template::insert($data_template);
    }
}
