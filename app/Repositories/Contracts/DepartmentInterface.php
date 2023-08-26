<?php

namespace App\Repositories\Contracts;

interface DepartmentInterface
{
    public function getAll();
    public function getOne($id);
    public function getCategories($id);
    public function getStoreCategories();
    public function getServicesCategories();
}