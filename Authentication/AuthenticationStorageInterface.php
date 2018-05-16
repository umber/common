<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Prototype\UserInterface;

interface AuthenticationStorageInterface
{
    public function getUser(): UserInterface;
}
