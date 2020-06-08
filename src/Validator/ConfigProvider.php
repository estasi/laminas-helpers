<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Validator;

use Estasi\LaminasHelpers\Interfaces;

/**
 * Class ConfigProvider
 *
 * @package Estasi\LaminasHelpers\Validator
 */
final class ConfigProvider implements Interfaces\ConfigProvider
{
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
            ],
            self::class        => [

            ],
        ];
    }
}
