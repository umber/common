<?php

declare(strict_types=1);

namespace Umber\Common\Form\Factory;

use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormFactoryBuilderInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormTypeGuesserChain;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;

/**
 * A form factory builder setup like the Symfony Forms one.
 */
final class FormFactoryBuilder implements FormFactoryBuilderInterface
{
    /** @var ResolvedFormTypeFactoryInterface|null */
    private $resolvedTypeFactory;

    /** @var FormExtensionInterface[] */
    private $extensions = [];

    /** @var FormTypeInterface[] */
    private $types = [];

    /** @var FormTypeExtensionInterface[] */
    private $typeExtensions = [];

    /** @var FormTypeGuesserInterface[] */
    private $typeGuessers = [];

    /**
     * {@inheritdoc}
     */
    public function setResolvedTypeFactory(ResolvedFormTypeFactoryInterface $resolvedTypeFactory): FormFactoryBuilder
    {
        $this->resolvedTypeFactory = $resolvedTypeFactory;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtension(FormExtensionInterface $extension): FormFactoryBuilder
    {
        $this->extensions[] = $extension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtensions(array $extensions): FormFactoryBuilder
    {
        $this->extensions = array_merge($this->extensions, $extensions);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addType(FormTypeInterface $type): FormFactoryBuilder
    {
        $this->types[] = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypes(array $types): FormFactoryBuilder
    {
        foreach ($types as $type) {
            $this->types[] = $type;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypeExtension(FormTypeExtensionInterface $typeExtension): FormFactoryBuilder
    {
        $this->typeExtensions[$typeExtension->getExtendedType()][] = $typeExtension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypeExtensions(array $typeExtensions): FormFactoryBuilder
    {
        foreach ($typeExtensions as $typeExtension) {
            $this->typeExtensions[$typeExtension->getExtendedType()][] = $typeExtension;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypeGuesser(FormTypeGuesserInterface $typeGuesser): FormFactoryBuilder
    {
        $this->typeGuessers[] = $typeGuesser;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypeGuessers(array $typeGuessers): FormFactoryBuilder
    {
        $this->typeGuessers = array_merge($this->typeGuessers, $typeGuessers);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormFactory(): FormFactory
    {
        $extensions = $this->extensions;

        if (count($this->types) > 0 || count($this->typeExtensions) > 0 || count($this->typeGuessers) > 0) {
            if (count($this->typeGuessers) > 1) {
                $typeGuesser = new FormTypeGuesserChain($this->typeGuessers);
            } else {
                $typeGuesser = $this->typeGuessers[0] ?? null;
            }

            $extensions[] = new PreloadedExtension($this->types, $this->typeExtensions, $typeGuesser);
        }

        $registry = new FormRegistry($extensions, $this->resolvedTypeFactory ?: new ResolvedFormTypeFactory());

        return new FormFactory($registry);
    }
}
