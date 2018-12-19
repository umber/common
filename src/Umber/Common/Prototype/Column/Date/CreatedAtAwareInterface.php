<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use Umber\Common\Prototype\Hint\DateAwareHintInterface;

use Umber\Prototype\Column\Date\CreatedAtAwareInterface as PrototypeCreatedAtAwareInterface;

/**
 * @deprecated Please use "Umber\Prototype\Column\Date\CreatedAtAwareInterface" instead.
 */
interface CreatedAtAwareInterface extends
    PrototypeCreatedAtAwareInterface,
    DateAwareHintInterface
{
}
