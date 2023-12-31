<?php

namespace Database\Seeders;

use App\Models\RequestService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(SettingSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(IntroHowWorkTableSeeder::class);
        $this->call(IntroSliderTableSeeder::class);
        $this->call(IntroServiceTableSeeder::class);
        $this->call(IntroFqsCategoryTableSeeder::class);
        $this->call(IntroFqsTableSeeder::class);
        $this->call(IntroPartenerTableSeeder::class);
        $this->call(IntroSocialTableSeeder::class);
        $this->call(SocialTableSeeder::class);
        // $this->call(ComplaintTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(FqsTableSeeder::class);
        $this->call(IntroTableSeeder::class);
        $this->call(ImageTableSeeder::class);
        $this->call(CouponTableSeeder::class);
        $this->call(SmsTableSeeder::class);
        // $this->call(NotificationSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CategorySeeder::class);
//        $this->call(CategoryTableSeeder::class);
        $this->call(ServiceTableSeeder::class);

        $this->call(ProviderSeeder::class);
        $this->call(RequestServiceSeeder::class);
        $this->call(OfferPriceSeeder::class);
//        $this->call(RequestService::class);
        //    $this->call(SettlementTableSeeder::class);
    }
}
