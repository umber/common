<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use Umber\Common\Prototype\Hint\DateAwareHintInterface;

use Umber\Prototype\Column\Date\DeletedAtAwareInterface as PrototypeDeletedAtAwareInterface;

/**
 * @deprecated Please use "Umber\Prototype\Column\Date\DeletedAtAwareInterface" instead.
 */
interface DeletedAtAwareInterface extends
    PrototypeDeletedAtAwareInterface,
    DateAwareHintInterface
{
}
