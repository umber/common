<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Prototype;

interface UserRepositoryInterface
{
    public function findOneByEmail(string $email): ?UserInterface;
}
