<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Filter\Factory;

use Estasi\LaminasHelpers\{
    Filter\ConfigProvider as FilterConfigProvider,
    Traits\PluginManagerFactory
};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class PluginManager
 *
 * @package Estasi\LaminasHelpers\Filter\Factory
 */
final class PluginManager implements FactoryInterface
{
    use PluginManagerFactory;

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $pluginManager = new \Estasi\LaminasHelpers\Filter\PluginManager($container, $options ?? []);
        $this->setConfigServiceManager($container, $pluginManager, FilterConfigProvider::class);

        return $pluginManager;
    }
}
