<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Repositories\Contracts\ProviderInterface;
use App\Traits\ResponseTrait;
use Database\Factories\ProviderFactory;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    private $providerRepository;
    public function __construct(ProviderInterface $providerInterface)
    {

        $this->providerRepository = $providerInterface;
    }

    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function register(Request $request){
        $this->providerRepository->register($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        //
    }
}
