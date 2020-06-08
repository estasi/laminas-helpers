<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form\Factory;

use Estasi\LaminasHelpers\{
    Form\ConfigProvider,
    Traits\PluginManagerFactory
};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class PluginManager
 *
 * @package Estasi\LaminasHelpers\Form\Factory
 */
final class PluginManager implements FactoryInterface
{
    use PluginManagerFactory;

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $pluginManager = new $requestedName($container, $options ?? []);
        $this->setConfigServiceManager($container, $pluginManager, ConfigProvider::class);

        return $pluginManager;
    }
}
