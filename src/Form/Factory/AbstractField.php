<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form\Factory;

use Estasi\Form\Factory\Field;
use Estasi\LaminasHelpers\Form\ConfigProvider;
use Estasi\PluginManager\ReflectionPlugin;
use Interop\Container\ContainerInterface;

use function class_exists;
use function is_string;

/**
 * Class AbstractField
 *
 * @package Estasi\LaminasHelpers\Form\Factory
 */
final class AbstractField extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return (bool)$this->getClassname($container, $requestedName, ConfigProvider::FIELDS);
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $classname = $this->getClassname($container, $requestedName, ConfigProvider::FIELDS);

        if (is_string($classname) && class_exists($classname)) {
            /** @var \Estasi\Form\Interfaces\Field|\Estasi\Form\Interfaces\FieldAware|\Estasi\Form\Interfaces\FieldProvider $classname */
            $classname = (new ReflectionPlugin($classname))->newInstanceArgs($options);
        }

        return (new Field())->createField($classname);
    }
}
