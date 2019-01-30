<?php

declare(strict_types=1);

namespace Umber\Common\Test;

use Umber\Common\Form\Factory\FormFactory;
use Umber\Common\Form\Factory\FormFactoryBuilder;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * An abstract test case tailored for testing forms against the Umber Form Factory.
 */
abstract class AbstractFormTypeTestCase extends TestCase
{
    /** @var EventDispatcherInterface|MockObject */
    protected $dispatcher;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var FormFactory */
    protected $factory;

    /** @var FormBuilder */
    protected $builder;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $validator = Validation::createValidator();

        $extensions = [];
        $extensions[] = new ValidatorExtension($validator);

        $this->factory = (new FormFactoryBuilder())
            ->addExtensions($extensions)
            ->getFormFactory();

        /** @var MockObject|EventDispatcherInterface $dispatcher */
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->dispatcher = $dispatcher;

        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }
}
