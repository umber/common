<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation\User;

use Umber\Common\Authentication\Authorisation\AuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;

interface UserAuthorisationInterface extends AuthorisationInterface
{
    public function getUser(): UserInterface;
}
