<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Categories\AllResource;
use App\Repositories\Contracts\CategoryInterface;
use App\Traits\LogException;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait, LogException;
    private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(AllResource::collection($this->categoryRepository->getAll()));
        } catch (\Exception $exception) {
            return $this->logMethodException($exception);
        }
    }
}
