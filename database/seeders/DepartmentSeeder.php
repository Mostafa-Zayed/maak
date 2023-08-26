<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => json_encode(['en' => 'Digital Services','ar' => 'خدمات رقمية'],JSON_UNESCAPED_UNICODE),
                'slug' => Str::slug('Digital Services'),
                'image' => 'default.png',
            ],
            [
                'name' => json_encode(['en' => 'digital stores','ar' => 'متاجر رقمية'],JSON_UNESCAPED_UNICODE),
                'slug' => Str::slug('Digital Stores'),
                'image' => 'default.png',
            ]
        ]);
    }
}
