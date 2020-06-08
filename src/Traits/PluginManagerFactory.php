<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Traits;

use Laminas\ServiceManager\{
    Config,
    ServiceManager
};
use Psr\Container\ContainerInterface;

/**
 * Trait PluginManagerFactory
 *
 * @package Estasi\LaminasHelpers\Traits
 */
trait PluginManagerFactory
{
    /**
     * Configure a service manager.
     *
     * @param \Psr\Container\ContainerInterface      $container
     * @param \Laminas\ServiceManager\ServiceManager $manager
     * @param string                                 $configName
     */
    private function setConfigServiceManager(
        ContainerInterface $container,
        ServiceManager $manager,
        string $configName
    ): void {
        // If we do not have a config service, nothing more to do
        if (false === $container->has('config')) {
            return;
        }

        $config = $container->get('config');
        // If we do not have configuration, nothing more to do
        if (false === (isset($config[$configName]) && is_array($config[$configName]))) {
            return;
        }

        // Wire service configuration for manager
        (new Config($config[$configName]))->configureServiceManager($manager);
    }
}
