<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form\Factory;

use Estasi\LaminasHelpers\Form\ConfigProvider;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class PluginManager
 *
 * @package Estasi\LaminasHelpers\Form\Factory
 */
final class PluginManager implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName($container, $container->get('config')[ConfigProvider::class][$requestedName] ?? []);
    }
}
