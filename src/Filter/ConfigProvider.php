<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Filter;

use Estasi\LaminasHelpers\Interfaces\ConfigProvider as ConfigProviderInterface;

/**
 * Class ConfigProvider
 *
 * @package Estasi\LaminasHelpers\Filter
 */
final class ConfigProvider implements ConfigProviderInterface
{
    // Defining a validator chain class other than the default one. Set in the aliases section.
    public const FILTER_CHAIN = 'filterChain';

    /**
     * @inheritDoc
     */
    public function __invoke()
    {
        return [
            self::DEPENDENCIES => [
                self::DEPENDENCIES_FACTORIES => [
                    PluginManager::class => Factory\PluginManager::class,
                ],
                self::DEPENDENCIES_ALIASES   => [
                    self::FILTER_CHAIN => null,
                ],
            ],
            self::class        => [

            ],
        ];
    }
}
