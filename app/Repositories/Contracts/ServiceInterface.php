<?php

namespace App\Repositories\Contracts;

interface ServiceInterface
{
    public function getAll();
    public function getByCategory($categoryId);
    public function getServiceProviders($serviceId);
}