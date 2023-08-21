<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Provider\Store;
use App\Repositories\Contracts\ProviderInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $providerInterfce;
    public function __construct(ProviderInterface $providerInterface)
    {
        $this->providerInterfce = $providerInterface;
    }


    public function register(Store $request){
        try {
            $this->providerInterfce->register($request->validated());
        }catch (\Exception $exception){

        }
    }

}
