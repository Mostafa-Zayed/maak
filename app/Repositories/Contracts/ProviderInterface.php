<?php

namespace App\Repositories\Contracts;

interface ProviderInterface
{

    public function register($request);
    public function login();
    public function verify();
    public function logout();

}