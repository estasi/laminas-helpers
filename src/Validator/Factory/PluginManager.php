<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Validator\Factory;

use Estasi\LaminasHelpers\{
    Traits\PluginManagerFactory,
    Validator\ConfigProvider as ValidatorConfigProvider,
    Validator\PluginManager as ValidatorPluginManager
};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class PluginManager
 *
 * @package Estasi\LaminasHelpers\Validator\Factory
 */
final class PluginManager implements FactoryInterface
{
    use PluginManagerFactory;

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $pluginManager = new ValidatorPluginManager($container, $options ?? []);
        $this->setConfigServiceManager($container, $pluginManager, ValidatorConfigProvider::class);

        return $pluginManager;
    }
}
