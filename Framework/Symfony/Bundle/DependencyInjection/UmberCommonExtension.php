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
            'database',
            'factory',
            'form',
            'http',
            'serializer',
        ];
    }
}
