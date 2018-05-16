<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

/**
 * {@inheritdoc}
 */
abstract class AbstractAuthorisationRoleHierarchyException extends CanonicalAwareRuntimeException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $canonical, $parameters)
    {
        $this->setPrefixSegment('authorisation_hierarchy');

        parent::__construct($canonical, $parameters, 0, null);
    }
}
