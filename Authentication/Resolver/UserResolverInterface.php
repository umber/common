<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Prototype\UserInterface;

interface UserResolverInterface
{
    public function resolve(AuthenticationHeaderInterface $header): ?UserInterface;
}
