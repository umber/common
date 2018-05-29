<?php

namespace Umber\Common\Authentication\Authorisation\Builder\Resolver;

use Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy;

interface AuthorisationHierarchyResolverInterface
{
    public function resolve(): AuthorisationHierarchy;
}
