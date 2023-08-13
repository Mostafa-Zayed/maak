<?php
namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('countries')->insert([
            [
                'name'          => json_encode(['ar' => 'السعودية' , 'en' => 'Saudi Arabia'], JSON_UNESCAPED_UNICODE) , 
                'key'           => '+966'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
            ] , [
                'name' => json_encode(['ar' => 'مصر' , 'en' => 'Egypt'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+20'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ] , [
                'name' => json_encode(['ar' => 'الامارات' , 'en' => 'UAE'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+971'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ] , [
                'name' => json_encode(['ar' => 'البحرين' , 'en' => 'El-Bahrean'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+973'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ] , [
                'name' => json_encode(['ar' => 'قطر' , 'en' => 'Qatar'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+974'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ] , [
                'name' => json_encode(['ar' => 'ليبيا' , 'en' => 'Libya'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+218'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ] , [
                'name' => json_encode(['ar' => 'الكويت' , 'en' => 'Kuwait'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+965'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ] , [
                'name' => json_encode(['ar' => 'عمان' , 'en' => 'Oman'], JSON_UNESCAPED_UNICODE) , 
                'key'  => '+968'   , 
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0,6)),
    
            ]
        ]);
    }
}
