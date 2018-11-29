<?php

declare(strict_types=1);

namespace Umber\Common\Serializer;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer as SerializerInstance;
use JMS\Serializer\SerializerBuilder;

final class Serializer implements SerializerInterface
{
    /** @var SerializerInstance */
    private $serializer;

    public function __construct(?SerializerInstance $serializer = null)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data, array $groups): array
    {
        if (!in_array('global', $groups)) {
            $groups[] = 'global';
        }

        $context = new SerializationContext();
        $context->enableMaxDepthChecks();
        $context->setGroups($groups);

        if (is_object($data)) {
            $context->setInitialType(get_class($data));
        }

        return $this->getSerializerInstance()->toArray($data, $context);
    }

    public function getSerializerInstance(): SerializerInstance
    {
        if (!$this->serializer instanceof SerializerInstance) {
            $this->serializer = SerializerBuilder::create()->build();
        }

        return $this->serializer;
    }
}
