<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Department\AllResource;
use App\Http\Resources\Api\Department\ShowResource;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentInterface;
use App\Traits\LogException;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Api\Categories\AllResource as AllCategoryResource;
class DepartmentController extends Controller
{
    use ResponseTrait;
    use LogException;
    private DepartmentInterface $departmentRepository;

    public function __construct(DepartmentInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(AllResource::collection($this->departmentRepository->getAll()));
        } catch (\Exception $exception) {
            return $this->logMethodException($exception);
        }

    }

    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(new ShowResource($this->departmentRepository->getOne($request->id)));
        } catch (\Exception $exception) {
            return $this->logMethodException($exception);
        }
    }

    public function getServicesCategories(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(AllCategoryResource::collection($this->departmentRepository->getServicesCategories()));
        } catch (\Exception $exception) {
            return $this->logMethodException($exception);
        }
    }

    public function getStoreCategories(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(AllCategoryResource::collection($this->departmentRepository->getStoreCategories()));
        } catch (\Exception $exception) {
            return $this->logMethodException($exception);
        }
    }

    public function getAllCategories($id): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(AllCategoryResource::collection($this->departmentRepository->getCategories($id)));
        } catch (\Exception $exception) {
            return $this->logMethodException($exception);
        }
    }
}
