<?php

namespace App\Contracts;

interface AuthInterface
{
    public function register($authInfo);
    public function login($requestPayload);
    public function logout($request);
}