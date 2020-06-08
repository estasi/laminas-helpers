<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Interfaces;

/**
 * Interface ConfigProvider
 *
 * @package Estasi\LaminasHelpers\Interfaces
 */
interface ConfigProvider
{
    public const DEPENDENCIES                    = 'dependencies';
    public const DEPENDENCIES_INVOKABLES         = 'invokables';
    public const DEPENDENCIES_FACTORIES          = 'factories';
    public const DEPENDENCIES_ABSTRACT_FACTORIES = 'abstract_factories';
    public const DEPENDENCIES_ALIASES            = 'aliases';

    /**
     * Returns the component configuration as an array or generator
     *
     * @return array|\Generator
     */
    public function __invoke();
}
