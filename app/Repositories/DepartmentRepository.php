<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentInterface;

class DepartmentRepository implements DepartmentInterface
{

    public function getAll()
    {
        return Department::active()->get();
    }

    public function getOne($id)
    {
        return Department::active()->find($id);
    }

    public function getCategories($id)
    {
        return Category::active()->where('department_id','=',$id)->get();
    }

    public function getStoreCategories()
    {
        return Category::active()->store()->get();
    }

    public function getServicesCategories()
    {
        return Category::active()->service()->get();
    }
}