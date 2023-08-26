<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryInterface;

Class CategoryRepository implements CategoryInterface
{

    public function getAll()
    {
        return Category::active()->get();
    }
}