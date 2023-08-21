<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Services\AllResource;
use App\Http\Resources\Api\Services\CategoryServices;
use App\Http\Resources\Api\Services\ServiceProviders;
use App\Repositories\Contracts\ServiceInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    use ResponseTrait;
    private ServiceInterface $serviceRepository;
    public function __construct(ServiceInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }
    public  function services(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(AllResource::collection($this->serviceRepository->getAll()));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function getServicesByCategory($id): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(CategoryServices::collection($this->serviceRepository->getByCategory($id)));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function getServiceProvider($serviceId): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(ServiceProviders::collection($this->serviceRepository->getServiceProviders($serviceId)));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }
}
