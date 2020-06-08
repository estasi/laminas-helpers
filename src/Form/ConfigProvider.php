<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form;

use Estasi\LaminasHelpers\Interfaces\ConfigProvider as ConfigProviderInterface;

/**
 * Class ConfigProvider
 *
 * @package Estasi\LaminasHelpers\form
 */
final class ConfigProvider implements ConfigProviderInterface
{
    public const FORMS  = 'forms';
    public const FIELDS = 'fields';

    /**
     * @inheritDoc
     */
    public function __invoke()
    {
        return [
            self::DEPENDENCIES => [
                self::DEPENDENCIES_FACTORIES => [
                    FieldsPluginManager::class => Factory\PluginManager::class,
                    FormsPluginManager::class  => Factory\PluginManager::class,
                ],
            ],
            self::class        => [
                self::DEPENDENCIES_ABSTRACT_FACTORIES => [
                    Factory\AbstractForms::class,
                    Factory\AbstractField::class,
                ],
            ],
        ];
    }
}
