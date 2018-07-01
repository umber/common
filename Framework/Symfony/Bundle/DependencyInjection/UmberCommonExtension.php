<?php

declare(strict_types=1);

namespace Umber\Common\Framework\Symfony\Bundle\DependencyInjection;

use Umber\Common\Framework\Symfony\AbstractExtension;

/**
 * {@inheritdoc}
 */
final class UmberCommonExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function configs(): array
    {
        return [
            'services/database',
            'services/factory',
            'services/form',
            'services/http',
            'services/serializer',
        ];
    }
}
