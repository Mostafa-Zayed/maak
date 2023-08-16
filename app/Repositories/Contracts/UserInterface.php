<?php 

namespace App\Repositories\Contracts;

use App\Contracts\AuthInterface;

interface UserInterface extends AuthInterface
{
    public function verifyAccount(& $user);
}