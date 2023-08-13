<?php

namespace App\Repositories\Contracts;

interface AuthInterface
{
    public function register();
    public function login();
    public function verify();
    public function logout();
}