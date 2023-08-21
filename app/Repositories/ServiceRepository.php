<?php

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\Contracts\ServiceInterface;
use Illuminate\Support\Facades\DB;

class ServiceRepository implements ServiceInterface
{
    public function getAll()
    {
        return Service::get();
    }

    public function getByCategory($categoryId)
    {
        return Service::where('category_id','=',$categoryId)->get();
    }

    public function getServiceProviders($serviceId): \Illuminate\Support\Collection
    {
        return DB::table('providers')->whereExists(function($query) use ($serviceId){
            $query->select('id')->from('services')->where('id','=',$serviceId);
        })->get();
    }
}