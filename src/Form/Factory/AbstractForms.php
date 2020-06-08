<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form\Factory;

use Estasi\Form\Factory\Form;
use Estasi\LaminasHelpers\Form\ConfigProvider;
use Estasi\PluginManager\ReflectionPlugin;
use Interop\Container\ContainerInterface;

use function class_exists;
use function is_string;

/**
 * Class AbstractForms
 *
 * @package Estasi\LaminasHelpers\Form\Factory
 */
final class AbstractForms extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return (bool)$this->getClassname($container, $requestedName, ConfigProvider::FORMS);
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $classname = $this->getClassname($container, $requestedName, ConfigProvider::FORMS);

        if (is_string($classname) && class_exists($classname)) {
            /** @var \Estasi\Form\Interfaces\Form|\Estasi\Form\Interfaces\FormAware|\Estasi\Form\Interfaces\FormProvider $classname */
            $classname = (new ReflectionPlugin($classname))->newInstanceArgs($options);
        }

        return (new Form())->createForm($classname);
    }
}
