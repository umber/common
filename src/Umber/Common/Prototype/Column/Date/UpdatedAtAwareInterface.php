<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use Umber\Common\Prototype\Hint\DateAwareHintInterface;

use Umber\Prototype\Column\Date\UpdatedAtAwareInterface as PrototypeUpdatedAtAwareInterface;

/**
 * @deprecated Please use "Umber\Prototype\Column\Date\UpdatedAtAwareInterface" instead.
 */
interface UpdatedAtAwareInterface extends
    PrototypeUpdatedAtAwareInterface,
    DateAwareHintInterface
{
}
